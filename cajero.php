<?php
// AHORA ES cajero.php
require_once 'db_config.php';

// Seguridad: Verificar que el usuario esté logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Seguridad: Verificar que sea un CAJERO (no un admin)
if ($_SESSION['user_rol'] != 'cajero') {
    header("Location: login.php?error=rol_invalido");
    exit;
}

// (El resto del código de seguridad de sesión sigue igual)
$stmt_check = $pdo->prepare("SELECT session_id FROM usuarios WHERE id = ?");
$stmt_check->execute([$_SESSION['user_id']]);
$db_session_id = $stmt_check->fetchColumn();
if ($db_session_id !== session_id()) {
    session_destroy();
    header("Location: login.php?error=duplicate_session");
    exit;
}

// ==========================================================
// MODIFICACIÓN: Obtener ID y Nombre de la caja
// ==========================================================
$stmt = $pdo->prepare("SELECT p.nombre_ubicacion, u.id_caja_asignada 
                       FROM usuarios u 
                       LEFT JOIN pisos_cajas p ON u.id_caja_asignada = p.id 
                       WHERE u.id = ?");
$stmt->execute([$_SESSION['user_id']]);
$caja = $stmt->fetch();

// Asignación más segura
$nombre_caja = 'No asignada';
$id_caja = null;

if ($caja) {
    $nombre_caja = $caja['nombre_ubicacion'] ?: 'No asignada'; // Si el nombre es NULL
    $id_caja = $caja['id_caja_asignada'];
}

$_SESSION['user_caja_nombre'] = $nombre_caja;
$_SESSION['user_caja_id'] = $id_caja; // (IMPORTANTE) Guardamos el ID de la caja en la sesión
// ==========================================================
// FIN DE LA MODIFICACIÓN
// ==========================================================

// Lógica de cierre de sesión
if (isset($_GET['logout'])) {
    // Registrar en auditoría
    try {
        $stmt_log = $pdo->prepare("INSERT INTO logs_auditoria (id_usuario_accion, usuario_accion, accion, detalles) VALUES (?, ?, 'Logout', ?)");
        $stmt_log->execute([$_SESSION['user_id'], $_SESSION['user_usuario'], 'Cierre de sesión exitoso']);
    } catch (Exception $e) { /* Ignorar error de log */ }

    $stmt_clear = $pdo->prepare("UPDATE usuarios SET session_id = NULL WHERE id = ?");
    $stmt_clear->execute([$_SESSION['user_id']]);
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cajero - Smarque Bank</title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        /*
        * =================================
        * (DISEÑO MEJORADO) "AZUL CORPORATIVO" PARA CAJERO
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
           
            /* Colores de botones funcionales */
            --color-rojo: #dc3545;
            --color-rojo-hover: #c82333;
            --color-verde: #28a745;
            --color-verde-hover: #218838;
            --color-gris: #6c757d;
            --color-gris-hover: #5a6268;
        }

        body, html { 
            margin: 0; 
            padding: 0; 
            font-family: 'Roboto', 'Segoe UI', -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; 
            background-color: var(--light-gray-bg); 
            height: 100%; 
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
        }
        .logo { display: flex; align-items: center; gap: 8px; }
        .logo-icon { font-size: 2rem; color: var(--primary-blue); }
        .logo-text { font-size: 1.5rem; font-weight: bold; color: var(--dark-blue); }
       
        /* (NUEVO) Menú de usuario en el header */
        .admin-user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
            font-weight: 500;
            background-color: var(--light-gray-bg);
            color: var(--text-dark);
            padding: 8px 14px;
            border-radius: 8px;
        }
        .admin-user-menu i {
            font-size: 1.4rem;
            color: var(--primary-blue);
        }

        /* Contenido centrado */
        .main-content { 
            flex-grow: 1; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            width: 100%; 
            padding: 20px;
            box-sizing: border-box;
        }
       
        /* Tarjeta principal con el estilo de login */
        .container { 
            width: 90%; 
            max-width: 450px; 
            background: var(--white); 
            border-radius: 12px; 
            box-shadow: var(--shadow-medium); 
            padding: 40px; 
            box-sizing: border-box; 
        }

        /* (DISEÑO MEJORADO) Botones */
        .btn { 
            display: inline-block; 
            width: 100%; 
            padding: 16px; /* Un poco más pequeño que el login */
            font-size: 1.1em; 
            font-weight: 700; 
            color: white; 
            background-color: var(--primary-blue); /* Default es azul */
            border: none; 
            border-radius: 6px; 
            cursor: pointer; 
            text-align: center; 
            transition: background-color 0.3s; 
            box-sizing: border-box; 
        }
        .btn:hover { background-color: var(--secondary-blue); }
       
        /* Tus clases de botón (intactas) */
        .btn-secondary { background-color: var(--color-gris); }
        .btn-secondary:hover { background-color: var(--color-gris-hover); }
        .btn-success { background-color: var(--color-verde); }
        .btn-success:hover { background-color: var(--color-verde-hover); }
        .btn-danger { background-color: var(--color-rojo); }
        .btn-danger:hover { background-color: var(--color-rojo-hover); }
        .btn:disabled { background-color: #cccccc; cursor: not-allowed; }

        /* Alertas (estilo login) */
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; font-size: 1em; text-align: center; }
        .alert-danger { background-color: var(--error-bg); color: var(--error-color); border: 1px solid var(--error-color); }
        .alert-success { background-color: var(--success-bg); color: var(--success-color); border: 1px solid var(--success-color); }

        /* (DISEÑO MEJORADO) Cabecera de la tarjeta */
        .admin-header { 
            width: 100%; 
            text-align: center; 
            border-bottom: 1px solid var(--medium-gray-border); 
            padding-bottom: 20px; 
            margin-bottom: 30px; 
        }
        .admin-header h2 { margin: 0; font-size: 1.8em; color: var(--text-dark); }
        .admin-header .caja-info { 
            font-size: 1.3em; 
            font-weight: 700; 
            color: var(--primary-blue); 
            margin: 5px 0; 
        }
        .admin-nav-links { margin-top: 15px; display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; }
        .admin-nav-links a { 
            text-decoration: none; 
            font-weight: 600; 
            font-size: 1em; 
            color: var(--secondary-blue); /* Azul secundario */
            padding: 5px; 
        }
        .admin-nav-links a.logout-link { color: var(--color-rojo); }

        /* (DISEÑO MEJORADO) Controles */
        .admin-controls { display: flex; flex-direction: column; gap: 15px; }
       
        /* (DISEÑO MEJORADO) Display del turno */
        .turno-en-atencion { 
            text-align: center; 
            padding: 25px; 
            background: var(--light-gray-bg); 
            border-radius: 8px; 
            border: 1px solid var(--medium-gray-border); 
            margin-bottom: 20px; 
        }
        .turno-en-atencion h3 { margin: 0 0 10px 0; font-size: 1.2em; color: var(--text-light); }
        .turno-en-atencion #turno-atendiendo { 
            font-size: 3.5em; 
            font-weight: 700; 
            color: var(--primary-blue); /* Azul principal */
            line-height: 1.1;
        }
    </style>
