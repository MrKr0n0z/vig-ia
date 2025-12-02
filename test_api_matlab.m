%% Script de Prueba para VIG-IA API
% Este script simula el envío de alertas a la API para verificar la conexión

clear; close all; clc;

%% Cargar configuración
run('matlab_config.m');

%% Función de prueba
function probarAPI(apiUrl, cameraId, location)
    fprintf('\n=== INICIANDO PRUEBAS DE API VIG-IA ===\n');
    
    % Prueba 1: Alerta de persona detenida
    fprintf('\nPrueba 1: Enviando alerta de persona detenida...\n');
    enviarAlertaAPI(apiUrl, cameraId, location, 999, 'persona_detenida', ...
        'PRUEBA: Persona detenida por 30 segundos (simulación)', 30, 900);
    
    % Esperar 2 segundos
    pause(2);
    
    % Prueba 2: Alerta de movimiento sospechoso
    fprintf('\nPrueba 2: Enviando alerta de movimiento sospechoso...\n');
    enviarAlertaAPI(apiUrl, cameraId, location, 998, 'movimiento_sospechoso', ...
        'PRUEBA: Movimiento sospechoso detectado (va-y-viene). Cambios de dirección: 5', 45, 1350);
    
    % Esperar 2 segundos
    pause(2);
    
    % Prueba 3: Otra alerta de persona detenida
    fprintf('\nPrueba 3: Enviando otra alerta de persona detenida...\n');
    enviarAlertaAPI(apiUrl, cameraId, location, 997, 'persona_detenida', ...
        'PRUEBA: Persona permanece más de 20 segundos en área vigilada', 25, 750);
    
    fprintf('\n=== PRUEBAS COMPLETADAS ===\n');
    fprintf('Revisa tu navegador en: http://localhost:8000\n');
    fprintf('Deberías ver las 3 alertas de prueba en el sistema VIG-IA\n');
    fprintf('=========================\n\n');
end

%% Ejecutar las pruebas
try
    probarAPI(apiUrl, cameraId, location);
    fprintf('✓ Script de prueba ejecutado exitosamente!\n');
catch ME
    fprintf('✗ Error en el script de prueba: %s\n', ME.message);
end