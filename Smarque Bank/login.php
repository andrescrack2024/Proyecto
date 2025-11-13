<?php
// 1. INCLUIR CONFIGURACIÓN
// Tu 'db_config.php' ya inicia la sesión y configura PDO para mostrar errores.
// No necesitamos 'session_start()' aquí.
require_once 'db_config.php';

// 2. INICIALIZAR VARIABLES
$error = '';
$success_msg = '';
$bloqueo_timestamp = null; // Para pasar el tiempo de bloqueo a JS

// Mantener los valores del formulario
$usuario_form = $_POST['usuario'] ?? '';
$password_form = $_POST['password'] ?? '';

// 3. MENSAJE DE ÉXITO (si viene de registro.php)
if (isset($_GET['registro']) && $_GET['registro'] == 'exitoso') {
    // (MODIFICADO) Mensaje para reflejar la aprobación pendiente
    $success_msg = '¡Registro exitoso! Su cuenta está en espera de aprobación.';
}

// 4. REVISAR SI EL USUARIO YA ESTÁ LOGUEADO
if (isset($_SESSION['user_id']) && isset($_SESSION['user_rol'])) {
    if ($_SESSION['user_rol'] == 'admin') {
        header("Location: admin.php");
    } else {
        header("Location: cajero.php");
    }
    exit;
}

// 5. REVISAR BLOQUEO TEMPORAL (antes de procesar el POST)
// Esto evita que un usuario bloqueado intente iniciar sesión
if (isset($_SESSION['bloqueo_usuario_temp'])) {
    try {
        $stmt_check = $pdo->prepare("SELECT bloqueo_hasta, estado FROM usuarios WHERE usuario = ?");
        $stmt_check->execute([$_SESSION['bloqueo_usuario_temp']]);
        $user_status = $stmt_check->fetch();

        if ($user_status && $user_status['estado'] == 'bloqueado') {
            $error = "Esta cuenta ha sido bloqueada permanentemente. Contacte al administrador.";
        } elseif ($user_status && $user_status['bloqueo_hasta']) {
            $bloqueo_fin_dt = new DateTime($user_status['bloqueo_hasta']);
            if (new DateTime() < $bloqueo_fin_dt) {
                // Sigue bloqueado
                $error = "Cuenta bloqueada temporalmente.";
                $bloqueo_timestamp = $bloqueo_fin_dt->getTimestamp();
            } else {
                // El bloqueo expiró, limpiar la variable de sesión
                unset($_SESSION['bloqueo_usuario_temp']);
            }
        }
    } catch (PDOException $e) {
        // Error de BD, mostrar un error genérico
        $error = "Error al verificar el estado de la cuenta. Intente más tarde.";
    }
}


