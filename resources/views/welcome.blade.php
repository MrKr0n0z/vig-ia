<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>VIG-IA - Sistema de Videovigilancia Inteligente</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800;900&family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <style>
            /* Fuentes personalizadas */
            .font-orbitron { font-family: 'Orbitron', monospace; }
            .font-roboto { font-family: 'Roboto', sans-serif; }
            
            /* Animaciones personalizadas */
            @keyframes pulse-red {
                0%, 100% { background-color: #dc2626; box-shadow: 0 0 20px #dc2626; }
                50% { background-color: #ef4444; box-shadow: 0 0 40px #ef4444, 0 0 60px #dc2626; }
            }
            
            @keyframes pulse-orange {
                0%, 100% { background-color: #ea580c; box-shadow: 0 0 20px #ea580c; }
                50% { background-color: #f97316; box-shadow: 0 0 40px #f97316, 0 0 60px #ea580c; }
            }
            
            @keyframes pulse-yellow {
                0%, 100% { background-color: #ca8a04; box-shadow: 0 0 20px #ca8a04; }
                50% { background-color: #eab308; box-shadow: 0 0 40px #eab308, 0 0 60px #ca8a04; }
            }
            
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
                20%, 40%, 60%, 80% { transform: translateX(10px); }
            }
            
            @keyframes blink {
                0%, 50% { opacity: 1; }
                51%, 100% { opacity: 0.3; }
            }
            
            @keyframes slideInDown {
                from { transform: translateY(-100%); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }
            
            .animate-pulse-red { animation: pulse-red 1.5s infinite; }
            .animate-pulse-orange { animation: pulse-orange 1.5s infinite; }
            .animate-pulse-yellow { animation: pulse-yellow 1.5s infinite; }
            .animate-shake { animation: shake 0.5s infinite; }
            .animate-blink { animation: blink 1s infinite; }
            .animate-slide-down { animation: slideInDown 0.5s ease-out; }
            
            /* Efectos de scanline */
            .scanline {
                position: relative;
                overflow: hidden;
            }
            
            .scanline::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 2px;
                background: linear-gradient(90deg, transparent, #00ff00, transparent);
                animation: scan 2s linear infinite;
            }
            
            @keyframes scan {
                0% { left: -100%; }
                100% { left: 100%; }
            }
            
            /* Efectos de glitch */
            .glitch {
                position: relative;
                animation: glitch 2s infinite;
            }
            
            @keyframes glitch {
                0%, 90%, 100% { transform: translate(0); }
                10% { transform: translate(-2px, -1px); }
                20% { transform: translate(2px, 1px); }
                30% { transform: translate(-1px, 2px); }
                40% { transform: translate(1px, -2px); }
                50% { transform: translate(-2px, 1px); }
                60% { transform: translate(2px, -1px); }
                70% { transform: translate(-1px, -2px); }
                80% { transform: translate(1px, 2px); }
            }
            
            /* Fondo matrix */
            .matrix-bg {
                background-color: #000;
                background-image: 
                    radial-gradient(rgba(0, 255, 0, 0.1) 1px, transparent 1px);
                background-size: 20px 20px;
                animation: matrix 20s linear infinite;
            }
            
            @keyframes matrix {
                0% { background-position: 0 0; }
                100% { background-position: 20px 20px; }
            }
            
            /* Overlay de alerta */
            .alert-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(220, 38, 38, 0.8);
                z-index: 9999;
                display: flex;
                justify-content: center;
                align-items: center;
                backdrop-filter: blur(2px);
            }
            
            .alert-box {
                background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
                border: 3px solid #dc2626;
                border-radius: 12px;
                padding: 2rem;
                max-width: 500px;
                text-align: center;
                box-shadow: 0 0 50px rgba(220, 38, 38, 0.5);
                animation: alertPulse 1s infinite alternate;
            }
            
            @keyframes alertPulse {
                0% { box-shadow: 0 0 50px rgba(220, 38, 38, 0.5); }
                100% { box-shadow: 0 0 80px rgba(220, 38, 38, 0.8), 0 0 120px rgba(220, 38, 38, 0.3); }
            }
        </style>
    </head>
    
    <body class="font-roboto bg-black text-green-400 matrix-bg min-h-screen">
        <!-- Overlay de alertas -->
        <div id="alertContainer"></div>
        
        <!-- Header -->
        <header class="bg-gray-900 border-b-2 border-green-500 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center animate-pulse">
                            <span class="text-black font-orbitron font-black text-lg">VI</span>
                        </div>
                        <div>
                            <h1 class="font-orbitron text-2xl font-bold text-green-400 glitch">VIG-IA</h1>
                            <p class="text-sm text-green-300">Detección de Comportamiento - MATLAB Integration</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-6">
                        <div class="text-right">
                            <div class="font-orbitron text-lg font-semibold" id="currentTime">--:--:--</div>
                            <div class="text-xs text-green-300" id="currentDate">-- -- ----</div>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-sm font-semibold">SISTEMA ACTIVO</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 py-8">
            <!-- Grid de Cámaras -->
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <!-- Cámara 1 -->
                <div class="bg-gray-900 border-2 border-green-500 rounded-lg overflow-hidden">
                    <div class="bg-gray-800 px-4 py-2 flex justify-between items-center">
                        <span class="font-orbitron font-semibold">CÁMARA 01</span>
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-xs">ONLINE</span>
                        </div>
                    </div>
                    <div class="aspect-video bg-black relative scanline">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <div class="w-16 h-16 border-4 border-green-500 rounded-full animate-spin border-t-transparent mb-4"></div>
                                <p class="text-green-300">Acceso Principal</p>
                            </div>
                        </div>
                    </div>
                </div>
                

                <!-- Última Detección / Evidencia -->
                <div id="evidencePanel" class="bg-gray-900 border-2 border-green-500 rounded-lg overflow-hidden">
                    <div class="bg-gray-800 px-4 py-2 flex justify-between items-center">
                        <span class="font-orbitron font-semibold">ÚLTIMA DETECCIÓN</span>
                        <div class="flex items-center space-x-2">
                            <div id="evidenceStatus" class="w-2 h-2 bg-gray-500 rounded-full"></div>
                            <span class="text-xs" id="evidenceStatusText">ESPERANDO</span>
                        </div>
                    </div>
                    <div class="aspect-video bg-black relative border-2 border-gray-700">
                        <div id="evidenceContent" class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center text-gray-500">
                                <div class="w-16 h-16 border-4 border-gray-500 rounded-full mb-4 opacity-50">
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="text-2xl">🔍</span>
                                    </div>
                                </div>
                                <p class="text-sm">Esperando detección MATLAB</p>
                                <p class="text-xs mt-1">Track ID y evidencia</p>
                                <p class="text-xs text-gray-600">aparecerán aquí</p>
                            </div>
                        </div>
                        <!-- Overlay de alerta que se activa cuando hay detección -->
                        <div id="alertOverlay" class="absolute inset-0 bg-red-600 bg-opacity-80 hidden items-center justify-center">
                            <div class="text-center animate-pulse">
                                <div class="text-6xl mb-2">⚠️</div>
                                <div class="text-white font-orbitron font-bold text-lg">INTRUSO DETECTADO</div>
                                <div class="text-red-200 text-sm mt-2">Evidencia capturada</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Panel de Control -->
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Feed de Eventos en Tiempo Real -->
                <div class="bg-gray-900 border-2 border-green-500 rounded-lg p-6">
                    <h2 class="font-orbitron text-xl font-bold mb-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="w-3 h-3 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
                            FEED DE EVENTOS
                        </div>
                        <div class="flex items-center space-x-2">
                            <button id="btnEventosAuto" onclick="toggleEventosAutomaticos()" 
                                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-1 px-3 rounded text-xs transition-all duration-200">
                                ▶️ INICIAR PRUEBA
                            </button>
                            <span id="statusEventos" class="text-xs text-gray-400">SOLO MATLAB</span>
                        </div>
                    </h2>
                    
                    <div id="eventFeed" class="bg-black rounded-lg p-4 h-80 overflow-y-auto border border-green-500">
                        <div class="space-y-2 text-sm font-mono">
                            <!-- Los eventos se agregarán aquí dinámicamente -->
                        </div>
                    </div>
                    
                    <!-- Controles de Simulación MATLAB -->
                    <div class="mt-4">
                        <div class="text-xs text-gray-400 mb-2">SIMULACIÓN DE ALERTAS MATLAB:</div>
                        <div class="grid grid-cols-1 gap-2">
                            <button onclick="simulateMatlabAlert('persona_detenida')" 
                                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-3 rounded text-sm transition-all duration-200">
                                🚨 Persona Detenida (15-20s+)
                            </button>
                            
                            <button onclick="simulateMatlabAlert('movimiento_sospechoso')" 
                                    class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2 px-3 rounded text-sm transition-all duration-200">
                                ⚠️ Movimiento Sospechoso (Va-y-Viene)
                            </button>
                        </div>
                        
                        <div class="mt-2 grid grid-cols-2 gap-2">
                            <button onclick="simulateNormalActivity()" 
                                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-1 px-2 rounded text-xs transition-all duration-200">
                                ✅ Actividad Normal
                            </button>
                            
                            <button onclick="limpiarAlertasPrueba()" 
                                    class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-1 px-2 rounded text-xs transition-all duration-200">
                                🧹 Limpiar BD
                            </button>
                        </div>
                        <button onclick="clearEventFeed()" 
                                class="w-full mt-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-1 px-2 rounded text-xs transition-all duration-200">
                            🗑️ Limpiar Todo
                        </button>
                    </div>
                </div>
                
                <!-- Estado del Sistema -->
                <div class="bg-gray-900 border-2 border-green-500 rounded-lg p-6">
                    <h2 class="font-orbitron text-xl font-bold mb-4 flex items-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                        ESTADO DEL SISTEMA
                    </h2>
                    
                    <!-- Indicador de Nivel de Amenaza -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold">Nivel de Amenaza:</span>
                            <span id="threatLevel" class="font-orbitron font-bold text-green-400">NORMAL</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-3 border border-gray-600">
                            <div id="threatBar" class="bg-green-500 h-3 rounded-full transition-all duration-500" style="width: 20%"></div>
                        </div>
                        <div class="flex justify-between text-xs mt-1 text-gray-400">
                            <span>SEGURO</span>
                            <span>PRECAUCIÓN</span>
                            <span>CRÍTICO</span>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span>Webcam Status:</span>
                            <span id="webcamStatus" class="font-orbitron font-bold text-red-400">DESCONECTADA</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span>MATLAB Tracking:</span>
                            <span id="matlabTracking" class="font-orbitron font-bold text-red-400">INACTIVO</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span>Tracks Activos:</span>
                            <span id="activeTracks" class="font-orbitron font-bold text-gray-400">0</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span>Conexión API:</span>
                            <span id="apiStatus" class="font-orbitron font-bold text-green-400">CONECTADA</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span>Última Alerta:</span>
                            <span class="font-orbitron font-bold text-gray-400" id="lastAlert">Sin alertas</span>
                        </div>
                        
                        <div class="mt-4 p-3 bg-gray-800 rounded">
                            <div class="text-xs text-gray-400 mb-1">ESTADÍSTICAS MATLAB:</div>
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <div>Personas Detenidas: <span id="personasDetenidas" class="text-red-400">0</span></div>
                                <div>Mov. Sospechosos: <span id="movimientosSospechosos" class="text-orange-400">0</span></div>
                                <div>Frames Analizados: <span id="framesAnalizados" class="text-blue-400">0</span></div>
                                <div>Tiempo Activo: <span id="tiempoActivo" class="text-green-400">0m</span></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Protocolos de Respuesta -->
                    <div class="mt-6 space-y-2">
                        <h3 class="font-orbitron font-bold text-sm mb-3 text-yellow-400">PROTOCOLOS DE RESPUESTA:</h3>
                        
                        <div class="text-xs text-gray-400 mb-2">Para Persona Detenida:</div>
                        <button onclick="guardAction('check_person')" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition-all duration-200 text-sm">
                            🔍 VERIFICAR IDENTIDAD
                        </button>
                        
                        <div class="text-xs text-gray-400 mb-2 mt-3">Para Movimiento Sospechoso:</div>
                        <button onclick="guardAction('monitor_area')" 
                                class="w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2 px-4 rounded transition-all duration-200 text-sm">
                            📹 MONITOREAR ÁREA
                        </button>
                        
                        <div class="text-xs text-gray-400 mb-2 mt-3">Acciones Generales:</div>
                        <div class="grid grid-cols-2 gap-2">
                            <button onclick="guardAction('false_alarm')" 
                                    class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-3 rounded transition-all duration-200 text-xs">
                                ❌ FALSA ALARMA
                            </button>
                            
                            <button onclick="guardAction('emergency')" 
                                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-3 rounded transition-all duration-200 text-xs animate-pulse">
                                🆘 EMERGENCIA
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <script>
            // Variables globales
            let eventCount = 0;
            let currentThreatLevel = 1; // 1=Normal, 2=Precaución, 3=Crítico
            let events = [];
            let lastAlertId = 0; // Para polling de nuevas alertas
            let eventosAutomaticos = false; // Control de eventos programados
            let intervaloEventos = null; // Referencia al intervalo
            let alertasValidasEnFeed = 0; // Contador de alertas válidas visibles en el feed
            
            // Función para actualizar la hora
            function updateTime() {
                const now = new Date();
                const timeString = now.toLocaleTimeString('es-ES', { hour12: false });
                const dateString = now.toLocaleDateString('es-ES', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                });
                
                const currentTime = document.getElementById('currentTime');
                const currentDate = document.getElementById('currentDate');
                const lastDetection = document.getElementById('lastDetection');
                
                if (currentTime) currentTime.textContent = timeString;
                if (currentDate) currentDate.textContent = dateString.toUpperCase();
                if (lastDetection) lastDetection.textContent = timeString;
            }
            
            // Función para agregar eventos al feed
            function addEvent(type, camera, message, isAlert = false) {
                const now = new Date();
                const timeString = now.toLocaleTimeString('es-ES', { hour12: false });
                const eventFeed = document.getElementById('eventFeed');
                
                if (!eventFeed) {
                    console.warn('EventFeed element not found');
                    return;
                }
                
                eventCount++;
                
                // Contar alertas válidas (no de sistema, no de actividad normal)
                if (isAlert && (type === 'persona_detenida' || type === 'movimiento_sospechoso' || type === 'intruder' || type === 'movement')) {
                    alertasValidasEnFeed++;
                }
                
                const eventElement = document.createElement('div');
                eventElement.className = `event-item p-2 rounded mb-1 ${isAlert ? 'bg-red-900 border border-red-500 animate-pulse' : 'bg-gray-800 border border-gray-600'}`;
                
                const icons = {
                    'student': '✅',
                    'intruder': '🚨',
                    'movement': 'ℹ️',
                    'system': '⚙️',
                    'guard': '👮‍♂️',
                    'persona_detenida': '🚫',
                    'movimiento_sospechoso': '⚠️',
                    'normal': '✅'
                };
                
                eventElement.innerHTML = `
                    <span class="text-green-400 font-mono text-xs">${timeString}</span> - 
                    <span class="text-blue-300">[${camera}]</span> 
                    <span class="text-xl">${icons[type] || '📝'}</span> 
                    <span class="text-white">${message}</span>
                `;
                
                eventFeed.insertBefore(eventElement, eventFeed.firstChild);
                
                // Mantener solo los últimos 20 eventos
                const eventItems = eventFeed.querySelectorAll('.event-item');
                if (eventItems.length > 20) {
                    eventFeed.removeChild(eventItems[eventItems.length - 1]);
                    // Si se elimina un evento que era una alerta, decrementar el contador
                    const removedEvent = eventItems[eventItems.length - 1];
                    if (removedEvent.classList.contains('bg-red-900')) {
                        alertasValidasEnFeed = Math.max(0, alertasValidasEnFeed - 1);
                    }
                }
                
                // Actualizar nivel de amenaza basado en alertas válidas en el feed
                updateThreatLevelBasedOnFeed();
                    showEvidence(type);
                }
            }
            
            // Función para calcular nivel de amenaza basado en el feed
            function updateThreatLevelBasedOnFeed() {
                let nivel = 1; // Normal por defecto
                
                if (alertasValidasEnFeed > 2) {
                    nivel = 2; // Precaución
                }
                if (alertasValidasEnFeed > 5) {
                    nivel = 3; // Crítico
                }
                
                // Solo actualizar si es diferente al nivel actual
                if (nivel !== currentThreatLevel) {
                    updateThreatLevel(nivel);
                }
            }
            
            // Función para actualizar el nivel de amenaza
            function updateThreatLevel(level) {
                currentThreatLevel = level;
                const threatLevel = document.getElementById('threatLevel');
                const threatBar = document.getElementById('threatBar');
                
                const levels = {
                    1: { text: 'NORMAL', color: 'text-green-400', barColor: 'bg-green-500', width: '20%' },
                    2: { text: 'PRECAUCIÓN', color: 'text-yellow-400', barColor: 'bg-yellow-500', width: '60%' },
                    3: { text: 'CRÍTICO', color: 'text-red-400', barColor: 'bg-red-500', width: '100%' }
                };
                
                const config = levels[level];
                threatLevel.className = `font-orbitron font-bold ${config.color}`;
                threatLevel.textContent = config.text;
                threatBar.className = `${config.barColor} h-3 rounded-full transition-all duration-500`;
                threatBar.style.width = config.width;
                
                if (level === 3) {
                    threatLevel.classList.add('animate-pulse');
                } else {
                    threatLevel.classList.remove('animate-pulse');
                }
            }
            
            // Función para mostrar evidencia específica de MATLAB
            function showMatlabEvidence(alertType, trackId, duration, frameCount) {
                const evidencePanel = document.getElementById('evidencePanel');
                const evidenceStatus = document.getElementById('evidenceStatus');
                const evidenceStatusText = document.getElementById('evidenceStatusText');
                const alertOverlay = document.getElementById('alertOverlay');
                
                const colors = {
                    'persona_detenida': { bg: 'border-red-500', status: 'bg-red-500', text: 'PERSONA DETENIDA' },
                    'movimiento_sospechoso': { bg: 'border-orange-500', status: 'bg-orange-500', text: 'MOV. SOSPECHOSO' }
                };
                
                const config = colors[alertType] || colors['persona_detenida'];
                
                // Cambiar apariencia del panel
                evidencePanel.className = `bg-gray-900 border-2 ${config.bg} rounded-lg overflow-hidden animate-pulse`;
                evidenceStatus.className = `w-2 h-2 ${config.status} rounded-full animate-pulse`;
                evidenceStatusText.textContent = config.text;
                evidenceStatusText.className = 'text-xs text-red-400 font-bold';
                
                // Mostrar overlay temporal
                if (alertOverlay) {
                    alertOverlay.classList.remove('hidden');
                    alertOverlay.classList.add('flex');
                    
                    setTimeout(() => {
                        alertOverlay.classList.add('hidden');
                        alertOverlay.classList.remove('flex');
                    }, 2000);
                }
                
                // Mostrar información detallada de MATLAB
                setTimeout(() => {
                    document.getElementById('evidenceContent').innerHTML = `
                        <div class="w-full h-full ${alertType === 'persona_detenida' ? 'bg-red-900' : 'bg-orange-900'} flex items-center justify-center relative">
                            <div class="text-center">
                                <div class="w-20 h-20 ${alertType === 'persona_detenida' ? 'bg-red-600' : 'bg-orange-600'} rounded-full flex items-center justify-center mb-2 animate-pulse">
                                    <span class="text-3xl">${alertType === 'persona_detenida' ? '🛑' : '🔄'}</span>
                                </div>
                                <div class="${alertType === 'persona_detenida' ? 'text-red-300' : 'text-orange-300'} font-bold text-sm">TRACK ID: ${trackId}</div>
                                <div class="${alertType === 'persona_detenida' ? 'text-red-200' : 'text-orange-200'} text-xs mt-1">Duración: ${duration}s</div>
                                <div class="${alertType === 'persona_detenida' ? 'text-red-200' : 'text-orange-200'} text-xs">Frames: ${frameCount}</div>
                                <div class="${alertType === 'persona_detenida' ? 'text-red-200' : 'text-orange-200'} text-xs">Cámara: CAM-01</div>
                            </div>
                            <div class="absolute top-2 right-2 ${alertType === 'persona_detenida' ? 'bg-red-600' : 'bg-orange-600'} text-white text-xs px-2 py-1 rounded font-bold animate-blink">
                                MATLAB
                            </div>
                        </div>
                    `;
                }, 2500);
            }
            
            // Función para simular alertas específicas de MATLAB
            function simulateMatlabAlert(alertType) {
                const trackId = Math.floor(Math.random() * 50) + 1;
                const frameCount = Math.floor(Math.random() * 1000) + 500;
                
                let message, duration, isHighAlert;
                
                if (alertType === 'persona_detenida') {
                    duration = Math.floor(Math.random() * 45) + 15; // 15-60 segundos
                    message = `🚨 Track ${trackId}: Persona detenida por ${duration} segundos`;
                    isHighAlert = true;
                    
                    // Actualizar estadísticas
                    updateMatlabStats('personasDetenidas');
                    
                } else if (alertType === 'movimiento_sospechoso') {
                    duration = Math.floor(Math.random() * 30) + 20; // 20-50 segundos
                    const changes = Math.floor(Math.random() * 6) + 4; // 4-10 cambios
                    message = `⚠️ Track ${trackId}: Movimiento sospechoso (va-y-viene). ${changes} cambios de dirección`;
                    isHighAlert = false;
                    
                    // Actualizar estadísticas
                    updateMatlabStats('movimientosSospechosos');
                }
                
                // Agregar al feed
                addEvent(alertType, 'CAM-01', message, isHighAlert);
                
                // Actualizar panel de evidencia
                showMatlabEvidence(alertType, trackId, duration, frameCount);
                
                // Actualizar nivel de amenaza
                if (alertType === 'persona_detenida') {
                    updateThreatLevel(3);
                    triggerAlert('intruder');
                } else {
                    updateThreatLevel(2);
                }
                
                // Actualizar última alerta
                const lastAlert = document.getElementById('lastAlert');
                if (lastAlert) {
                    const now = new Date();
                    lastAlert.textContent = now.toLocaleTimeString('es-ES', { hour12: false });
                    lastAlert.className = 'font-orbitron font-bold text-red-400';
                }
            }
            
            // Función para simular actividad normal
            function simulateNormalActivity() {
                const activities = [
                    'Persona transitando normalmente',
                    'Estudiante identificado correctamente',
                    'Movimiento regular detectado',
                    'Persona saliendo del área vigilada'
                ];
                
                const activity = activities[Math.floor(Math.random() * activities.length)];
                addEvent('normal', 'CAM-01', `✅ ${activity}`, false);
                updateThreatLevel(1);
            }
            
            // Función para actualizar estadísticas MATLAB
            function updateMatlabStats(type) {
                const element = document.getElementById(type);
                if (element) {
                    const current = parseInt(element.textContent) || 0;
                    element.textContent = current + 1;
                }
                
                // Actualizar frames analizados
                const framesEl = document.getElementById('framesAnalizados');
                if (framesEl) {
                    const frames = parseInt(framesEl.textContent) || 0;
                    framesEl.textContent = frames + Math.floor(Math.random() * 200) + 100;
                }
            }
            
            // Función para acciones del guardia (protocolos específicos)
            async function guardAction(action) {
                const actions = {
                    'check_person': '👮‍♂️ Iniciando verificación de identidad',
                    'monitor_area': '📹 Incrementando monitoreo en área sospechosa',
                    'false_alarm': '❌ Falsa alarma reportada - Sistema restablecido',
                    'emergency': '🚨 PROTOCOLO DE EMERGENCIA ACTIVADO'
                };
                
                const isEmergency = action === 'emergency';
                addEvent('guard', 'OPERADOR', actions[action], isEmergency);
                
                if (action === 'check_person') {
                    // Protocolo para persona detenida
                    setTimeout(() => {
                        addEvent('guard', 'OPERADOR', '🔍 Verificando bases de datos de identidad...', false);
                    }, 2000);
                    
                } else if (action === 'monitor_area') {
                    // Protocolo para movimiento sospechoso
                    setTimeout(() => {
                        addEvent('guard', 'OPERADOR', '👁️ Activando cámaras adicionales en sector...', false);
                    }, 2000);
                    
                } else if (action === 'false_alarm') {
                    // Marcar como falsa alarma en la API
                    try {
                        const response = await fetch('/api/alertas?solo_no_vistas=true');
                        const data = await response.json();
                        
                        if (data.success && data.data.length > 0) {
                            // Marcar la última alerta como falsa alarma
                            const ultimaAlerta = data.data[0];
                            await fetch(`/api/alertas/${ultimaAlerta.id}`, { method: 'DELETE' });
                        }
                    } catch (error) {
                        console.error('Error marcando falsa alarma:', error);
                    }
                    
                    clearAlerts();
                    updateThreatLevel(1);
                    resetEvidencePanel();
                    
                } else if (action === 'emergency') {
                    // Activar protocolo de emergencia
                    activateEmergencyEffects();
                    setTimeout(() => {
                        addEvent('guard', 'SISTEMA', '📞 Contactando a las autoridades...', true);
                    }, 1000);
                }
            }
            
            // Función para actualizar estado de conexión MATLAB
            function updateMatlabConnectionStatus(connected) {
                const webcamStatus = document.getElementById('webcamStatus');
                const matlabTracking = document.getElementById('matlabTracking');
                const activeTracks = document.getElementById('activeTracks');
                
                if (connected) {
                    if (webcamStatus) {
                        webcamStatus.textContent = 'CONECTADA';
                        webcamStatus.className = 'font-orbitron font-bold text-green-400';
                    }
                    if (matlabTracking) {
                        matlabTracking.textContent = 'ACTIVO';
                        matlabTracking.className = 'font-orbitron font-bold text-green-400';
                    }
                } else {
                    if (webcamStatus) {
                        webcamStatus.textContent = 'DESCONECTADA';
                        webcamStatus.className = 'font-orbitron font-bold text-red-400';
                    }
                    if (matlabTracking) {
                        matlabTracking.textContent = 'INACTIVO';
                        matlabTracking.className = 'font-orbitron font-bold text-red-400';
                    }
                }
            }
            
            // Función para actualizar tiempo activo
            function updateActiveTime() {
                const tiempoActivo = document.getElementById('tiempoActivo');
                if (tiempoActivo) {
                    const current = parseInt(tiempoActivo.textContent) || 0;
                    tiempoActivo.textContent = (current + 1) + 'm';
                }
            }
            
            // Función para alternar eventos automáticos
            function toggleEventosAutomaticos() {
                const btn = document.getElementById('btnEventosAuto');
                const status = document.getElementById('statusEventos');
                
                if (!eventosAutomaticos) {
                    // Iniciar eventos automáticos
                    eventosAutomaticos = true;
                    btn.textContent = '⏹️ DETENER PRUEBA';
                    btn.className = 'bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded text-xs transition-all duration-200';
                    status.textContent = 'MODO PRUEBA';
                    status.className = 'text-xs text-yellow-400 animate-pulse';
                    
                    addEvent('system', 'SISTEMA', '🧪 Modo de prueba activado - Eventos simulados', false);
                    
                    // Iniciar generación automática de eventos
                    iniciarEventosAutomaticos();
                    
                } else {
                    // Detener eventos automáticos
                    eventosAutomaticos = false;
                    btn.textContent = '▶️ INICIAR PRUEBA';
                    btn.className = 'bg-green-600 hover:bg-green-700 text-white font-semibold py-1 px-3 rounded text-xs transition-all duration-200';
                    status.textContent = 'SOLO MATLAB';
                    status.className = 'text-xs text-gray-400';
                    
                    addEvent('system', 'SISTEMA', '✅ Modo de prueba desactivado - Solo alertas reales', false);
                    
                    // Detener el intervalo
                    if (intervaloEventos) {
                        clearInterval(intervaloEventos);
                        intervaloEventos = null;
                    }
                    
                    // Limpiar alertas de prueba de la base de datos
                    setTimeout(() => {
                        limpiarAlertasPrueba();
                    }, 1000);
                }
            }
            
            // Función para iniciar eventos automáticos
            function iniciarEventosAutomaticos() {
                if (intervaloEventos) {
                    clearInterval(intervaloEventos);
                }
                
                // Generar eventos cada 8-15 segundos
                intervaloEventos = setInterval(() => {
                    if (!eventosAutomaticos) {
                        clearInterval(intervaloEventos);
                        return;
                    }
                    
                    generarEventoAleatorio();
                }, Math.random() * 7000 + 8000); // 8-15 segundos
            }
            
            // Función para generar evento aleatorio
            function generarEventoAleatorio() {
                const tiposEventos = [
                    {
                        tipo: 'normal',
                        peso: 60, // 60% probabilidad
                        eventos: [
                            'Persona transitando normalmente por el área',
                            'Estudiante detectado - Acceso autorizado',
                            'Movimiento regular sin anomalías',
                            'Persona saliendo del área de vigilancia',
                            'Detección de movimiento - Patrón normal'
                        ]
                    },
                    {
                        tipo: 'persona_detenida',
                        peso: 25, // 25% probabilidad
                        eventos: [
                            'Track {id}: Persona detenida por {duration} segundos',
                            'Track {id}: Quietud prolongada detectada - {duration}s',
                            'Track {id}: Persona estacionaria - Duración {duration}s'
                        ]
                    },
                    {
                        tipo: 'movimiento_sospechoso',
                        peso: 15, // 15% probabilidad
                        eventos: [
                            'Track {id}: Movimiento repetitivo detectado - {changes} cambios',
                            'Track {id}: Patrón va-y-viene - {changes} inversiones de dirección',
                            'Track {id}: Comportamiento errático - {changes} cambios bruscos'
                        ]
                    }
                ];
                
                // Seleccionar tipo basado en peso
                const random = Math.random() * 100;
                let acumulado = 0;
                let tipoSeleccionado = null;
                
                for (const tipo of tiposEventos) {
                    acumulado += tipo.peso;
                    if (random <= acumulado) {
                        tipoSeleccionado = tipo;
                        break;
                    }
                }
                
                if (!tipoSeleccionado) tipoSeleccionado = tiposEventos[0];
                
                // Generar evento específico
                const eventoTemplate = tipoSeleccionado.eventos[Math.floor(Math.random() * tipoSeleccionado.eventos.length)];
                const trackId = Math.floor(Math.random() * 20) + 1;
                const duration = Math.floor(Math.random() * 40) + 15;
                const changes = Math.floor(Math.random() * 6) + 4;
                
                let mensaje = eventoTemplate
                    .replace('{id}', trackId)
                    .replace('{duration}', duration)
                    .replace('{changes}', changes);
                
                // Agregar prefijo según tipo
                if (tipoSeleccionado.tipo === 'normal') {
                    mensaje = `✅ ${mensaje}`;
                    addEvent('normal', 'CAM-01', mensaje, false);
                } else if (tipoSeleccionado.tipo === 'persona_detenida') {
                    mensaje = `🚨 ${mensaje}`;
                    addEvent('persona_detenida', 'CAM-01', mensaje, true);
                    
                    // Simular alerta visual para pruebas
                    if (Math.random() > 0.7) { // 30% de probabilidad de alerta visual
                        setTimeout(() => {
                            showMatlabEvidence('persona_detenida', trackId, duration, duration * 30);
                            updateThreatLevel(3);
                        }, 1000);
                    }
                } else if (tipoSeleccionado.tipo === 'movimiento_sospechoso') {
                    mensaje = `⚠️ ${mensaje}`;
                    addEvent('movimiento_sospechoso', 'CAM-01', mensaje, false);
                    
                    // Simular alerta visual para pruebas
                    if (Math.random() > 0.8) { // 20% de probabilidad de alerta visual
                        setTimeout(() => {
                            showMatlabEvidence('movimiento_sospechoso', trackId, duration, duration * 30);
                            updateThreatLevel(2);
                        }, 1000);
                    }
                }
            }
            
            // Función para limpiar alertas de prueba y falsas alarmas de la base de datos
            async function limpiarAlertasPrueba() {
                try {
                    // Obtener todas las alertas
                    const response = await fetch('/api/alertas');
                    const data = await response.json();
                    
                    if (data.success && data.data.length > 0) {
                        // Filtrar alertas problemáticas
                        const alertasEliminar = data.data.filter(alerta => {
                            const esPrueba = alerta.description.includes('PRUEBA desde PHP') || 
                                           alerta.description.includes('PRUEBA:') ||
                                           alerta.track_id >= 900;
                            
                            const esFalsaAlarma = alerta.is_false_alarm === true;
                            
                            // Alertas muy antiguas (más de 24 horas)
                            const fechaAlerta = new Date(alerta.created_at || alerta.alert_timestamp);
                            const ahora = new Date();
                            const unDia = 24 * 60 * 60 * 1000;
                            const esMuyAntigua = (ahora - fechaAlerta) > unDia;
                            
                            return esPrueba || esFalsaAlarma || esMuyAntigua;
                        });
                        
                        // Eliminar cada alerta problemática
                        let eliminadas = 0;
                        for (const alerta of alertasEliminar) {
                            try {
                                await fetch(`/api/alertas/${alerta.id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                                    }
                                });
                                eliminadas++;
                            } catch (err) {
                                console.warn('Error eliminando alerta', alerta.id, err);
                            }
                        }
                        
                        if (eliminadas > 0) {
                            addEvent('system', 'SISTEMA', `🗑️ ${eliminadas} alertas no válidas eliminadas`, false);
                        }
                    }
                } catch (error) {
                    console.error('Error limpiando alertas:', error);
                }
            }
            
            // Función para limpiar el feed de eventos
            function clearEventFeed() {
                document.getElementById('eventFeed').innerHTML = '<div class="text-center text-gray-500 text-sm">Feed de eventos limpio</div>';
                
                // Resetear contadores
                alertasValidasEnFeed = 0;
                eventCount = 0;
                updateThreatLevel(1);
                resetEvidencePanel();
                
                // Detener eventos automáticos si están activos
                if (eventosAutomaticos) {
                    toggleEventosAutomaticos();
                }
                
                // Limpiar alertas de prueba de la base de datos
                limpiarAlertasPrueba();
                
                // Resetear estadísticas
                const stats = ['personasDetenidas', 'movimientosSospechosos'];
                stats.forEach(stat => {
                    const el = document.getElementById(stat);
                    if (el) el.textContent = '0';
                });
                
                // Resetear lastAlertId
                lastAlertId = 0;
            }
            
            // Función para resetear el panel de evidencia
            function resetEvidencePanel() {
                const evidencePanel = document.getElementById('evidencePanel');
                const evidenceStatus = document.getElementById('evidenceStatus');
                const evidenceStatusText = document.getElementById('evidenceStatusText');
                const evidenceContent = document.getElementById('evidenceContent');
                
                evidencePanel.className = 'bg-gray-900 border-2 border-green-500 rounded-lg overflow-hidden';
                evidenceStatus.className = 'w-2 h-2 bg-gray-500 rounded-full';
                evidenceStatusText.textContent = 'ESPERANDO';
                evidenceStatusText.className = 'text-xs';
                
                evidenceContent.innerHTML = `
                    <div class="text-center text-gray-500">
                        <div class="w-16 h-16 border-4 border-gray-500 rounded-full mb-4 opacity-50">
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-2xl">📷</span>
                            </div>
                        </div>
                        <p class="text-sm">Sin detecciones recientes</p>
                        <p class="text-xs mt-2">La evidencia aparecerá aquí</p>
                    </div>
                `;
            }
            
            // Función para crear alertas
            function createAlert(type, message, color) {
                const alertOverlay = document.createElement('div');
                alertOverlay.className = 'alert-overlay animate-slide-down';
                
                const alertBox = document.createElement('div');
                alertBox.className = 'alert-box animate-shake';
                alertBox.style.borderColor = color;
                
                alertBox.innerHTML = `
                    <div class="text-6xl mb-4">${getAlertIcon(type)}</div>
                    <h2 class="font-orbitron text-2xl font-bold text-white mb-4">ALERTA DE SEGURIDAD</h2>
                    <p class="text-xl text-red-300 mb-6">${message}</p>
                    <div class="flex justify-center space-x-4">
                        <button onclick="removeAlert(this)" 
                                class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-lg transition-all duration-200">
                            RECONOCER
                        </button>
                        <button onclick="activateEmergencyEffects()" 
                                class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-6 rounded-lg transition-all duration-200">
                            EMERGENCIA
                        </button>
                    </div>
                `;
                
                alertOverlay.appendChild(alertBox);
                document.getElementById('alertContainer').appendChild(alertOverlay);
                
                // Auto-remove después de 10 segundos si no se interactúa
                setTimeout(() => {
                    if (alertOverlay.parentNode) {
                        removeAlert(alertOverlay.querySelector('button'));
                    }
                }, 10000);
            }
            
            // Función para obtener el ícono de la alerta
            function getAlertIcon(type) {
                switch(type) {
                    case 'intruder': return '👤';
                    case 'aggression': return '⚡';
                    case 'weapon': return '🔫';
                    default: return '⚠️';
                }
            }
            
            // Función para activar alertas específicas
            function triggerAlert(type) {
                const alerts = {
                    intruder: {
                        message: 'Se detectó alguien que no es estudiante',
                        color: '#dc2626'
                    },
                    aggression: {
                        message: 'Se está detectando una posible agresión',
                        color: '#ea580c'
                    },
                    weapon: {
                        message: 'Esa persona porta un arma',
                        color: '#ca8a04'
                    }
                };
                
                if (alerts[type]) {
                    createAlert(type, alerts[type].message, alerts[type].color);
                }
            }
            
            // Función para limpiar todas las alertas
            function clearAlerts() {
                const container = document.getElementById('alertContainer');
                while (container.firstChild) {
                    container.removeChild(container.firstChild);
                }
            }
            
            // Función para remover una alerta específica
            function removeAlert(button) {
                const overlay = button.closest('.alert-overlay');
                if (overlay) {
                    overlay.style.opacity = '0';
                    overlay.style.transform = 'scale(0.8)';
                    overlay.style.transition = 'all 0.3s ease-out';
                    setTimeout(() => {
                        if (overlay.parentNode) {
                            overlay.parentNode.removeChild(overlay);
                        }
                    }, 300);
                }
            }
            
            // Función para efectos de emergencia
            function activateEmergencyEffects() {
                document.body.style.animation = 'glitch 0.1s infinite';
                
                // Parpadeo de luces rojas
                const overlay = document.createElement('div');
                overlay.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(220, 38, 38, 0.3);
                    z-index: 9998;
                    animation: blink 0.2s infinite;
                    pointer-events: none;
                `;
                document.body.appendChild(overlay);
                
                // Remover efectos después de 5 segundos
                setTimeout(() => {
                    document.body.style.animation = '';
                    if (overlay.parentNode) {
                        overlay.parentNode.removeChild(overlay);
                    }
                }, 5000);
                
                // Limpiar alertas después del efecto
                clearAlerts();
            }
            
            // Funciones para conectar con la API real
            async function cargarEstadoSistema() {
                try {
                    const response = await fetch('/api/sistema/estado');
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    if (data.success && data.data) {
                        const estado = data.data;
                        
                        // Actualizar conexión MATLAB de forma segura
                        const matlabStatus = document.getElementById('matlabTracking');
                        if (matlabStatus) {
                            matlabStatus.textContent = estado.matlab_connected ? 'ACTIVO' : 'INACTIVO';
                            matlabStatus.className = `font-orbitron font-bold ${estado.matlab_connected ? 'text-green-400' : 'text-red-400'}`;
                        }
                        
                        // Actualizar estadísticas de manera segura
                        const statsElements = {
                            'personasDetenidas': estado.alertas_detenidas || 0,
                            'movimientosSospechosos': estado.alertas_sospechosas || 0
                        };
                        
                        Object.entries(statsElements).forEach(([id, value]) => {
                            const element = document.getElementById(id);
                            if (element) {
                                element.textContent = value;
                            }
                        });
                        
                        // Solo actualizar nivel de amenaza si no hay alertas en el feed
                        // El feed tiene prioridad sobre el estado del sistema
                        if (alertasValidasEnFeed === 0 && estado.nivel_amenaza) {
                            updateThreatLevel(estado.nivel_amenaza);
                        }
                        
                        // Solo mostrar mensaje de conexión una vez
                        if (estado.matlab_connected && !window.matlabConnected) {
                            addEvent('system', 'SISTEMA', '🔗 API Lista - Puerto 8000 activo');
                            window.matlabConnected = true;
                        }
                    } else {
                        console.warn('Respuesta de API sin datos válidos:', data);
                    }
                } catch (error) {
                    console.error('Error detallado cargando estado del sistema:', error);
                    // Solo mostrar error una vez por minuto para evitar spam
                    const now = Date.now();
                    if (!window.lastErrorTime || now - window.lastErrorTime > 60000) {
                        addEvent('system', 'SISTEMA', '❌ Error de conexión con servidor');
                        window.lastErrorTime = now;
                    }
                }
            }
            
            async function cargarAlertasRecientes() {
                try {
                    const response = await fetch('/api/alertas/recientes');
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    if (data.success && data.data.length > 0) {
                        // Filtrar solo alertas reales y recientes
                        const alertasReales = data.data.filter(alerta => {
                            // Excluir alertas de prueba
                            const esPrueba = alerta.description.includes('PRUEBA desde PHP') || 
                                           alerta.description.includes('PRUEBA:') ||
                                           alerta.track_id >= 900;
                            
                            // Excluir falsas alarmas
                            const esFalsaAlarma = alerta.is_false_alarm === true;
                            
                            // Excluir alertas muy antiguas (más de 2 horas)
                            const fechaAlerta = new Date(alerta.created_at || alerta.alert_timestamp);
                            const ahora = new Date();
                            const dosHoras = 2 * 60 * 60 * 1000; // 2 horas en milisegundos
                            const esMuyAntigua = (ahora - fechaAlerta) > dosHoras;
                            
                            // Solo incluir si NO es prueba, NO es falsa alarma y NO es muy antigua
                            return !esPrueba && !esFalsaAlarma && !esMuyAntigua;
                        });
                        
                        // Procesar solo nuevas alertas reales
                        alertasReales.forEach(alerta => {
                            if (alerta.id > lastAlertId) {
                                const tipo = alerta.alert_type === 'persona_detenida' ? 'intruder' : 'movement';
                                let mensaje = alerta.description;
                                
                                // Formatear mensaje de manera más limpia
                                let mensajeLimpio = mensaje;
                                if (!mensaje.includes('Track')) {
                                    mensajeLimpio = `Track ${alerta.track_id}: ${mensaje}`;
                                }
                                
                                // Formato específico según el tipo
                                const iconoTipo = alerta.alert_type === 'persona_detenida' ? '🚫' : '⚠️';
                                addEvent(alerta.alert_type, alerta.camera_id.toUpperCase(), `${iconoTipo} ${mensajeLimpio}`, true);
                                
                                if (alerta.alert_type === 'persona_detenida') {
                                    triggerAlert('intruder');
                                    showMatlabEvidence(alerta.alert_type, alerta.track_id, alerta.duration_seconds, alerta.frame_count);
                                    updateMatlabConnectionStatus(true);
                                } else if (alerta.alert_type === 'movimiento_sospechoso') {
                                    showMatlabEvidence(alerta.alert_type, alerta.track_id, alerta.duration_seconds, alerta.frame_count);
                                    updateMatlabConnectionStatus(true);
                                }
                                
                                lastAlertId = Math.max(lastAlertId, alerta.id);
                                
                                // Actualizar estadísticas
                                if (alerta.alert_type === 'persona_detenida') {
                                    updateMatlabStats('personasDetenidas');
                                } else if (alerta.alert_type === 'movimiento_sospechoso') {
                                    updateMatlabStats('movimientosSospechosos');
                                }
                            }
                        });
                    }
                } catch (error) {
                    console.error('Error detallado cargando alertas recientes:', error);
                    // Solo mostrar error de alertas esporádicamente
                    if (Math.random() < 0.1) { // 10% de probabilidad
                        addEvent('system', 'SISTEMA', '⚠️ Error cargando alertas recientes');
                    }
                }
            }
            
            async function marcarAlertaVista(alertId) {
                try {
                    await fetch(`/api/alertas/${alertId}/marcar-vista`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({ notes: 'Vista desde interfaz web' })
                    });
                } catch (error) {
                    console.error('Error marcando alerta como vista:', error);
                }
            }
            
            // Limpiar intervalos al salir de la página
            window.addEventListener('beforeunload', function() {
                if (intervaloEventos) {
                    clearInterval(intervaloEventos);
                }
            });
            
            // Inicializar
            document.addEventListener('DOMContentLoaded', function() {
                updateTime();
                setInterval(updateTime, 1000);
                
                // Inicializar estado MATLAB
                updateMatlabConnectionStatus(false);
                
                // Agregar eventos iniciales
                setTimeout(() => {
                    addEvent('system', 'SISTEMA', 'VIG-IA iniciado - Esperando conexión MATLAB');
                }, 1000);
                
                setTimeout(() => {
                    addEvent('system', 'SISTEMA', 'API Lista - Puerto 8000 activo');
                }, 1500);
                
                // Cargar estado inicial del sistema
                setTimeout(() => {
                    cargarEstadoSistema();
                }, 2000);
                
                // Simular actualización de tiempo activo
                setInterval(() => {
                    updateActiveTime();
                }, 60000); // cada minuto
                
                // Polling cada 5 segundos para nuevas alertas
                setInterval(() => {
                    cargarAlertasRecientes();
                }, 5000);
                
                // Actualizar estado del sistema cada 30 segundos
                setInterval(() => {
                    cargarEstadoSistema();
                }, 30000);
            });
        </script>
    </body>
</html>