</head>
<body>
   
    <header class="main-header">
        <div class="logo">
            <i class="ph-fill ph-bank logo-icon"></i>
            <span class="logo-text">Smarque Bank</span>
        </div>
        <div class="admin-user-menu">
            <i class="ph-fill ph-user-circle"></i>
            <span><?php echo htmlspecialchars($_SESSION['user_usuario']); ?> (Cajero)</span>
        </div>
    </header>

    <div class="main-content">
        <div class="container">
            <div class="admin-header">
                <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_usuario']); ?></h2>
                <div class="caja-info">Usted está en: <?php echo htmlspecialchars($nombre_caja); ?></div>
                <div class="admin-nav-links">
                    <a href="public.php" target="_blank">Ver Pantalla Pública</a>
                    <a href="cajero.php?logout=1" class="logout-link">Cerrar Sesión</a>
                </div>
            </div>

            <div class="turno-en-atencion">
                <h3>Atendiendo al turno:</h3>
                <div id="turno-atendiendo">---</div>
                <input type="hidden" id="id-turno-atendiendo" value="0">
            </div>
           
            <div id="admin-mensaje" style="margin-bottom: 20px;"></div>

            <div class="admin-controls">
                <button class="btn btn-success" id="btn-llamar" onclick="llamarSiguiente()">Llamar Siguiente</button>
                <button class="btn" id="btn-rellamar" onclick="reLlamar()">Re-Llamar Turno</button>
                <button class="btn btn-secondary" id="btn-saltar" onclick="actualizarTurno('saltado')">Saltar Turno</button>
                <button class="btn btn-danger" id="btn-finalizar" onclick="actualizarTurno('atendido')">Finalizar Atención</button>
            </div>
        </div>
    </div>

    <script>
        const displayTurno = document.getElementById('turno-atendiendo');
        const inputIdTurno = document.getElementById('id-turno-atendiendo');
        const mensajeDiv = document.getElementById('admin-mensaje');
        document.addEventListener('DOMContentLoaded', cargarTurnoActivo);
        
        function cargarTurnoActivo() {
            const formData = new FormData(); formData.append('accion', 'cargar_turno_activo');
            fetch('ajax.php', { method: 'POST', body: formData }).then(res => res.json())
                .then(data => {
                    if (data.success && data.turno) { actualizarDisplay(data.turno); } else { actualizarDisplay(null); }
                });
        }
        
        function llamarSiguiente() {
            const formData = new FormData(); formData.append('accion', 'llamar_siguiente');
            fetch('ajax.php', { method: 'POST', body: formData }).then(res => res.json())
                .then(data => {
                    if (data.success) {
                        actualizarDisplay(data.turno);
                        mostrarMensaje('Turno ' + data.turno.codigo_turno + ' llamado.', 'success');
                    } else {
                        mostrarMensaje(data.message, 'danger');
                        if (data.code == 'NO_TURNS' || data.code == 'ALREADY_ACTIVE') { cargarTurnoActivo(); }
                    }
                }).catch(err => mostrarMensaje('Error de red.', 'danger'));
        }
        
        function reLlamar() {
            const idTurno = inputIdTurno.value;
            if (idTurno == 0) { mostrarMensaje('No hay ningún turno activo para re-llamar.', 'danger'); return; }
           
            // Lógica de re-llamada real
            const formData = new FormData();
            formData.append('accion', 'rellamar_turno');
            formData.append('id_turno', idTurno);

            fetch('ajax.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => { 
                    if (data.success) {
                        mostrarMensaje(`Re-llamando al turno ${displayTurno.innerText}...`, 'success');
                    } else {
                        mostrarMensaje(data.message, 'danger');
                    }
                });
        }
        
        function actualizarTurno(nuevoEstado) {
            const idTurno = inputIdTurno.value;
            if (idTurno == 0) { mostrarMensaje('No hay ningún turno activo para ' + nuevoEstado, 'danger'); return; }
            const formData = new FormData();
            formData.append('accion', 'actualizar_turno');
            formData.append('id_turno', idTurno);
            formData.append('estado', nuevoEstado);
            fetch('ajax.php', { method: 'POST', body: formData }).then(res => res.json())
                .then(data => {
                    if (data.success) {
                        mostrarMensaje(`Turno ${displayTurno.innerText} marcado como ${nuevoEstado}.`, 'success');
                        actualizarDisplay(null);
                    } else { mostrarMensaje(data.message, 'danger'); }
                }).catch(err => mostrarMensaje('Error de red.', 'danger'));
        }
        
        function actualizarDisplay(turno) {
            if (turno) {
                displayTurno.innerText = turno.codigo_turno; inputIdTurno.value = turno.id; deshabilitarBotones(true);
            } else {
                displayTurno.innerText = '---'; inputIdTurno.value = 0; deshabilitarBotones(false);
            }
        }
        
        function deshabilitarBotones(atendiendo) {
            document.getElementById('btn-llamar').disabled = atendiendo;
            document.getElementById('btn-rellamar').disabled = !atendiendo;
            document.getElementById('btn-saltar').disabled = !atendiendo;
            document.getElementById('btn-finalizar').disabled = !atendiendo;
        }
        
        function mostrarMensaje(texto, tipo) {
            mensajeDiv.innerHTML = `<div class="alert alert-${tipo}">${texto}</div>`;
            setTimeout(() => { mensajeDiv.innerHTML = ''; }, 3000);
        }
    </script>
</body>
</html>