// 6. PROCESAR EL FORMULARIO (SOLO SI NO ESTÁ YA BLOQUEADO)
if ($_SERVER["REQUEST_METHOD"] == "POST" && !$bloqueo_timestamp && empty($error)) {
    
    $usuario = $usuario_form;
    $password = $password_form;

    // Guardar usuario que intenta, para la revisión de bloqueo en la próxima recarga
    $_SESSION['bloqueo_usuario_temp'] = $usuario; 

    try {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $user = $stmt->fetch();

        // CASO 1: Usuario NO existe
        if (!$user) {
            $error = "Usuario o contraseña incorrectos.";
            $password_form = ''; // Borrar pass si el usuario no existe
        
        // CASO 2: Usuario con bloqueo PERMANENTE
        } elseif ($user['estado'] == 'bloqueado') {
            $error = "Esta cuenta ha sido bloqueada permanentemente. Contacte al administrador.";
        
        // (NUEVO) CASO 3: Usuario PENDIENTE de aprobación
        } elseif ($user['estado'] == 'pendiente') {
            $error = "Su cuenta ha sido creada y está en espera de aprobación por un administrador. Por favor, intente más tarde.";

        // CASO 4: Usuario con bloqueo TEMPORAL (aún activo)
        } elseif ($user['bloqueo_hasta'] && (new DateTime() < new DateTime($user['bloqueo_hasta']))) {
            $error = "Cuenta bloqueada temporalmente.";
            $bloqueo_timestamp = (new DateTime($user['bloqueo_hasta']))->getTimestamp();
        
        // CASO 5: ÉXITO de Login (Contraseña correcta)
        } elseif (password_verify($password, $user['password_hash'])) {
            
            // 1. Resetear contadores de fallo
            $stmt_reset = $pdo->prepare("UPDATE usuarios SET intentos_fallidos = 0, bloqueo_hasta = NULL, suspensiones = 0 WHERE id = ?");
            $stmt_reset->execute([$user['id']]);

            // 2. Limpiar variable de sesión temporal
            unset($_SESSION['bloqueo_usuario_temp']);

            // 3. Verificar si ya tiene sesión
            if (!empty($user['session_id']) && $user['session_id'] != session_id()) {
                $error = "Este usuario ya tiene una sesión activa en otro dispositivo.";
            } else {
                // 4. Iniciar sesión y guardar datos clave
                session_regenerate_id(true); // Previene "session fixation"
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_usuario'] = $user['usuario'];
                $_SESSION['user_caja_id'] = $user['id_caja_asignada'];
                $_SESSION['user_rol'] = $user['rol'];

                // 5. Guardar el ID de sesión actual en la BD
                $new_session_id = session_id();
                $stmt_update = $pdo->prepare("UPDATE usuarios SET session_id = ? WHERE id = ?");
                $stmt_update->execute([$new_session_id, $user['id']]);

                // 6. Registrar en auditoría (no crítico, por eso va en try/catch)
                try {
                    $stmt_log = $pdo->prepare("INSERT INTO logs_auditoria (id_usuario_accion, usuario_accion, accion, detalles) VALUES (?, ?, 'Login', ?)");
                    $stmt_log->execute([$user['id'], $user['usuario'], 'Inicio de sesión exitoso']);
                } catch (Exception $e) { /* Ignorar error de log si la tabla no existe */ }

                // 7. REDIRIGIR SEGÚN EL ROL
                if ($user['rol'] == 'admin') {
                    header("Location: admin.php");
                } else {
                    header("Location: cajero.php");
                }
                exit;
            }

        // CASO 6: FALLO de Login (Contraseña incorrecta)
        } else {
            $nuevos_intentos = $user['intentos_fallidos'] + 1;
            $password_form = $password; // Mantener la pass en el campo

            if ($nuevos_intentos >= 3) {
                // Se superó el límite, bloquear
                $nuevas_suspensiones = $user['suspensiones'] + 1;

                if ($nuevas_suspensiones >= 2) {
                    // === BLOQUEO PERMANENTE ===
                    $stmt_lock = $pdo->prepare("UPDATE usuarios SET estado = 'bloqueado', intentos_fallidos = 0, bloqueo_hasta = NULL, suspensiones = ? WHERE id = ?");
                    $stmt_lock->execute([$nuevas_suspensiones, $user['id']]);
                    $error = "Cuenta bloqueada permanentemente por múltiples suspensiones. Contacte al administrador.";
                } else {
                    // === BLOQUEO TEMPORAL (2 MINUTOS) ===
                    $bloqueo_fin_dt = (new DateTime())->add(new DateInterval('PT2M')); // 2 Minutos
                    $bloqueo_fin_sql = $bloqueo_fin_dt->format('Y-m-d H:i:s');
                    
                    $stmt_lock = $pdo->prepare("UPDATE usuarios SET intentos_fallidos = 0, bloqueo_hasta = ?, suspensiones = ? WHERE id = ?");
                    $stmt_lock->execute([$bloqueo_fin_sql, $nuevas_suspensiones, $user['id']]);
                    
                    $error = "Ha fallado 3 veces. Cuenta bloqueada por 2 minutos.";
                    $bloqueo_timestamp = $bloqueo_fin_dt->getTimestamp();
                }
            } else {
                // === AQUÍ SE CUENTAN LOS INTENTOS ===
                // Solo incrementar intentos (1 o 2)
                $stmt_inc = $pdo->prepare("UPDATE usuarios SET intentos_fallidos = ? WHERE id = ?");
                $stmt_inc->execute([$nuevos_intentos, $user['id']]);
                
                // Mensaje genérico por seguridad (para no revelar que el usuario es correcto)
                $error = "Usuario o contraseña incorrectos.";
            }

            // Registrar el fallo en auditoría
            try {
                $stmt_log = $pdo->prepare("INSERT INTO logs_auditoria (usuario_accion, accion, detalles) VALUES (?, 'Login Fallido', ?)");
                $stmt_log->execute([$usuario, 'Intento de login con contraseña incorrecta']);
            } catch (Exception $e) { /* Ignorar error de log */ }
        }

    } catch (PDOException $e) {
        // ESTO SE EJECUTARÁ SI CUALQUIER CONSULTA (SELECT, UPDATE) FALLA
        // Gracias a tu db_config.php
        $error = "Error fatal de base de datos: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Seguro - Smarque Bank</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@400;600;7V=p¡&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #0055A5;
            --secondary-blue: #0072CE;
            --gold-color: #FFBF00; 
            --dark-blue: #002b4f;
            --white: #FFFFFF;
            --light-gray-bg: #f4f7fc; 
            --medium-gray-border: #d1d9e6;
            --text-dark: #1a202c;
            --text-light: #4a5568;
            --error-color: #e53e3e; 
            --error-bg: #fed7d7;
            --success-color: #155724;
            --success-bg: #d4edda;
            --success-border: #c3e6cb;
            --shadow-soft: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-medium: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--light-gray-bg);
            color: var(--text-dark);
            line-height: 1.6;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh;
            padding: 20px;
            overflow-x: hidden;
        }
        
        .login-container {
            display: flex;
            max-width: 950px; 
            width: 100%;
            background-color: var(--white);
            box-shadow: var(--shadow-medium);
            border-radius: 12px; 
            overflow: hidden;
            animation: fadeInLoginForm 0.7s ease-out forwards;
        }

        @keyframes fadeInLoginForm {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .brand-section {
            flex-basis: 45%; 
            background: linear-gradient(145deg, var(--dark-blue), var(--primary-blue));
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center; 
            text-align: center;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }
        .brand-section::before { 
            content: ''; position: absolute; top: -50px; left: -50px;
            width: 150px; height: 150px; background: var(--gold-color);
            opacity: 0.15; border-radius: 50%; transform: rotate(45deg);
        }
        .brand-section::after { 
            content: ''; position: absolute; bottom: -70px; right: -70px;
            width: 200px; height: 200px; background: var(--secondary-blue);
            opacity: 0.1; border-radius: 50%;
        }
        
        .brand-logo i {
            font-size: 80px;
            margin-bottom: 1.5rem;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
            color: var(--white);
        }

        .brand-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.8rem; 
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }
        .brand-subtitle {
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem; 
            font-weight: 400;
            opacity: 0.9;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }
        .brand-highlight {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 2rem; 
            color: var(--gold-color);
            margin: 1.5rem 0;
            line-height: 1.3;
            text-transform: uppercase;
            position: relative;
            z-index: 1;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }
        .brand-footer {
            font-size: 0.8rem;
            opacity: 0.8;
            margin-top: auto; 
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.2);
            position: relative;
            z-index: 1;
        }
        
        .login-section {
            flex-basis: 55%; 
            padding: 40px; 
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-title {
            font-family: 'Montserrat', sans-serif;
            color: var(--dark-blue); 
            font-size: 1.6rem; 
            font-weight: 700;
            margin-bottom: 1rem; 
            text-align: center;
            position: relative;
            display: flex; 
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }
        .login-title::after { 
            content: '';
            position: absolute;
            bottom: -12px; 
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background-color: var(--gold-color);
            border-radius: 2px;
        }
        .form-wrapper {
            margin-top: 2.5rem; 
        }
        .input-group {
            position: relative;
            margin-bottom: 1.5rem; 
        }
        .input-group i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 15px;
            color: var(--primary-blue);
            font-size: 1rem; 
            opacity: 0.7;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px 12px 45px; 
            border: 1px solid var(--medium-gray-border);
            border-radius: 6px; 
            font-size: 0.95rem;
            color: var(--text-dark);
            transition: all 0.3s ease;
            background-color: #fdfdff;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: var(--secondary-blue);
            box-shadow: 0 0 0 3px rgba(0, 114, 206, 0.15);
            background-color: var(--white);
        }
        
        input:disabled {
            background-color: #e9ecef;
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        .login-button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: var(--white);
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600; 
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.8px; 
            box-shadow: var(--shadow-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }
        .login-button:hover {
            background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue));
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 85, 165, 0.3);
        }
        
        .register-link {
            text-align: center;
            margin: 1.5rem 0;
            font-size: 0.9rem;
            color: var(--text-light);
        }
        .register-link a {
            color: var(--primary-blue); 
            text-decoration: none;
            font-weight: 600;
        }
        .register-link a:hover {
            text-decoration: underline;
        }

        .back-link {
            text-align: center;
            margin: -0.5rem 0 1.5rem 0;
        }
        .back-link a {
            display: flex; 
            width: 100%;
            padding: 10px; 
            background-color: var(--white);
            color: var(--text-light); 
            border: 2px solid var(--medium-gray-border); 
            text-decoration: none;
            font-weight: 600; 
            font-size: 0.9rem;
            border-radius: 6px; 
            align-items: center;
            justify-content: center;
            gap: 0.5rem; 
            transition: all 0.3s ease;
        }
        .back-link a:hover {
            background-color: #f7faff; 
            color: var(--secondary-blue);
            border-color: var(--secondary-blue);
            text-decoration: none; 
            box-shadow: 0 2px 5px rgba(0, 114, 206, 0.1); 
        }
        
        .security-info {
            font-size: 0.75rem; 
            color: var(--text-light);
            text-align: center;
            margin-top: 2rem; 
            padding-top: 1rem;
            border-top: 1px solid var(--medium-gray-border);
        }
        .security-info i {
            margin-right: 0.3rem;
            color: var(--primary-blue);
        }
        
        .error-message-container { 
           text-align: center;
           min-height: 2.5em; 
        }
        .error-message { 
            color: var(--error-color);
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.75rem 1rem;
            background-color: var(--error-bg);
            border-radius: 6px;
            border: 1px solid var(--error-color);
            display: inline-flex; 
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem; 
        }
        .success-message {
            color: var(--success-color);
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.75rem 1rem;
            background-color: var(--success-bg);
            border-radius: 6px;
            border: 1px solid var(--success-border);
            display: inline-flex; 
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem; 
        }

        .timer-message {
            color: var(--error-color);
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Montserrat', sans-serif;
            padding: 1rem;
            background-color: var(--error-bg);
            border-radius: 6px;
            border: 2px solid var(--error-color);
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 1rem;
            box-shadow: 0 2px 5px rgba(229, 62, 62, 0.2);
        }
        .timer-message i {
            font-size: 1.2rem;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                max-width: 450px; 
            }
            .brand-section {
                padding: 30px 20px;
                flex-basis: auto; 
                min-height: 250px; 
            }
            .brand-title { font-size: 1.5rem; }
            .brand-subtitle { font-size: 0.9rem; margin-bottom: 1.5rem;}
            .brand-highlight { font-size: 1.6rem; margin: 1rem 0; }
            .login-section { padding: 30px 25px; }
            .login-title { font-size: 1.4rem; }
            .form-wrapper { margin-top: 2rem; }
        }
    </style>
