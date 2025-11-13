<?php require_once 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smarque Bank - Gestor de Turnos en Línea</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <style>
        /*
        * =================================
        * DISEÑO BASE (ADAPTADO DE REGISTRADURÍA)
        * =================================
        */

        :root {
            /* Paleta de colores principal (del diseño 1) */
            --primary-blue: #0055A5;
            --secondary-blue: #0072CE;
            --gold-color: #FFBF00; 
            --dark-blue: #002b4f; 
            --hero-overlay-start: rgba(0, 43, 79, 0.85); 
            --hero-overlay-end: rgba(0, 25, 50, 0.95); 
            --white: #FFFFFF;
            --light-gray: #edf2f7; 
            --card-bg: #FFFFFF; 
            --shadow-light: 0 6px 12px rgba(0, 51, 102, 0.07); 
            --shadow-medium: 0 10px 20px rgba(0, 51, 102, 0.12);
            --text-dark: #1a202c; 
            --text-light: #4a5568; 
            --success: #38a169; 
            --info: #3182ce; 
            --warning: #dd6b20; 
            --error: #dc3545; 
            --border-color: #e2e8f0;
            
            /* Fuentes (del diseño 1) */
            --font-principal: 'Segoe UI', Roboto, system-ui, -apple-system, BlinkMacSystemFont, "Helvetica Neue", Arial, sans-serif;
            --font-titulos: 'Montserrat', sans-serif; /* Asegúrate de importar Montserrat si la usas, o se usará la de respaldo */
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: var(--font-principal); }
        
        body { 
            background-color: var(--light-gray); 
            color: var(--text-dark); 
            line-height: 1.65; 
            -webkit-font-smoothing: antialiased; 
            -moz-osx-font-smoothing: grayscale; 
        }

        /*
        * =================================
        * HERO HEADER (FUSIÓN DE AMBOS DISEÑOS)
        * =================================
        */
        
        .hero-main {
            /* Fondo del diseño 1 */
            background-image: 
                linear-gradient(var(--hero-overlay-start), var(--hero-overlay-end)),
                url('https://cdn.prod.website-files.com/63b042656c21e611f6f8be44/6720a70c50776f3eee5ae814_6395f90578c5b96b82e91b1b_group-diverse-people-having-business-meeting_1_40.webp'); /* URL del diseño 2 */
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            color: white; 
            padding: 4rem 20px 5rem; 
            text-align: center; 
            position: relative;
            border-bottom: 6px solid var(--gold-color);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            min-height: 60vh; /* Altura mínima */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        /* Logo (adaptado para el logo del diseño 2) */
        .logo-hero-main { 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 15px; 
            margin-bottom: 1.5rem;
        }
        .logo-hero-main .logo-icon {
            font-size: 3.5rem; /* 60px de alto */
            color: var(--white);
            filter: drop-shadow(0 2px 3px rgba(0,0,0,0.4));
        }
        .site-title-group-main .site-title {
            font-size: 1.5rem; 
            font-family: var(--font-titulos);
            font-weight: 700;
            color: var(--white);
            margin: 0;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
            text-align: left;
        }
        .site-title-group-main .site-subtitle {
            font-size: 1rem;
            color: rgba(255,255,255,0.85);
            margin: 0;
            line-height: 1.2;
            font-family: var(--font-titulos);
            font-weight: 400;
            text-align: left;
        }

        /* Títulos (tomados del diseño 2) */
        .hero-main h1 { 
            font-family: var(--font-titulos);
            font-size: 2.8rem; font-weight: 700; margin-bottom: 1rem; text-shadow: 0 2px 5px rgba(0,0,0,0.5); 
            line-height: 1.2;
        }
        .hero-main .hero-subtext { font-size: 1.2rem; font-weight: 300; opacity: 0.9; max-width: 700px; margin: 0 auto 2rem auto;}
        
        /* Botones (Funcionalidad del diseño 2, Estilo del diseño 1) */
        .hero-button-group {
            display: flex;
            flex-wrap: wrap; 
            justify-content: center;
            gap: 1.2rem;
        }
        
        .btn-hero {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.75rem;
            background: var(--gold-color); color: var(--dark-blue); 
            padding: 0.9rem 2.2rem; border-radius: 50px; text-decoration: none;
            font-weight: 700; transition: all 0.3s ease; font-size: 1rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2); border: 2px solid var(--gold-color);
            text-transform: uppercase; letter-spacing: 0.5px;
            cursor: pointer; /* Para que se vea como botón */
        }
        .btn-hero:hover {
            background: var(--white); color: var(--dark-blue); border-color: var(--white);
            transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.25);
        }
        
        /* Botón secundario */
        .btn-hero.secondary {
            background: transparent;
            color: var(--white);
            border-color: var(--white);
        }
        .btn-hero.secondary:hover {
            background: var(--white);
            color: var(--dark-blue);
            border-color: var(--white);
        }
        
        /*
        * =================================
        * SECCIONES DE CONTENIDO (DEL DISEÑO 1)
        * =================================
        */
        .container { max-width: 1200px; margin: 0 auto; padding: 3rem 20px; }

        .section-header { text-align: center; margin-bottom: 3rem; }
        .section-header h2 {
            font-family: var(--font-titulos); color: var(--dark-blue);
            font-size: 2rem; font-weight: 700; margin-bottom: 0.8rem;
            position: relative; display: inline-block; padding-bottom: 0.5rem;
        }
        .section-header h2::after {
            content: ''; position: absolute; bottom: 0; left: 50%;
            transform: translateX(-50%); width: 70px; height: 4px;
            background-color: var(--gold-color); border-radius: 2px;
        }
        .section-header p.subtitle { color: var(--text-light); max-width: 700px; margin: 0.5rem auto 0; font-size: 1.05rem; }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }
        .service-card {
            background: var(--card-bg); border-radius: 10px;
            padding: 2rem 1.5rem; box-shadow: var(--shadow-light);
            transition: all 0.3s ease; border-top: 4px solid var(--secondary-blue);
            display: flex; flex-direction: column; height: 100%;
            text-align: center;
        }
        .service-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-medium); border-top-color: var(--gold-color); }
        .service-icon { font-size: 2.8rem; color: var(--primary-blue); margin-bottom: 1.2rem; }
        .service-card:hover .service-icon { color: var(--gold-color); }
        .service-card h3 {
            color: var(--dark-blue); font-family: var(--font-titulos);
            font-size: 1.25rem; font-weight: 600; margin-bottom: 0.8rem;
        }
        .service-card p { color: var(--text-light); margin-bottom: 1.5rem; flex-grow: 1; font-size: 0.9rem; }
        
        /* Sección de información (del diseño 1) */
        .info-section-main {
            background-color: var(--dark-blue); color: var(--white);
            padding: 4rem 2rem; text-align: center; margin-top: 3rem;
        }
        .info-container { max-width: 900px; margin: 0 auto; }
        .info-container h2 {
            font-family: var(--font-titulos); font-size: 2rem;
            font-weight: 700; margin-bottom: 1.2rem; color: var(--gold-color);
        }
        .info-container p { font-size: 1.05rem; margin-bottom: 2rem; max-width: 750px; margin-left: auto; margin-right: auto; opacity: 0.9;}

        /* Footer (del diseño 1) */
        .footer-main {
            background-color: var(--dark-blue); color: #bdc3c7;
            padding: 3rem 2rem 1.5rem;
        }
        .footer-container {
            max-width: 1200px; margin: 0 auto; display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2rem; margin-bottom: 2rem;
        }
        .footer-column h3 {
            font-family: var(--font-titulos); font-size: 1.1rem;
            font-weight: 600; margin-bottom: 1.2rem; color: var(--gold-color);
            padding-bottom: 0.5rem; border-bottom: 2px solid var(--gold-color); display:inline-block;
        }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 0.7rem; }
        .footer-links a { color: var(--white); text-decoration: none; transition: color 0.3s; font-size: 0.9rem; }
        .footer-links a:hover { color: var(--gold-color); padding-left: 5px; }
        .footer-bottom { text-align: center; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1); font-size: 0.85rem; }
        .footer-bottom p { margin-bottom: 0.5rem; }
        .footer-bottom a { color: var(--gold-color); margin: 0 0.5rem; }


        /*
        * =================================
        * ESTILOS DE MODALES (DEL DISEÑO 2, RE-DISEÑADOS)
        * =================================
        */
        .modal-overlay {
            display: none; 
            position: fixed;
            z-index: 1000;
            left: 0; top: 0;
            width: 100%; height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.75); /* Oscurecido como en diseño 1 */
            align-items: center; 
            justify-content: center;
            padding: 10px;
        }
        .modal-content {
            background-color: var(--card-bg); /* Blanco */
            margin: auto;
            padding: 24px 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 550px;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3); /* Sombra de diseño 1 */
            animation: fadeInModal 0.4s;
            font-family: var(--font-principal);
        }
        @keyframes fadeInModal { 
            from {opacity: 0; transform: translateY(-20px);} 
            to {opacity: 1; transform: translateY(0);} 
        }

        .modal-close {
            color: #aaa;
            position: absolute;
            top: 15px; right: 20px;
            font-size: 32px; /* Más grande, como diseño 1 */
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
            z-index: 1001;
        }
        .modal-close:hover,
        .modal-close:focus { color: var(--text-dark); text-decoration: none; }
        
        /* Formulario (del diseño 2, re-diseñado) */
        .form-group { margin-bottom: 20px; }
        .form-group label { 
            display: block; 
            font-size: 1rem; 
            font-weight: 600; 
            margin-bottom: 8px; 
            color: var(--text-dark); 
        }
        .form-group input, .form-group select { 
            width: 100%; 
            padding: 12px 15px; 
            font-size: 1rem; 
            border: 1px solid var(--border-color); 
            border-radius: 6px; 
            box-sizing: border-box; 
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .form-group input:focus, .form-group select:focus { 
            outline: none; 
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(0, 85, 165, 0.25); /* Sombra de focus azul */
        }

        /* Botón primario del modal (adaptado) */
        .btn { 
            display: inline-block; width: 100%; padding: 12px; 
            font-size: 1.1rem; font-weight: 600; color: var(--white); 
            background-color: var(--primary-blue); 
            border: none; 
            border-radius: 6px; cursor: pointer; text-align: center; 
            transition: background-color 0.3s; text-decoration: none;
            box-sizing: border-box;
        }
        .btn:hover { background-color: var(--secondary-blue); }

        /* Botón secundario del modal (adaptado) */
        .btn-secondary {
            background-color: var(--text-light); /* Gris claro */
        }
        .btn-secondary:hover {
            background-color: var(--text-dark);
        }

        /* Alertas (del diseño 2) */
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; font-size: 1em; text-align: center; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        
        /* Ticket (del diseño 2, re-diseñado) */
        .ticket-info {
            text-align: center; background-color: var(--card-bg);
            border: 1px solid var(--border-color); 
            border-left: 8px solid var(--gold-color); /* Borde dorado */
            padding: 30px; border-radius: 8px;
            box-shadow: var(--shadow-light);
        }
        .ticket-info h2 { margin-top: 0; color: var(--dark-blue); font-size: 1.8em; }
        .ticket-info .turno-numero {
            font-size: 5rem; font-weight: 700; color: var(--primary-blue);
            margin: 10px 0; line-height: 1;
            /* Animación eliminada para un look más "corporativo" */
        }
        .ticket-info p { font-size: 1.2em; color: var(--text-light); margin: 5px 0; }

        /* Tabla de consulta (del diseño 2, re-diseñada) */
        #resultados-consulta table {
            width: 100%; border-collapse: collapse; margin-top: 20px;
            font-size: 0.9em; border-radius: 8px; overflow: hidden;
            box-shadow: var(--shadow-light);
        }
        #resultados-consulta th, #resultados-consulta td {
            padding: 12px 15px; text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        #resultados-consulta th {
            background-color: var(--light-gray); color: var(--dark-blue);
            font-size: 0.85em; text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        #resultados-consulta tr:last-child td { border-bottom: none; }
        #resultados-consulta td strong { color: var(--primary-blue); font-weight: 600; }
        #resultados-consulta .estado-espera { color: var(--warning); font-weight: bold; }
        #resultados-consulta .estado-atendido { color: var(--success); font-weight: bold; }
        #resultados-consulta .estado-saltado { color: var(--error); font-weight: bold; }
        #resultados-consulta .estado-atendiendo { color: var(--info); font-weight: bold; }

        /*
        * =================================
        * RESPONSIVE (DEL DISEÑO 1)
        * =================================
        */
        @media (max-width: 992px) {
            .hero-main h1 { font-size: 2.4rem; }
        }
        @media (max-width: 768px) {
            .hero-main { padding: 3rem 15px 4rem; min-height: 50vh; }
            .hero-main h1 { font-size: 2rem; } .hero-main .hero-subtext { font-size: 1rem; }
            .section-header h2 { font-size: 1.8rem; }
            .footer-container { grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); }
        }

    </style>
