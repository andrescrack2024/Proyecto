<?php
require_once 'db_config.php';
$error = '';
$success = '';

// Seguridad: Solo Admins
if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] != 'admin') {
    header("Location: login.php");
    exit;
}

// 1. Validar que tengamos un ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Error: ID de usuario no válido.");
}
$id_usuario_editar = $_GET['id'];

// 2. Cargar datos de las cajas (para el dropdown)
try {
    $stmt_cajas = $pdo->query("SELECT * FROM pisos_cajas ORDER BY nombre_ubicacion");
    $cajas_disponibles = $stmt_cajas->fetchAll();
} catch (Exception $e) {
    $cajas_disponibles = [];
    $error = "Error al cargar las cajas.";
}

// 3. PROCESAR EL FORMULARIO (CUANDO SE ENVÍA)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_completo = $_POST['nombre_completo'];
    $usuario = $_POST['usuario'];
    $rol = $_POST['rol'];
    $id_caja = $_POST['id_caja'];
    
    // Validaciones
    if (empty($nombre_completo) || empty($usuario) || empty($rol) || empty($id_caja)) {
        $error = "Por favor, complete todos los campos requeridos.";
    } elseif (!in_array($rol, ['admin', 'cajero'])) {
        $error = "Rol no válido.";
    } else {
        try {
            // Verificar si el nuevo nombre de usuario ya está en uso por OTRO usuario
            $stmt_check = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = ? AND id != ?");
            $stmt_check->execute([$usuario, $id_usuario_editar]);
            if ($stmt_check->fetch()) {
                $error = "El nombre de usuario '{$usuario}' ya está en uso por otro usuario.";
            }

            if (empty($error)) { // Continuar solo si no hay error de usuario duplicado

            // Verificar si la contraseña se va a cambiar
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];
            $sql_parts = [];
            $params = [];
            
            // Campos base
            $sql_parts[] = "nombre_completo = ?"; $params[] = $nombre_completo;
            $sql_parts[] = "usuario = ?"; $params[] = $usuario;
            $sql_parts[] = "rol = ?"; $params[] = $rol;
            $sql_parts[] = "id_caja_asignada = ?"; $params[] = $id_caja;
            
            // Si se escribió una contraseña nueva
            if (!empty($password)) {
                if ($password != $password_confirm) {
                    $error = "Las contraseñas no coinciden.";
                } else {
                    $password_hash = password_hash($password, PASSWORD_BCRYPT);
                    $sql_parts[] = "password_hash = ?"; $params[] = $password_hash;
                }
            }
            
            // Si no hay errores, actualizar
            if (empty($error)) {
                $sql = "UPDATE usuarios SET " . implode(", ", $sql_parts) . " WHERE id = ?";
                $params[] = $id_usuario_editar;
                
                $stmt_update = $pdo->prepare($sql);
                $stmt_update->execute($params);
                
                $success = "¡Usuario actualizado con éxito!";
                
                // Registrar en auditoría
                registrarLog($pdo, 'Admin Edita Usuario', "ID Usuario: $id_usuario_editar, Cambios: " . implode(", ", $sql_parts));
            }
            } // Fin del if (empty($error))

        } catch (Exception $e) {
            $error = "Error en la base de datos: " . $e->getMessage();
        }
    }
}

// 4. CARGAR DATOS DEL USUARIO (PARA MOSTRAR EN EL FORMULARIO)
try {
    $stmt_user = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt_user->execute([$id_usuario_editar]);
    $user = $stmt_user->fetch();
    
    if (!$user) {
        die("Error: Usuario no encontrado.");
    }
} catch (Exception $e) {
    die("Error al cargar usuario: " . $e->getMessage());
}