</head>
<body>
    
    <div class="login-container">
        
        <div class="brand-section">
            <div class="brand-logo">
                <i class="fas fa-landmark"></i> </div>
            <div class="brand-title">SMARQUE BANK</div>
            <div class="brand-subtitle">SISTEMA DE GESTIÓN DE TURNOS</div>
            <div class="brand-highlight">ACCESO<br>DE PERSONAL</div>
            <div class="brand-footer">Smarque Bank &copy; <?php echo date("Y"); ?></div>
        </div>
        
        <div class="login-section">
            <h2 class="login-title"><i class="fas fa-shield-alt"></i> INICIO DE SESIÓN</h2>
            <div class="form-wrapper">
                
                <form method="POST" action="login.php"> 
                    
                    <div class="input-group">
                        <i class="fas fa-user"></i> 
                        <input type="text" name="usuario" placeholder="Usuario" required id="usuario" value="<?php echo htmlspecialchars($usuario_form); ?>">
                    </div>
                    
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Contraseña" required id="password" value="<?php echo htmlspecialchars($password_form); ?>">
                    </div>
                    
                    <button type="submit" class="login-button" id="login-button">
                        <i class="fas fa-sign-in-alt"></i> INGRESAR AL SISTEMA
                    </button>
                </form>
            </div>
            
            <div class="register-link">
                ¿Aún no tiene una cuenta? <a href="registro.php">Regístrese aquí</a>
            </div>
            
            
            <div class="back-link">
                <a href="index.php"> <i class="fas fa-arrow-left"></i> Volver atrás
                </a>
            </div>
            
            <div class="error-message-container" id="message-container">
                
                <?php if (!empty($error) && !$bloqueo_timestamp): ?>
                    <div class="error-message"> 
                        <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($success_msg)): ?>
                    <div class="success-message"> 
                        <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success_msg); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="security-info">
                <i class="fas fa-lock"></i> Transacciones seguras y protegidas. Todos los derechos reservados.
            </div>
        </div>
    </div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Obtener el timestamp de bloqueo (si existe) desde PHP
    const bloqueoTimestamp = <?php echo $bloqueo_timestamp ? $bloqueo_timestamp * 1000 : 'null'; ?>;
    
    // 2. Obtener elementos del DOM
    const usuarioInput = document.getElementById('usuario');
    const passwordInput = document.getElementById('password');
    const loginButton = document.getElementById('login-button');
    const messageContainer = document.getElementById('message-container');

    // 3. Función para deshabilitar/habilitar el formulario
    function deshabilitarForm(estado) {
        usuarioInput.disabled = estado;
        passwordInput.disabled = estado;
        loginButton.disabled = estado;
        
        if (estado) {
            loginButton.style.opacity = '0.6';
            loginButton.style.cursor = 'not-allowed';
        } else {
            loginButton.style.opacity = '1';
            loginButton.style.cursor = 'pointer';
        }
    }

    // 4. Función para iniciar el temporizador
    function iniciarTemporizador(tiempoFin) {
        deshabilitarForm(true);
        
        let timerDiv = document.createElement('div');
        timerDiv.id = 'timer-countdown';
        timerDiv.className = 'timer-message'; 
        
        messageContainer.innerHTML = ''; 
        messageContainer.appendChild(timerDiv);

        const intervalo = setInterval(() => {
            const ahora = new Date().getTime();
            const distancia = tiempoFin - ahora;

            if (distancia <= 0) {
                // CUANDO EL TIEMPO TERMINA
                clearInterval(intervalo);
                timerDiv.innerHTML = '<i class="fas fa-check-circle"></i> ¡Bloqueo terminado! Puede intentar de nuevo.';
                timerDiv.style.borderColor = 'var(--success-border)';
                timerDiv.style.backgroundColor = 'var(--success-bg)';
                timerDiv.style.color = 'var(--success-color)';
                deshabilitarForm(false);
                usuarioInput.focus();
                
            } else {
                // MIENTRAS EL TIEMPO CORRE
                const minutos = Math.floor((distancia % (1000 * 60 * 60)) / (1000 * 60));
                const segundos = Math.floor((distancia % (1000 * 60)) / 1000);
                timerDiv.innerHTML = `
                    <i class="fas fa-hourglass-half"></i> 
                    Cuenta bloqueada. Intente en: <strong>${minutos}m ${segundos}s</strong>
                `;
            }
        }, 1000);
    }

    // 5. Iniciar el script si hay un bloqueo activo
    if (bloqueoTimestamp) {
        const tiempoFin = new Date(bloqueoTimestamp).getTime();
        iniciarTemporizador(tiempoFin);
    } else {
        deshabilitarForm(false);
    }

    // 6. Enfocar el campo correcto
    const errorMensaje = "<?php echo $error; ?>";
    const exitoMensaje = "<?php echo $success_msg; ?>";

    if (errorMensaje && !bloqueoTimestamp) {
        // Si hay un error (ej: pass incorrecta), enfocar la contraseña
        passwordInput.focus();
        passwordInput.select(); 
    } else if (!errorMensaje && !bloqueoTimestamp) {
        // Si no hay error (o hay mensaje de éxito), enfocar el usuario
        usuarioInput.focus();
    }
    // Si hay un bloqueo, no se enfoca nada porque están deshabilitados.

});
</script>
</body>
</html>