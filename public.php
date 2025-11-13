<?php require_once 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smarque Bank - Pantalla de Turnos</title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
   
    <style>
        /*
        * =================================
        * (DISEÑO MEJORADO) "AZUL CORPORATIVO" (v2 - Pulido)
        * =TA SIDO 100% PRESERVADA.
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
            --shadow-soft: 0 4px 12px rgba(0, 0, 0, 0.05);
            --shadow-medium: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        @keyframes pulse-glow {
            0%, 100% {
                color: var(--primary-blue);
                text-shadow: 0 0 20px rgba(0, 85, 165, 0.4);
            }
            50% {
                color: var(--secondary-blue);  
                text-shadow: 0 0 40px rgba(0, 114, 206, 0.8);
            }
        }
       
        /* (NUEVO) Animación de fundido para el carrusel de turnos */
        .turno-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* (NUEVO) Estilos para el overlay de audio */
        #audio-overlay {
            position:fixed; 
            inset:0; 
            background:rgba(0,43,79,0.85); /* Usar --dark-blue con opacidad */
            color:white; 
            display:flex; 
            flex-direction:column; 
            justify-content:center; 
            align-items:center; 
            z-index:9999; 
            cursor:pointer;
            transition: opacity 0.5s ease; /* Transición de fundido */
            backdrop-filter: blur(5px);
        }
        #audio-overlay i {
            font-size: 80px;
            color: var(--color-acento); /* Usar color dorado */
        }
        #audio-overlay h1 {
            font-size: 2.5rem; 
            font-weight: 700; 
            margin-top: 20px;
            color: var(--white);
            text-align: center;
        }
        #audio-overlay p {
            font-size: 1.5rem; 
            margin-top: 10px;
            color: var(--color-texto-sidebar);
            text-align: center;
        }
        /* Fin de estilos de overlay */


        /* Estilos Globales */
        body, html {
            margin: 0; padding: 0;  
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;  
            background-color: var(--light-gray-bg);  
            height: 100vh;  /* Esto es clave para el layout de escritorio */
            display: flex;  
            flex-direction: column;  
            overflow: hidden;  
        }

        /* Header (Como en admin.php) */
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
            flex-shrink: 0;  
            z-index: 10;
        }
        .logo { display: flex; align-items: center; gap: 8px; }
        .logo-icon { font-size: 2rem; color: var(--primary-blue); }  
        .logo-text { font-size: 1.5rem; font-weight: bold; color: var(--dark-blue); }

        /* Contenedor para Fecha y Reloj */
        .header-datetime {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }
        /* Estilo para la Fecha */
        #fecha-actual {
            font-size: 1rem;
            font-weight: 600;
            color: var(--primary-blue);
            text-transform: capitalize;
        }
        /* Reloj Digital */
        #reloj-digital {
            font-size: 1.75rem;
            font-weight: 500;
            color: var(--text-dark);  
            position: static;
            transform: none;
        }

        .turno-facil-logo {
            display: flex; align-items: center; gap: 8px;
            background-color: var(--primary-blue);  
            color: var(--white);  
            border-radius: 9999px;
            padding: 6px 14px;
            font-weight: 600;
            font-size: 0.9em;
        }
        .turno-facil-logo i { font-size: 1.2rem; font-weight: bold; }

        /* --- Layout de Pantalla Pública --- */
        .public-wrapper {
            display: flex;
            flex-grow: 1;  /* Esto empuja el footer hacia abajo en desktop */
            padding: 25px;
            gap: 25px;
            box-sizing: border-box;
            overflow-y: auto;  
            min-height: 0;  
            position: relative;
            z-index: 1;
        }
       
        /* Marca de agua sutil */
        .public-wrapper::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 500px;
            height: 500px;
            transform: translate(-50%, -50%);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 256 256'%3E%3Cpath fill='%23002b4f' d='M232 88H24a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h208a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8ZM40 104v16a8 8 0 0 1-16 0v-16a8 8 0 0 1 16 0Zm32 0v16a8 8 0 0 1-16 0v-16a8 8 0 0 1 16 0Zm32 0v16a8 8 0 0 1-16 0v-16a8 8 0 0 1 16 0Zm32 0v16a8 8 0 0 1-16 0v-16a8 8 0 0 1 16 0Zm32 0v16a8 8 0 0 1-16 0v-16a8 8 0 0 1 16 0Zm32 0v16a8 8 0 0 1-16 0v-16a8 8 0 0 1 16 0Zm40 72H16a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h224a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8Zm-48-88H72a8 8 0 0 0-8 8v48a8 8 0 0 0 8 8h112a8 8 0 0 0 8-8V96a8 8 0 0 0-8-8Zm-56 48a12 12 0 1 1 12-12a12 12 0 0 1-12 12Zm-8-104.37L132.69 48H128a8 8 0 0 0-8 8v16h24V56a8 8 0 0 0-4.69-7.37L144 45.1v-4.41a8 8 0 0 0-16 0Z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            opacity: 0.02;  
            z-index: 1;
        }

        /* --- Estilo de Tarjetas (General) --- */
        .card {
            background: var(--white);  
            border-radius: 12px;  
            box-shadow: var(--shadow-medium);  
            display: flex;
            flex-direction: column;
            overflow: hidden;  
            position: relative;
            z-index: 2;
        }
        .card-header {
            background-color: var(--dark-blue);  
            color: var(--white);  
            padding: 15px 25px;
            font-size: 1.5rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        .card-body {
            padding: 25px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
        }

        /* --- Columna Izquierda: Turno Actual --- */
        .turno-actual-card {
            flex-grow: 1;  
        }

        #turno-actual-numero {
            font-size: 14rem;  
            font-weight: 800;
            line-height: 1.1;
            color: var(--primary-blue);  
            animation: pulse-glow 2.5s ease-in-out infinite;
        }
       
        .caja-display {
            width: 100%;
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 6px solid var(--gold-color);  
        }

        .caja-display-label {
            font-size: 1.5rem;
            font-weight: 500;
            color: var(--text-light);
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        #turno-actual-caja {
            font-size: 4rem;  
            font-weight: 600;
            color: var(--text-dark);  
        }

        /* --- Columna Derecha: Próximos Turnos --- */
        .proximos-card {
            flex-basis: 380px;  
            flex-shrink: 0;
        }

        .proximos-card .card-body {
            padding: 0;
            justify-content: flex-start;  
        }

        #proximos-turnos-lista {
            list-style: none;
            padding: 0;
            margin: 0;
            width: 100%;
        }
        #proximos-turnos-lista li {
            font-size: 2.2rem;
            font-weight: 600;
            color: var(--text-dark);  
            padding: 20px 25px;
            border-bottom: 1px solid #f0f0f0;
            text-align: center;
        }
        #proximos-turnos-lista li:last-child {
            border-bottom: none;
        }
       
        /* Estado de "sin turnos" (se usa en el JS) */
        .placeholder-turno {
            font-size: 5rem;
            font-weight: 700;
            color: #ccc;
        }
        .placeholder-caja {
            font-size: 2rem;
            font-weight: 500;
            color: #ccc;
        }

        /* === ESTILOS DE TICKER DE NOTICIAS === */
        .ticker-wrap {
            width: 100%;
            overflow: hidden;
            background-color: var(--white);
            border-top: 1px solid var(--medium-gray-border);
            border-bottom: 1px solid var(--medium-gray-border);
            box-shadow: 0 -2px 5px rgba(0,0,0,0.03);
            flex-shrink: 0;  
            z-index: 5;
        }
        .ticker {
            display: inline-block;
            padding-left: 100%;  
            white-space: nowrap;
            animation: ticker-scroll 30s linear infinite;
            font-size: 1.1rem;
            color: var(--text-dark);
            padding-top: 10px;
            padding-bottom: 10px;
        }
        .ticker span {
            margin: 0 2.5rem;  
            color: var(--text-light);
        }
        .ticker span strong {
            color: var(--primary-blue);  
        }
        @keyframes ticker-scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }


        /* === ESTILOS DE PIE DE PÁGINA === */
        .main-footer {
            flex-shrink: 0;  
            background-color: var(--dark-blue);  
            color: var(--white);  
            padding: 18px 25px;
            text-align: center;
            font-size: 1.1rem;
            font-weight: 500;
            box-shadow: 0 -4px 6px -1px rgba(0,0,0,0.1);  
            z-index: 10;  
        }
        .main-footer p {
            margin: 0;
            padding: 0;
        }

       
        /* ================================================= */
        /* === (AÑADIDO) BLOQUE RESPONSIVE PARA MÓVILES === */
        /* ================================================= */
        /* Estas reglas SÓLO se aplican si la pantalla 
           mide 768px de ancho o menos (móviles) */
        @media (max-width: 768px) {
           
            /* 1. Permitir scroll en móvil Y ASEGURAR ALTURA MÍNIMA */
            body, html {
                min-height: 100vh; /* <-- CAMBIO 1: Para empujar footer abajo */
                height: auto;     /* Permite que la página crezca */
                overflow: auto;   /* Permite scroll si la página crece */
            }

            /* 2. Ajustar el header */
            .main-header {
                padding: 10px 15px;
            }
            .logo-text {
                display: none; /* Ocultar "Smarque Bank" (solo icono) */
            }
            .logo-icon {
                font-size: 1.8rem;
            }
            .header-datetime {
                display: none; /* Ocultar fecha/hora para dar espacio */
            }
            .turno-facil-logo {
                font-size: 0.8em;
                padding: 4px 10px;
            }

            /* 3. Contenido principal: APILAR las tarjetas */
            .public-wrapper {
                flex-direction: column; /* Lo más importante: apila las tarjetas */
                padding: 15px;
                gap: 15px;
                overflow-y: visible; /* El scroll lo maneja el body ahora */
            }

            /* 4. Ajustar tamaños de fuentes grandes */
            .turno-actual-card .card-body {
                padding: 20px;
            }
            #turno-actual-numero {
                font-size: 7rem; /* Reducir el número gigante */
            }
            #turno-actual-caja {
                font-size: 2.2rem; /* Reducir el texto de la caja */
            }
            .caja-display-label {
                font-size: 1.1rem;
            }
            .placeholder-turno {
                font-size: 4rem;
            }
            .card-header {
                font-size: 1.2rem;
                padding: 12px 20px;
            }

            /* 5. Ajustar tarjeta de próximos */
            .proximos-card {
                flex-basis: auto; /* Permitir que tome el ancho completo */
            }
            #proximos-turnos-lista li {
                font-size: 1.6rem;
                padding: 14px 20px;
            }

            /* 6. Ajustar Ticker y Footer */
            .ticker {
                font-size: 0.9rem;
            }
            .main-footer {
                font-size: 0.9rem;
                padding: 20px 15px; /* <-- CAMBIO 2: Más padding (más "larguito") */
            }
            
            /* (NUEVO) Ajustar overlay de audio para móviles */
            #audio-overlay h1 {
                font-size: 1.8rem;
            }
            #audio-overlay p {
                font-size: 1.1rem;
                padding: 0 20px;
            }
        }

    </style>
