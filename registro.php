<?php
require_once 'db_config.php'; // db_config.php debe tener session_start()
$error = '';
$success = '';

// (MODIFICADO) Obtener valores del POST para repoblar el formulario en caso de error
$nombre_completo_form = $_POST['nombre_completo'] ?? '';
$usuario_form = $_POST['usuario'] ?? '';
// NOTA: Las contraseñas no se repoblan por seguridad.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // (MODIFICADO) Asignar desde las variables ya filtradas
    $nombre_completo = $nombre_completo_form;
    $usuario = $usuario_form;
    $password = $_POST['password'] ?? ''; // Obtener contraseñas
    $password_confirm = $_POST['password_confirm'] ?? '';
    
    // El ID de caja se establece en 'null' por defecto.
    $id_caja = null; 
    
    // El rol se fuerza a 'cajero'.
    $rol = 'cajero'; 

    // --- (INICIO) VALIDACIÓN MEJORADA ---
    if (empty($nombre_completo) || empty($usuario) || empty($password)) {
        $error = "Por favor, complete todos los campos.";
    
    // (NUEVO) Validación de longitud de cadenas
    } elseif (strlen($nombre_completo) < 6) {
        $error = "El nombre completo debe tener al menos 6 caracteres.";
    } elseif (strlen($usuario) < 4) {
        $error = "El nombre de usuario debe tener al menos 4 caracteres.";
    } elseif (strlen($usuario) > 50) {
        $error = "El nombre de usuario no puede exceder los 50 caracteres.";
    } elseif (strlen($password) < 8) {
        $error = "La contraseña debe tener al menos 8 caracteres.";
    // --- (FIN) Validación de longitud de cadenas
    
    } elseif ($password != $password_confirm) {
        $error = "Las contraseñas no coinciden.";
    } elseif (empty($_POST['g-recaptcha-response'])) {
        $error = "Por favor, complete el reCAPTCHA.";
    } else {
        // --- Verificación de reCAPTCHA ---
        $recaptcha_secret = '6LeEjQksAAAAAGhlfertmGHl30dzNIz--LU8JqV2'; // <-- ¡IMPORTANTE! Pega tu clave secreta aquí
        $recaptcha_response = $_POST['g-recaptcha-response'];
        
        $verify_url = 'https://www.google.com/recaptcha/api/siteverify';
        $verify_data = http_build_query([
            'secret'   => $recaptcha_secret,
            'response' => $recaptcha_response,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ]);

        $options = ['http' => ['method' => 'POST', 'header' => 'Content-type: application/x-www-form-urlencoded', 'content' => $verify_data]];
        $context = stream_context_create($options);
        $verify_result = file_get_contents($verify_url, false, $context);
        $result_json = json_decode($verify_result);

        if ($result_json->success !== true) {
            $error = "La verificación reCAPTCHA ha fallado. Por favor, inténtelo de nuevo.";
        } else {
            try {
                // 1. Verificar si el nombre de usuario ya existe
                $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = ?");
                $stmt_check->execute([$usuario]);
                
                if ($stmt_check->fetchColumn() > 0) {
                    $error = "El nombre de usuario '{$usuario}' ya está en uso.";
                } else {
                    // 2. Si no existe, cifrar la contraseña
                    $password_hash = password_hash($password, PASSWORD_BCRYPT);

                    // 3. Insertar el nuevo usuario (ROL FORZADO A 'cajero' y ESTADO a 'pendiente' por defecto de BD)
                    $stmt_insert = $pdo->prepare(
                        "INSERT INTO usuarios (usuario, password_hash, nombre_completo, rol, id_caja_asignada) 
                         VALUES (?, ?, ?, 'cajero', ?)" // El rol se inserta directamente
                    );
                    
                    $stmt_insert->execute([$usuario, $password_hash, $nombre_completo, $id_caja]);

                    // Registrar en auditoría
                    try {
                        $actor = isset($_SESSION['user_usuario']) ? $_SESSION['user_usuario'] : 'Sistema';
                        $actor_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
                        
                        $stmt_log = $pdo->prepare("INSERT INTO logs_auditoria (id_usuario_accion, usuario_accion, accion, detalles) VALUES (?, ?, 'Creación Usuario', ?)");
                        $stmt_log->execute([$actor_id, $actor, "Nuevo usuario: $usuario, Rol: cajero"]);
                    } catch (Exception $e) { /* Ignorar error de log */ }

                    // (MODIFICADO) Redirigir a login.php para que vea el mensaje de "pendiente"
                    header("Location: login.php?registro=exitoso");
                    exit;
                }
            } catch (Exception $e) {
                $error = "Error en la base de datos: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- (NUEVO) Script de reCAPTCHA de Google -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <title>Smarque Bank - Registro de Usuario</title>
    <!-- Iconos y Fuentes del Diseño de Login -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* CSS IDÉNTICO AL DE LOGIN.PHP, CON 2 ADICIONES */
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
            /* (ADICIÓN) Estilo de Éxito para el mensaje de login */
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
        
        /* (MODIFICADO) Icono de Registro */
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
        /* (MODIFICADO) Texto de Registro */
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
        /* (MODIFICADO) Título de Registro */
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
            margin-bottom: 1.2rem; /* Menos espacio para más campos */
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
        
        /* (ADICIÓN) Estilos para SELECT (para que coincida con INPUT) */
        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px 15px 12px 45px; 
            border: 1px solid var(--medium-gray-border);
            border-radius: 6px; 
            font-size: 0.95rem;
            color: var(--text-dark);
            transition: all 0.3s ease;
            background-color: #fdfdff;
            /* (ADICIÓN) Para que el select se vea igual */
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        
        /* (ADICIÓN) Flecha para el SELECT */
        .select-wrapper { position: relative; }
        .select-wrapper::after {
            content: '\f078'; /* Icono de flecha de Font Awesome */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-blue);
            pointer-events: none;
        }
        
        input[type="text"]:focus,
        input[type="password"]:focus,
        select:focus {
            outline: none;
            border-color: var(--secondary-blue);
            box-shadow: 0 0 0 3px rgba(0, 114, 206, 0.15);
            background-color: var(--white);
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
            margin-top: 1rem; /* Espacio después del captcha */
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

        /* === (NUEVO) ESTILO PARA EL BOTÓN DE VOLVER === */
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
        /* === FIN ESTILO BOTÓN VOLVER === */
        
        .security-info {
            font-size: 0.75rem; 
            color: var(--text-light);
            text-align: center;
            margin-top: 1.5rem; 
            padding-top: 1rem;
            border-top: 1px solid var(--medium-gray-border);
        }
        .security-info i {
            margin-right: 0.3rem;
            color: var(--primary-blue);
        }
        
        .error-message-container { 
           text-align: center;
           min-height: 2.5em; /* Evita saltos de layout */
           margin-bottom: 1rem;
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
    
    <!-- ESTRUCTURA HTML DEL DISEÑO DE LOGIN -->
    <div class="login-container">
        
        <!-- SECCIÓN DE MARCA (Adaptada a Registro) -->
        <div class="brand-section">
            <div class="brand-logo">
                <i class="fas fa-user-plus"></i> <!-- Icono de Registro -->
            </div>
            <div class="brand-title">SMARQUE BANK</div>
            <div class="brand-subtitle">SISTEMA DE GESTIÓN DE TURNOS</div>
            <div class="brand-highlight">REGISTRO<br>DE PERSONAL</div>
            <div class="brand-footer">Smarque Bank &copy; <?php echo date("Y"); ?></div>
        </div>
        
        <!-- SECCIÓN DE LOGIN (Con TUS campos y lógica de REGISTRO) -->
        <div class="login-section">
            <h2 class="login-title"><i class="fas fa-edit"></i> CREAR CUENTA DE CAJERO</h2>
            <div class="form-wrapper">
                
                <!-- TU FORMULARIO (action y method) -->
                <form method="POST" action="registro.php"> 
                    
                    <!-- TUS MENSAJES DE ERROR Y ÉXITO -->
                    <div class="error-message-container">
                        <?php if (!empty($error)): ?>
                            <div class="error-message"> 
                                <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($success)): // Aunque $success no se usa en tu PHP, lo dejo por si acaso ?>
                            <div class="success-message"> 
                                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- CAMPO nombre_completo -->
                    <div class="input-group">
                        <i class="fas fa-user"></i> 
                        <!-- (MODIFICADO) Añadido 'value' para repoblar el campo -->
                        <input type="text" name="nombre_completo" placeholder="Nombre Completo" required value="<?php echo htmlspecialchars($nombre_completo_form); ?>">
                    </div>

                    <!-- CAMPO usuario -->
                    <div class="input-group">
                        <i class="fas fa-id-card"></i> 
                        <!-- (MODIFICADO) Añadido 'value' para repoblar el campo -->
                        <input type="text" name="usuario" placeholder="Nombre de Usuario (para login)" required value="<?php echo htmlspecialchars($usuario_form); ?>">
                    </div>
                    
                    <!-- CAMPO password -->
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Contraseña" required>
                    </div>

                    <!-- CAMPO password_confirm -->
                    <div class="input-group">
                        <i class="fas fa-check-double"></i>
                        <input type="password" name="password_confirm" placeholder="Confirmar Contraseña" required>
                    </div>

                    <!-- (MODIFICADO) CAMPO id_caja (SELECT) ELIMINADO -->
                    
                    <!-- CAMPO reCAPTCHA -->
                    <div class="g-recaptcha" data-sitekey="6LeEjQksAAAAAFhlE3mt6CD779CQpOh7-1XpvUco" style="margin-bottom: 1rem; transform:scale(1.0); transform-origin:0 0;"></div>
                    
                    <!-- TU BÓTON (type="submit") -->
                    <button type="submit" class="login-button">
                        <i class="fas fa-user-plus"></i> REGISTRAR USUARIO
                    </button>
                </form>
            </div>
            
            
            <!-- TU ENLACE DE "Volver a Login" -->
            <div class="register-link">
                ¿Ya tiene una cuenta? <a href="login.php">Ingrese aquí</a>
            </div>

            <!-- === (NUEVO) BOTÓN DE VOLVER A principal.php === -->
            <div class="back-link">
                <a href="index.php">
                    <i class="fas fa-arrow-left"></i> Volver atrás
                </a>
            </div>
            <!-- === FIN NUEVO BOTÓN === -->
            
            <div class="security-info">
                <i class="fas fa-lock"></i> Transacciones seguras y protegidas.
            </div>
        </div>
    </div>

</body>
</html>