</head>
<body>

    <header class="hero-main">
        <div class="logo-hero-main">
            <i class="ph-fill ph-bank logo-icon"></i> 
            <div class="site-title-group-main">
                <div class="site-title">Smarque Bank</div>
                <div class="site-subtitle">SISTEMA DE GESTIÓN TURNUS</div>
            </div>
        </div>
        
        <h1>GESTOR DE TURNOS EN LÍNEA</h1>
        <p class="hero-subtext">Solicita y consulta tus turnos de forma rápida y segura desde cualquier lugar.</p>
        
        <div class="hero-button-group">
            <button id="btn-abrir-modal-consulta" class="btn-hero">
                <i class="fas fa-search"></i> CONSULTAR MI TURNO
            </button>
            <button id="btn-abrir-modal-generar" class="btn-hero secondary">
                <i class="fas fa-ticket-alt"></i> SOLICITAR UN TURNO
            </button>
                <a href="public.php" target="_blank" class="btn-hero secondary">
                 <i class="fas fa-tv"></i> PANTALLA DE TURNOS
            </a>
        </div>
        
    </header>

    <div class="container">
        <section id="tramites" class="services-section">
            <div class="section-header">
                <h2>NUESTROS SERVICIOS</h2>
                <p>Accede a nuestras herramientas de gestión de turnos de forma fácil y eficiente.</p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-ticket-alt"></i></div>
                    <h3>Solicitud de Turno</h3>
                    <p>Genera un nuevo turno para cualquiera de nuestros servicios disponibles. Rápido, fácil y sin filas.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-search"></i></div>
                    <h3>Consulta de Turno</h3>
                    <p>Ingresa tu número de cédula y verifica el estado de todos los turnos que has solicitado con nosotros.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-tv"></i></div>
                    <h3>Pantalla Pública</h3>
                    <p>Sigue el estado de los turnos en tiempo real a través de nuestra pantalla de visualización pública.</p>
                </div>
            </div>
        </section>
    </div>

 
    
    <section class="info-section-main">
        <div class="info-container">
        
            <h2>SMARQUE BANK MÁS CERCA DE TI</h2>
            <p>Innovamos continuamente para brindarle un servicio más eficiente, seguro y transparente a todos nuestros clientes.</p>
            
            <a href="login.php" class="btn-hero open-login">
            
                <i class="fas fa-user-check"></i> Acceso Interno
                
            </a>
            
        </div>
    </section>

    <footer class="footer-main">
        <div class="footer-container">
            <div class="footer-column">
                <h3>Servicios Clave</h3>
                <ul class="footer-links">
                    <li><a href="#">Solicitar Turno</a></li>
                    <li><a href="#">Consultar Turno</a></li>
                    <li><a href="#">Ver Pantalla Pública</a></li>
                    <li><a href="#">Servicios Corporativos</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Información Útil</h3>
                <ul class="footer-links">
                    <li><a href="#">Noticias</a></li>
                    <li><a href="#">Sedes y Horarios</a></li>
                    <li><a href="#">Normatividad</a></li>
                    <li><a href="#">Protección de Datos</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Transparencia</h3>
                <ul class="footer-links">
                    <li><a href="#">Rendición de Cuentas</a></li>
                    <li><a href="#">Informes de Gestión</a></li>
                    <li><a href="#">PQRSDF</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Contacto y Soporte</h3>
                <ul class="footer-links">
                    <li><a href="#"><i class="fas fa-phone"></i> Línea Nacional de Atención</a></li>
                    <li><a href="#"><i class="fas fa-envelope"></i> Escríbanos</a></li>
                    <li><a href="#"><i class="fas fa-map-marker-alt"></i> Directorio de Oficinas</a></li>
                    <li><a href="#"><i class="fab fa-whatsapp"></i> Chat de Ayuda</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Smarque Bank S.A. - Todos los derechos reservados &copy; <?php echo date("Y"); ?></p>
            <p>
                <a href="#">Términos y Condiciones</a> | 
                <a href="#">Política de Privacidad</a> | 
                <a href="#">Mapa del Sitio</a>
            </p>
        </div>
    </footer>


    <div id="modal-consulta" class="modal-overlay">
        <div class="modal-content">
            <span class="modal-close" id="btn-cerrar-modal-consulta">&times;</span>
            
            <h2 style="text-align: center; color: var(--dark-blue); margin-top: 0; font-family: var(--font-titulos);">Consulta tus Turnos</h2>
            <p style="text-align: center; margin-bottom: 25px; color: var(--text-light);">Ingresa tu cédula para ver tu historial de turnos.</p>

            <div class="form-group">
                <label for="cedula_consulta">Número de Cédula</label>
                <input type="text" id="cedula_consulta" name="cedula_consulta" required>
            </div>
            
            <button id="btn-consultar-cedula" class="btn">Buscar Turnos</button>

            <div id="resultados-consulta" style="margin-top: 20px;">
                </div>
        </div>
    </div>

    <div id="modal-generar" class="modal-overlay">
        <div class="modal-content">
            <span class="modal-close" id="btn-cerrar-modal-generar">&times;</span>
            
            <div id="form-container">
                <div id="mensaje"></div>
                <form id="turno-form">
                    <h2 style="text-align: center; color: var(--dark-blue); margin-top: 0; margin-bottom: 30px; font-family: var(--font-titulos);">Genere su Turno</h2>
                    <div class="form-group">
                        <label for="cedula">Ingrese su Cédula</label>
                        <input type="text" id="cedula" name="cedula" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_atencion">Seleccione Tipo de Atención</label>
                        <select id="tipo_atencion" name="tipo_atencion" required>
                            <option value="" disabled selected>Seleccione...</option>
                            <?php
                            $stmt = $pdo->query("SELECT id, nombre FROM tipos_atencion ORDER BY nombre");
                            while ($fila = $stmt->fetch()) {
                                echo "<option value='{$fila['id']}'>{$fila['nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn" id="btn-generar">Generar Turno</button>
                </form>
            </div>

            <div id="ticket-container" style="display: none;">
                <div class="ticket-info">
                    <h2>¡Turno generado!</h2>
                    <p>Usted tiene el turno:</p>
                    <div id="turno-numero" class="turno-numero">---</div> 
                    <p id="turno-estado">Estado: En espera...</p>
                    <p>Será llamado en:</p>
                    <p id="turno-ubicacion" style="font-weight: 700; font-size: 1.5em;">(Pendiente de asignación)</p>
                    <br>
                    <button onclick="nuevoTurno()" class="btn btn-secondary">Generar otro turno</button>
                    <a href="public.php" target="_blank" class="btn" style="margin-top: 10px;">Ver Pantalla de Turnos</a>
                </div>
            </div>

        </div>
    </div>


    <script>
        // --- LÓGICA DE FORMULARIO/TICKET ---
        const formContainer = document.getElementById('form-container');
        const ticketContainer = document.getElementById('ticket-container');
        const mensajeDiv = document.getElementById('mensaje');
        const turnoForm = document.getElementById('turno-form');

        turnoForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const cedula = document.getElementById('cedula').value;
            const tipo_atencion = document.getElementById('tipo_atencion').value;

            if (!cedula || !tipo_atencion) {
                mostrarMensaje('Por favor complete todos los campos.', 'danger');
                return;
            }

            const formData = new FormData();
            formData.append('accion', 'generar_turno');
            formData.append('cedula', cedula);
            formData.append('id_tipo_atencion', tipo_atencion);

            fetch('ajax.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    formContainer.style.display = 'none'; 
                    document.getElementById('turno-numero').innerText = data.turno.codigo_turno;
                    ticketContainer.style.display = 'block'; 
                    mostrarMensaje('Turno generado con éxito', 'success', document.querySelector('#ticket-container .ticket-info')); 
                } else {
                    mostrarMensaje(data.message || 'Error al generar el turno.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarMensaje('Error de conexión con el servidor.', 'danger');
            });
        });

        function nuevoTurno() {
            ticketContainer.style.display = 'none';
            formContainer.style.display = 'block';
            turnoForm.reset();
            mensajeDiv.innerHTML = '';
            const ticketAlert = document.querySelector('#ticket-container .alert');
            if(ticketAlert) ticketAlert.remove();
        }

        function mostrarMensaje(texto, tipo, contenedor = mensajeDiv) {
            const alertasViejas = contenedor.querySelectorAll('.alert');
            alertasViejas.forEach(alerta => alerta.remove());
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${tipo}`;
            alertDiv.innerText = texto;
            if (contenedor.classList.contains('ticket-info')) {
                 contenedor.prepend(alertDiv);
            } else {
                 contenedor.innerHTML = ''; 
                 contenedor.appendChild(alertDiv);
            }
        }
        
        // --- LÓGICA DEL MODAL DE CONSULTA ---
        const modalConsulta = document.getElementById('modal-consulta');
        const btnAbrirConsulta = document.getElementById('btn-abrir-modal-consulta');
        const btnCerrarConsulta = document.getElementById('btn-cerrar-modal-consulta');
        const btnConsultarCedula = document.getElementById('btn-consultar-cedula');
        const inputCedulaConsulta = document.getElementById('cedula_consulta');
        const resultadosDiv = document.getElementById('resultados-consulta');
        
        // Bonus: Botón en sección info también abre un modal (el de generar)
        const btnAbrirPortal = document.getElementById('btn-abrir-portal-servicios');

        btnAbrirConsulta.onclick = function() {
            modalConsulta.style.display = 'flex';
            inputCedulaConsulta.value = '';
            resultadosDiv.innerHTML = '';
        }
        btnCerrarConsulta.onclick = function() {
            modalConsulta.style.display = 'none';
        }
        
        btnConsultarCedula.onclick = function() { 
            consultarTurnos();
        };
        inputCedulaConsulta.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                consultarTurnos();
            }
        });

        function consultarTurnos() {
            const cedula = inputCedulaConsulta.value;
            if (cedula.trim() === '') {
                resultadosDiv.innerHTML = '<p class="alert alert-danger">Por favor, ingrese una cédula.</p>';
                return;
            }
            resultadosDiv.innerHTML = '<p style="text-align: center;">Buscando...</p>';
            const formData = new FormData();
            formData.append('accion', 'consultar_turnos');
            formData.append('cedula', cedula);
            fetch('ajax.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                renderizarResultados(data);
            })
            .catch(error => {
                console.error('Error en consulta:', error);
                resultadosDiv.innerHTML = '<p class="alert alert-danger">Error de conexión con el servidor.</p>';
            });
        }

        function renderizarResultados(data) {
            if (!data.success) {
                resultadosDiv.innerHTML = `<p class="alert alert-danger">${data.message}</p>`;
                return;
            }
            if (data.turnos.length === 0) {
                resultadosDiv.innerHTML = '<p style="text-align: center;">No se encontraron turnos para esta cédula.</p>';
                return;
            }
            let html = '<table><thead><tr><th>Turno</th><th>Servicio</th><th>Estado</th><th>Lugar</th><th>Fecha Solicitud</th></tr></thead><tbody>';
            data.turnos.forEach(turno => {
                let claseEstado = `estado-${turno.estado.toLowerCase().replace(' ', '-')}`; // Para "atendiendo"
                let fecha = new Date(turno.fecha_creacion).toLocaleString('es-CO', { 
                    year: 'numeric', month: 'numeric', day: 'numeric', 
                    hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true 
                });
                let caja = turno.caja || 'N/A';
                let estadoCapitalizado = turno.estado.charAt(0).toUpperCase() + turno.estado.slice(1);
                html += `
                    <tr>
                        <td><strong>${turno.codigo_turno}</strong></td>
                        <td>${turno.tipo_atencion}</td>
                        <td class="${claseEstado}">${estadoCapitalizado}</td>
                        <td>${caja}</td>
                        <td>${fecha}</td>
                    </tr>
                `;
            });
            html += '</tbody></table>';
            resultadosDiv.innerHTML = html;
        }

        // --- LÓGICA PARA EL MODAL DE GENERACIÓN ---
        const modalGenerar = document.getElementById('modal-generar');
        const btnAbrirGenerar = document.getElementById('btn-abrir-modal-generar');
        const btnCerrarGenerar = document.getElementById('btn-cerrar-modal-generar');

        btnAbrirGenerar.onclick = function() {
            // Reiniciar el modal al estado de "formulario" cada vez que se abre
            nuevoTurno(); // Esta función ya resetea el form y oculta el ticket
            modalGenerar.style.display = 'flex';
        }
        
     
        
        btnCerrarGenerar.onclick = function() {
            modalGenerar.style.display = 'none';
        }


        // --- Lógica de Cierre de Modales (clic afuera) ---
        window.onclick = function(event) {
            if (event.target == modalConsulta) {
                modalConsulta.style.display = 'none';
            }
            if (event.target == modalGenerar) {
                modalGenerar.style.display = 'none';
            }
        }
        
    </script>

</body>
</html>