</head>
<body>

    <!-- (NUEVO) Overlay de activación de audio -->
    <div id="audio-overlay">
        <i class="ph-fill ph-speaker-simple-slash"></i>
        <h1>Audio Desactivado</h1>
        <p>Haga clic o toque la pantalla para activar el sonido</p>
    </div>

    <header class="main-header">
        <div class="logo">
            <i class="ph-fill ph-bank logo-icon"></i>  
            <span class="logo-text">Smarque Bank</span> 
        </div>
       
        <div class="header-datetime">
            <div id="fecha-actual"></div>
            <div id="reloj-digital">00:00:00</div>
        </div>

        <div class="turno-facil-logo">
            <i class="ph-fill ph-ticket"></i>
            <span>TURNO FÁCIL</span>
        </div>
    </header>

    <div class="public-wrapper">

        <div class="turno-actual-card card">
            <div class="card-header">
                Turno Actual
            </div>
            <div class="card-body">
                <div id="turno-actual-numero" class="placeholder-turno">---</div>
               
                <div class="caja-display">
                    <h3 class="caja-display-label">Diríjase a:</h3>
                    <div id="turno-actual-caja" class="placeholder-caja">Esperando...</div>
                </div>
            </div>
        </div>

        <div class="proximos-card card">
            <div class="card-header">
                Próximos
            </div>
            <div class="card-body">
                <ul id="proximos-turnos-lista">
                    <!-- Contenido llenado por JS -->
                </ul>
            </div>
        </div>
    </div>  
   
    <div class="ticker-wrap">
        <div class="ticker">
            <span>Bienvenido a Smarque Bank.</span>
            <span><strong>Aviso:</strong> El horario de atención es de 8:00 AM a 4:00 PM.</span>
            <span>Gracias por su paciencia, pronto será atendido.</span>
            <span>Recuerde que puede usar nuestra App para transacciones rápidas.</span>
            <span>Bienvenido a Smarque Bank.</span>
        </div>
    </div>

    <footer class="main-footer">
        <p>Bienvenido a su Banco. Su tiempo es valioso.</p>
    </footer>


    <script>
        // --- LÓGICA DEL RELOJ Y FECHA ---
        function actualizarRelojYFecha() {
            const relojEl = document.getElementById('reloj-digital');
            const fechaEl = document.getElementById('fecha-actual');  
            const ahora = new Date();

            if (relojEl) {
                const hora = ahora.getHours().toString().padStart(2, '0');
                const minutos = ahora.getMinutes().toString().padStart(2, '0');
                const segundos = ahora.getSeconds().toString().padStart(2, '0');
                relojEl.textContent = `${hora}:${minutos}:${segundos}`;
            }
           
            if (fechaEl) {
                const opcionesFecha = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                fechaEl.textContent = ahora.toLocaleDateString('es-CO', opcionesFecha);
            }
        }
        setInterval(actualizarRelojYFecha, 1000);
        actualizarRelojYFecha();  

       
        // ==================================================
        // --- (INICIO) LÓGICA DE ACTUALIZACIÓN DE TURNOS (MODIFICADA) ---
        // ==================================================
       
        const turnoNumeroEl = document.getElementById('turno-actual-numero');
        const turnoCajaEl = document.getElementById('turno-actual-caja');
        const proximosListaEl = document.getElementById('proximos-turnos-lista');
       
        let ultimosProximosStr = ''; 
       
        // (NUEVO) Almacén para los turnos activos y el índice del carrusel
        let turnosActivosLista = [];
        let turnoActualIndex = 0;

        // (FUNCIÓN 1 - MODIFICADA) Solo obtiene datos y actualiza "Próximos"
        async function actualizarPantalla() {
            try {
                const formData = new FormData();
                formData.append('accion', 'obtener_datos_publicos');

                const response = await fetch('ajax.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();

                if (data.success) {
                    // (MODIFICADO) Guarda la lista de turnos activos para el carrusel
                    turnosActivosLista = data.turnos_activos || [];

                    // --- Actualizar Próximos Turnos (Sin cambios) ---
                    proximosListaEl.innerHTML = '';  
                    let nuevosProximosStr = ''; 

                    if (data.proximos && data.proximos.length > 0) {
                        data.proximos.forEach(turno => {
                            const li = document.createElement('li');
                            li.textContent = turno.codigo_turno;
                            proximosListaEl.appendChild(li);
                            nuevosProximosStr += turno.codigo_turno + ','; 
                        });
                    } else {
                        const li = document.createElement('li');
                        li.textContent = '-';
                        li.style.color = '#ccc';
                        proximosListaEl.appendChild(li);
                    }
                   
                    if (nuevosProximosStr !== ultimosProximosStr) {
                        if (ultimosProximosStr !== '') {  
                            reproducirSonidoProximo();
                        }
                        ultimosProximosStr = nuevosProximosStr;  
                    }
                    // --- Fin de la sección "Próximos" ---
                }

            } catch (error) {
                console.error("Error al actualizar la pantalla:", error);
            }
        }

        // (FUNCIÓN 2 - NUEVA) Rota el display principal
        function rotarTurnoActual() {
            // 1. Quitar animación anterior para poder re-aplicarla
            turnoNumeroEl.classList.remove('turno-fade-in');
            turnoCajaEl.classList.remove('turno-fade-in');
           
            // 2. Forzar un "reflow" (repintado) del navegador
            void turnoNumeroEl.offsetWidth; 

            // 3. Comprobar si hay turnos para mostrar
            if (turnosActivosLista.length > 0) {
               
                // 4. Avanzar al siguiente turno o volver al inicio
                if (turnoActualIndex >= turnosActivosLista.length) {
                    turnoActualIndex = 0; // Volver al inicio
                }
               
                const turno = turnosActivosLista[turnoActualIndex];
               
                // 5. Actualizar el HTML
                turnoNumeroEl.textContent = turno.codigo_turno;
                turnoNumeroEl.classList.remove('placeholder-turno');
               
                turnoCajaEl.textContent = turno.nombre_ubicacion;
                turnoCajaEl.classList.remove('placeholder-caja');
               
                // 6. (IMPORTANTE) Llamar a la función de sonido
                // El sonido solo se reproduce si el turno es diferente al último sonado
                reproducirSonido(turno.codigo_turno, turno.nombre_ubicacion);

                // 7. Incrementar el índice para la próxima rotación
                turnoActualIndex++;

            } else {
                // No hay turnos activos en ninguna caja
                turnoNumeroEl.textContent = '---';
                turnoNumeroEl.classList.add('placeholder-turno');
               
                turnoCajaEl.textContent = 'Esperando...';
                turnoCajaEl.classList.add('placeholder-caja');
               
                // Resetear el sonido para que el próximo turno suene
                ultimoTurnoSonado = ''; 
            }
           
            // 8. Añadir la clase de animación para el fundido
            turnoNumeroEl.classList.add('turno-fade-in');
            turnoCajaEl.classList.add('turno-fade-in');
        }

        // --- (MODIFICADO) Iniciar los Timers ---
        // Timer 1: Busca datos cada 3 segundos
        setInterval(actualizarPantalla, 3000); 
       
        // Timer 2: Rota el display cada 20 segundos (TU CAMBIO)
        setInterval(rotarTurnoActual, 20000); 
       
        // Carga inicial de datos
        actualizarPantalla(); 
       
        // (NUEVO) Llamar a la rotación 100ms después de la carga inicial
        // para que no esté vacío los primeros 5 segundos
        setTimeout(rotarTurnoActual, 100); 

        // ==================================================
        // --- (FIN) DE LA LÓGICA MODIFICADA ---
        // ==================================================
       
        // ==================================================
        // --- (INICIO) LÓGICA DE SONIDO (MODIFICADA) ---
        // ==================================================
        let ultimoTurnoSonado = '';
        let audioContext;  
        const audioOverlay = document.getElementById('audio-overlay'); // (NUEVO)
       
        function inicializarAudio() {
            if (!audioContext) {
                try {
                    audioContext = new (window.AudioContext || window.webkitAudioContext)();
                   
                    if ('speechSynthesis' in window) {
                        // Cargar voces la primera vez
                        speechSynthesis.getVoices(); 
                    }
                    console.log("AudioContext inicializado correctamente.");
                } catch (e) {
                    console.error("AudioContext no es soportado por este navegador.");
                }
            }
            
            // (NUEVO) Ocultar el overlay después de la inicialización
            if (audioOverlay) {
                audioOverlay.style.opacity = '0';
                setTimeout(() => {
                    audioOverlay.style.display = 'none';
                }, 500); // Esperar a que termine la transición de opacidad
            }
        }
       
        // (MODIFICADO) Asignar el evento al overlay
        if (audioOverlay) {
            audioOverlay.addEventListener('click', inicializarAudio, { once: true });
            audioOverlay.addEventListener('touchend', inicializarAudio, { once: true });
        } else {
            // Fallback por si el overlay falla (aunque no debería)
            console.warn("No se encontró el overlay de audio, asignando evento al body.");
            document.body.addEventListener('click', inicializarAudio, { once: true });
            document.body.addEventListener('touchend', inicializarAudio, { once: true });
        }

        // Función de sonido para el TURNO PRINCIPAL (Ding-Dong + Voz)
        function reproducirSonido(codigoTurno, nombreCaja) {
           
            // (MODIFICADO) Solo sonar si el turno es válido Y es diferente al último que sonó Y EL AUDIO ESTÁ LISTO
            if (codigoTurno && codigoTurno !== '---' && codigoTurno !== ultimoTurnoSonado && audioContext) {
               
                // 1. Sonido de Timbre (Ding-Dong)
                try {
                    const now = audioContext.currentTime;
                    const duration = 1.5;  
                   
                    const osc1 = audioContext.createOscillator();
                    const gain1 = audioContext.createGain();
                    osc1.type = 'sine';
                    osc1.frequency.setValueAtTime(783.99, now); // Tono G5
                    gain1.gain.setValueAtTime(0.3, now);  
                    gain1.gain.exponentialRampToValueAtTime(0.001, now + duration);
                    osc1.connect(gain1);
                    gain1.connect(audioContext.destination);
                    osc1.start(now);
                    osc1.stop(now + duration);

                    const osc2 = audioContext.createOscillator();
                    const gain2 = audioContext.createGain();
                    const startTimeTone2 = now + 0.3;  
                    osc2.type = 'sine';
                    osc2.frequency.setValueAtTime(659.25, startTimeTone2); // Tono E5
                    gain2.gain.setValueAtTime(0.3, startTimeTone2);
                    gain2.gain.exponentialRampToValueAtTime(0.001, startTimeTone2 + duration);
                    osc2.connect(gain2);
                    gain2.connect(audioContext.destination);
                    osc2.start(startTimeTone2);
                    osc2.stop(startTimeTone2 + duration);

                } catch (e) {
                    console.error("Error al reproducir sonido (timbre):", e);
                }

                // 2. Anuncio de Voz
                setTimeout(() => {
                    try {
                        // Cancelar cualquier voz anterior para evitar que se pisen
                        speechSynthesis.cancel(); 
                        
                        const letra = codigoTurno.substring(0, 1);
                        const numero = parseInt(codigoTurno.substring(1), 10);  
                        const textoAVisar = `Turno ${letra} ${numero}. Diríjase a ${nombreCaja}.`;
                       
                        const utterance = new SpeechSynthesisUtterance(textoAVisar);
                        utterance.lang = 'es-CO';  
                        utterance.rate = 0.9;     
                        utterance.pitch = 1.0;   
                        speechSynthesis.speak(utterance);

                    } catch(e) {
                        console.error("Error al reproducir voz (SpeechSynthesis):", e);
                    }
                }, 1000);  
               
                // (IMPORTANTE) Actualizar el último turno que sonó
                ultimoTurnoSonado = codigoTurno;
            }
        }
       
        // (NUEVA FUNCIÓN) Sonido para la lista de "PRÓXIMOS" (Ding corto)
        function reproducirSonidoProximo() {
            if (!audioContext) return; // Salir si el audio no está listo

            try {
                const now = audioContext.currentTime;
                const duration = 0.8; // Un "ding" más corto
               
                const osc1 = audioContext.createOscillator();
                const gain1 = audioContext.createGain();
               
                osc1.type = 'triangle'; // Sonido tipo campana
                osc1.frequency.setValueAtTime(1046.50, now); // Tono C6 (alto)
                gain1.gain.setValueAtTime(0.2, now); // Volumen bajo

                // Desvanecimiento
                gain1.gain.exponentialRampToValueAtTime(0.001, now + duration);

                osc1.connect(gain1);
                gain1.connect(audioContext.destination);
               
                osc1.start(now);
                osc1.stop(now + duration);

            } catch (e) {
                console.error("Error al reproducir sonido (próximo turno):", e);
            }
        }
        // ==================================================
        // --- (FIN) DE LA LÓGICA DE SONIDO ---
        // ==================================================
       
    </script>

</body>
</html>