// Función de log (la necesitamos aquí también)
function registrarLog($pdo, $accion, $detalles = '') {
    try {
        $id_usuario = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $usuario = isset($_SESSION['user_usuario']) ? $_SESSION['user_usuario'] : 'Sistema';
        $stmt_log = $pdo->prepare("INSERT INTO logs_auditoria (id_usuario_accion, usuario_accion, accion, detalles) VALUES (?, ?, ?, ?)");
        $stmt_log->execute([$id_usuario, $usuario, $accion, $detalles]);
    } catch (Exception $e) {}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Smarque Bank</title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        /*
        * =================================
        * (DISEÑO MEJORADO) "AZUL CORPORATIVO"
        * =================================
        */
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
            --shadow-soft: 0 4px 12px rgba(0, 0, 0, 0.05);
            --shadow-medium: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        body, html { 
            margin: 0; 
            padding: 0; 
            font-family: 'Roboto', 'Segoe UI', -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; 
            background-color: var(--light-gray-bg); 
            /* (MODIFICADO) min-height para permitir que el contenido crezca */
            min-height: 100%; 
            display: flex; 
            flex-direction: column; 
        }
        
        /* (NUEVO) Header estilo Admin */
        .main-header { 
            width: 100%; 
            background-color: var(--white); 
            color: var(--text-dark); 
            padding: 12px 24px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: var(--shadow-soft);
            box-sizing: border-box;
            flex-shrink: 0; /* Evita que el header se encoja */
        }
        .logo { display: flex; align-items: center; gap: 8px; }
        .logo-icon { font-size: 2rem; color: var(--primary-blue); }
        .logo-text { font-size: 1.5rem; font-weight: bold; color: var(--dark-blue); }
        .main-header h1 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-right: 4rem;
        }

        /* Contenido centrado */
        .main-content { 
            flex-grow: 1; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            width: 100%; 
            padding: 40px 20px; /* Padding vertical añadido */
            box-sizing: border-box;
        }
        
        /* Tarjeta principal con el estilo de login */
        .container { 
            width: 90%; 
            max-width: 550px; /* (MODIFICADO) Más ancho para el formulario */
            background: var(--white); 
            border-radius: 12px; 
            box-shadow: var(--shadow-medium); 
            padding: 40px; 
            box-sizing: border-box; 
        }

        /* (DISEÑO MEJORADO) Estilos de Formulario */
        .form-group { margin-bottom: 20px; } /* Menos margen */
        .form-group label { 
            display: block; 
            font-size: 0.9em; 
            font-weight: 600; 
            margin-bottom: 6px; 
            color: var(--text-dark); 
        }
        .form-group input, .form-group select { 
            width: 100%; 
            padding: 12px 15px; /* Padding estándar */
            font-size: 1em; 
            border: 1px solid var(--medium-gray-border); 
            border-radius: 6px; 
            box-sizing: border-box; 
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .form-group input:focus, .form-group select:focus { 
            outline: none; 
            border-color: var(--primary-blue); 
            box-shadow: 0 0 0 3px rgba(0, 85, 165, 0.25);
        }

        /* (DISEÑO MEJORADO) Botón */
        .btn { 
            display: inline-block; 
            width: 100%; 
            padding: 16px; 
            font-size: 1.1em; 
            font-weight: 700; 
            color: white; 
            background-color: var(--primary-blue); 
            border: none; 
            border-radius: 6px; 
            cursor: pointer; 
            text-align: center; 
            transition: background-color 0.3s; 
        }
        .btn:hover { background-color: var(--secondary-blue); }

        /* (DISEÑO MEJORADO) Alertas */
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; font-size: 1em; text-align: center; }
        .alert-danger { background-color: var(--error-bg); color: var(--error-color); border: 1px solid var(--error-color); }
        .alert-success { background-color: var(--success-bg); color: var(--success-color); border: 1px solid var(--success-color); }

        /* (DISEÑO MEJORADO) Título y enlace de retorno */
        .container h2 {
            text-align: center; 
            color: var(--dark-blue); 
            margin-top: 0;
            margin-bottom: 2rem;
            font-family: 'Montserrat', sans-serif;
        }
        .container .back-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
        }
        .container .back-link a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
        }
        .container .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="logo">
            <i class="ph-fill ph-bank logo-icon"></i>
            <span class="logo-text">Smarque Bank</span>
        </div>
        <h1>Panel de Administración</h1>
    </header>
    
    <div class="main-content">
        <div class="container">
            <form method="POST" action="editar_usuario.php?id=<?php echo $id_usuario_editar; ?>">
                <h2>Editar Usuario</h2>
                
                <?php if ($error): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
                <?php if ($success): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>

                <div class="form-group">
                    <label for="nombre_completo">Nombre Completo</label>
                    <input type="text" id="nombre_completo" name="nombre_completo" value="<?php echo htmlspecialchars($user['nombre_completo']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="usuario">Nombre de Usuario (para login)</label>
                    <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($user['usuario']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="id_caja">Asignar a Caja / Piso</label>
                    <select id="id_caja" name="id_caja" required>
                        <option value="" disabled>Seleccione...</option>
                        <?php
                        foreach ($cajas_disponibles as $caja) {
                            $selected = ($user['id_caja_asignada'] == $caja['id']) ? 'selected' : '';
                            echo "<option value='{$caja['id']}' $selected>" . htmlspecialchars($caja['nombre_ubicacion']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="rol">Rol del Usuario</label>
                    <select id="rol" name="rol" required>
                        <option value="cajero" <?php echo ($user['rol'] == 'cajero') ? 'selected' : ''; ?>>Cajero / Asesor</option>
                        <option value="admin" <?php echo ($user['rol'] == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                    </select>
                </div>

                <hr style="border: 0; border-top: 1px solid var(--medium-gray-border); margin: 25px 0;">
                <p style="text-align: center; color: var(--text-light); font-size: 0.9rem; margin-top: -10px; margin-bottom: 15px;">
                    Deje los campos de contraseña vacíos si no desea cambiarla.
                </p>

                <div class="form-group">
                    <label for="password">Nueva Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Solo si desea cambiarla">
                </div>
                <div class="form-group">
                    <label for="password_confirm">Confirmar Nueva Contraseña</label>
                    <input type="password" id="password_confirm" name="password_confirm" placeholder="Solo si desea cambiarla">
                </div>

                <button type="submit" class="btn">Actualizar Usuario</button>
            </form>
            
            <p class="back-link">
                <a href="admin.php?vista=usuarios">Volver a la lista de usuarios</a>
            </p>
        </div>
    </div>
</body>
</html>