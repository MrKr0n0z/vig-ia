<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
                            <p class="text-sm text-green-300">Sistema de Videovigilancia Inteligente</p>
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
                                        <span class="text-2xl">📷</span>
                                    </div>
                                </div>
                                <p class="text-sm">Sin detecciones recientes</p>
                                <p class="text-xs mt-2">La evidencia aparecerá aquí</p>
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
                    <h2 class="font-orbitron text-xl font-bold mb-4 flex items-center">
                        <span class="w-3 h-3 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
                        FEED DE EVENTOS
                    </h2>
                    
                    <div id="eventFeed" class="bg-black rounded-lg p-4 h-80 overflow-y-auto border border-green-500">
                        <div class="space-y-2 text-sm font-mono">
                            <!-- Los eventos se agregarán aquí dinámicamente -->
                        </div>
                    </div>
                    
                    <!-- Botones de Simulación (ocultos pero funcionales) -->
                    <div class="mt-4 grid grid-cols-2 gap-2">
                        <button onclick="simulateEvent('student')" 
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-3 rounded text-sm transition-all duration-200">
                            ✅ Simular Estudiante
                        </button>
                        
                        <button onclick="simulateEvent('intruder')" 
                                class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-3 rounded text-sm transition-all duration-200">
                            🚨 Simular Intruso
                        </button>
                        
                        <button onclick="simulateEvent('movement')" 
                                class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-3 rounded text-sm transition-all duration-200">
                            🚶 Simular Movimiento
                        </button>
                        
                        <button onclick="clearEventFeed()" 
                                class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-3 rounded text-sm transition-all duration-200">
                            🗑️ Limpiar Feed
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
                            <span>Cámaras Activas:</span>
                            <span class="font-orbitron font-bold text-red-400">0/1</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span>IA de Detección:</span>
                            <span class="font-orbitron font-bold text-green-400">ACTIVA</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span>Almacenamiento:</span>
                            <span class="font-orbitron font-bold text-yellow-400">78%</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span>Conexión MATLAB:</span>
                            <span id="matlabStatus" class="font-orbitron font-bold text-red-400">SIN CONEXIÓN</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span>Última Detección:</span>
                            <span class="font-orbitron font-bold text-green-400" id="lastDetection">--:--:--</span>
                        </div>
                    </div>
                    
                    <!-- Botones de Acción del Guardia -->
                    <div class="mt-6 space-y-2">
                        <h3 class="font-orbitron font-bold text-sm mb-3 text-yellow-400">ACCIONES DE EMERGENCIA:</h3>
                        <button onclick="guardAction('silence')" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition-all duration-200">
                            🔇 SILENCIAR ALARMA
                        </button>
                        
                        <button onclick="guardAction('false_alarm')" 
                                class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded transition-all duration-200">
                            ❌ REPORTAR FALSA ALARMA
                        </button>
                        
                        <button onclick="guardAction('call_police')" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded transition-all duration-200 animate-pulse">
                            🚔 LLAMAR A POLICÍA
                        </button>
                    </div>
                </div>
            </div>
        </main>
        
        <script>
            // Variables globales
            let eventCount = 0;
            let currentThreatLevel = 1; // 1=Normal, 2=Precaución, 3=Crítico
            let events = [];
            
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
                
                document.getElementById('currentTime').textContent = timeString;
                document.getElementById('currentDate').textContent = dateString.toUpperCase();
                document.getElementById('lastDetection').textContent = timeString;
            }
            
            // Función para agregar eventos al feed
            function addEvent(type, camera, message, isAlert = false) {
                const now = new Date();
                const timeString = now.toLocaleTimeString('es-ES', { hour12: false });
                const eventFeed = document.getElementById('eventFeed');
                
                eventCount++;
                
                const eventElement = document.createElement('div');
                eventElement.className = `event-item p-2 rounded mb-1 ${isAlert ? 'bg-red-900 border border-red-500 animate-pulse' : 'bg-gray-800 border border-gray-600'}`;
                
                const icons = {
                    'student': '✅',
                    'intruder': '🚨',
                    'movement': 'ℹ️',
                    'system': '⚙️',
                    'guard': '👮‍♂️'
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
                }
                
                // Actualizar nivel de amenaza si es una alerta
                if (isAlert && type === 'intruder') {
                    updateThreatLevel(3);
                    showEvidence(type);
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
            
            // Función para mostrar evidencia
            function showEvidence(type) {
                const evidencePanel = document.getElementById('evidencePanel');
                const evidenceStatus = document.getElementById('evidenceStatus');
                const evidenceStatusText = document.getElementById('evidenceStatusText');
                const alertOverlay = document.getElementById('alertOverlay');
                
                // Cambiar el borde a rojo y hacer que parpadee
                evidencePanel.className = 'bg-gray-900 border-2 border-red-500 rounded-lg overflow-hidden animate-pulse-red';
                evidenceStatus.className = 'w-2 h-2 bg-red-500 rounded-full animate-pulse';
                evidenceStatusText.textContent = 'ALERTA';
                evidenceStatusText.className = 'text-xs text-red-400 font-bold';
                
                // Mostrar overlay de alerta
                alertOverlay.classList.remove('hidden');
                alertOverlay.classList.add('flex');
                
                // Simular "foto de evidencia" después de unos segundos
                setTimeout(() => {
                    alertOverlay.classList.add('hidden');
                    alertOverlay.classList.remove('flex');
                    
                    // Mostrar imagen simulada de evidencia
                    document.getElementById('evidenceContent').innerHTML = `
                        <div class="w-full h-full bg-red-900 flex items-center justify-center relative">
                            <div class="text-center">
                                <div class="w-20 h-20 bg-red-600 rounded-full flex items-center justify-center mb-2 animate-pulse">
                                    <span class="text-3xl">👤</span>
                                </div>
                                <div class="text-red-300 font-bold text-sm">SUJETO NO IDENTIFICADO</div>
                                <div class="text-red-200 text-xs mt-1">Confianza: 94%</div>
                                <div class="text-red-200 text-xs">Cámara: CAM-01</div>
                            </div>
                            <div class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded font-bold animate-blink">
                                EVIDENCIA
                            </div>
                        </div>
                    `;
                }, 3000);
            }
            
            // Función para simular eventos
            function simulateEvent(type) {
                const cameras = ['CAM-01'];
                const randomCamera = cameras[Math.floor(Math.random() * cameras.length)];
                
                const eventMessages = {
                    'student': `Estudiante detectado (Acceso Autorizado)`,
                    'intruder': `⚠️ ALERTA: Rostro no reconocido - Posible intruso`,
                    'movement': `Movimiento detectado en área vigilada`
                };
                
                if (type === 'intruder') {
                    addEvent(type, randomCamera, eventMessages[type], true);
                    triggerAlert('intruder');
                } else {
                    addEvent(type, randomCamera, eventMessages[type], false);
                    if (type === 'student') {
                        updateThreatLevel(1);
                    } else if (type === 'movement') {
                        updateThreatLevel(2);
                    }
                }
            }
            
            // Función para acciones del guardia
            function guardAction(action) {
                const actions = {
                    'silence': 'Alarma silenciada por el operador',
                    'false_alarm': 'Falsa alarma reportada - Sistema restablecido',
                    'call_police': '🚔 ALERTA MÁXIMA: Contactando con las autoridades'
                };
                
                addEvent('guard', 'SISTEMA', actions[action], action === 'call_police');
                
                if (action === 'silence' || action === 'false_alarm') {
                    // Limpiar alertas y restablecer nivel de amenaza
                    clearAlerts();
                    updateThreatLevel(1);
                    resetEvidencePanel();
                } else if (action === 'call_police') {
                    // Activar efectos de emergencia máxima
                    activateEmergencyEffects();
                }
            }
            
            // Función para limpiar el feed de eventos
            function clearEventFeed() {
                document.getElementById('eventFeed').innerHTML = '<div class="text-center text-gray-500 text-sm">Feed de eventos limpio</div>';
                updateThreatLevel(1);
                resetEvidencePanel();
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
            
            // Inicializar
            document.addEventListener('DOMContentLoaded', function() {
                updateTime();
                setInterval(updateTime, 1000);
                
                // Agregar eventos iniciales para que parezca un sistema real
                setTimeout(() => {
                    addEvent('system', 'SISTEMA', 'Sistema VIG-IA iniciado correctamente');
                }, 1000);
                
                setTimeout(() => {
                    addEvent('system', 'SISTEMA', 'Intentando conectar con MATLAB... ❌ Sin conexión');
                }, 2000);
                
                setTimeout(() => {
                    addEvent('system', 'CAM-01', 'Cámara desconectada - Sistema en modo offline');
                }, 3000);
                
                // Simular actividad normal cada 30-60 segundos
                setInterval(() => {
                    if (Math.random() > 0.7) {
                        simulateEvent('student');
                    } else if (Math.random() > 0.8) {
                        simulateEvent('movement');
                    }
                }, Math.random() * 30000 + 30000);
            });
        </script>
    </body>
</html>