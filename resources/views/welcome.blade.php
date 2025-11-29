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
            <div class="grid md:grid-cols-3 gap-6 mb-8">
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
                
                <!-- Cámara 2 -->
                <div class="bg-gray-900 border-2 border-green-500 rounded-lg overflow-hidden">
                    <div class="bg-gray-800 px-4 py-2 flex justify-between items-center">
                        <span class="font-orbitron font-semibold">CÁMARA 02</span>
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-xs">ONLINE</span>
                        </div>
                    </div>
                    <div class="aspect-video bg-black relative scanline">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <div class="w-16 h-16 border-4 border-green-500 rounded-full animate-spin border-t-transparent mb-4"></div>
                                <p class="text-green-300">Patio Central</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Cámara 3 -->
                <div class="bg-gray-900 border-2 border-green-500 rounded-lg overflow-hidden">
                    <div class="bg-gray-800 px-4 py-2 flex justify-between items-center">
                        <span class="font-orbitron font-semibold">CÁMARA 03</span>
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-xs">ONLINE</span>
                        </div>
                    </div>
                    <div class="aspect-video bg-black relative scanline">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <div class="w-16 h-16 border-4 border-green-500 rounded-full animate-spin border-t-transparent mb-4"></div>
                                <p class="text-green-300">Área de Recreo</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Panel de Control -->
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Controles de Simulación -->
                <div class="bg-gray-900 border-2 border-green-500 rounded-lg p-6">
                    <h2 class="font-orbitron text-xl font-bold mb-4 flex items-center">
                        <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2 animate-blink"></span>
                        SIMULACIÓN DE ALERTAS
                    </h2>
                    
                    <div class="space-y-4">
                        <button onclick="triggerAlert('intruder')" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 hover:animate-pulse-red">
                            🚨 DETECTAR INTRUSO
                        </button>
                        
                        <button onclick="triggerAlert('aggression')" 
                                class="w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 hover:animate-pulse-orange">
                            ⚠️ DETECTAR AGRESIÓN
                        </button>
                        
                        <button onclick="triggerAlert('weapon')" 
                                class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 hover:animate-pulse-yellow">
                            🔫 DETECTAR ARMA
                        </button>
                        
                        <button onclick="clearAlerts()" 
                                class="w-full bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200">
                            ✕ LIMPIAR ALERTAS
                        </button>
                    </div>
                </div>
                
                <!-- Estado del Sistema -->
                <div class="bg-gray-900 border-2 border-green-500 rounded-lg p-6">
                    <h2 class="font-orbitron text-xl font-bold mb-4 flex items-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                        ESTADO DEL SISTEMA
                    </h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span>Cámaras Activas:</span>
                            <span class="font-orbitron font-bold text-green-400">3/3</span>
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
                            <span>Conexión de Red:</span>
                            <span class="font-orbitron font-bold text-green-400">ESTABLE</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span>Última Actualización:</span>
                            <span class="font-orbitron font-bold text-green-400" id="lastUpdate">--:--:--</span>
                        </div>
                    </div>
                    
                    <div class="mt-6 p-4 bg-gray-800 rounded-lg">
                        <p class="text-sm text-green-300">
                            <strong>NOTA:</strong> Este es un sistema de demostración. 
                            Los botones de simulación activarán alertas visuales para mostrar 
                            cómo funcionaría el sistema en un entorno real.
                        </p>
                    </div>
                </div>
            </div>
        </main>
        
        <script>
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
                document.getElementById('lastUpdate').textContent = timeString;
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
            });
        </script>
    </body>
</html>