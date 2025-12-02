%% Configuración de VIG-IA - MATLAB Integration
% Este archivo contiene la configuración actualizada para conectar
% el sistema de MATLAB con la API de Laravel

%% ===========================
%  CONFIGURACIÓN DE LA API
%  ===========================

% URL base de la aplicación (cambiar según tu entorno)
% Para desarrollo local:
apiBaseUrl = 'http://localhost:8000';
% Para producción (cuando publiques la app):
% apiBaseUrl = 'https://tu-dominio.com';

% Endpoint específico para recibir alertas
apiUrl = [apiBaseUrl, '/api/recibir-alerta'];

% Configuración de la cámara
cameraId = 'camara_01';
location = 'Callejon Principal';

%% ===========================
%  PARÁMETROS DE DETECCIÓN
%  ===========================
res = '640x480';           % resolución
numFramesFondo = 30;      % frames para construir fondo inicial
alpha = 0.02;             % velocidad de adaptación del fondo
diffThreshold = 45;       % umbral para binarizar diferencia
minBlobArea = 1000;       % eliminar blobs muy pequeños
closeStructSize = [100 100]; % imclose para unir fragmentos
assocMaxDistance = 200;    % distancia máxima para asociar detecciones
maxInvisibleFrames = 10;  % eliminar track si invisible > X frames
stopDistancePx = 6;       % umbral de movimiento para considerar detenido
stopSeconds = 15;         % segundos para alertar por detenido (ajusta a tu preferencia)
suspiciousDirChanges = 4; % cambios de dirección para movimiento sospechoso
historyLen = 60;          % cantidad de posiciones guardadas por track
cooldown = 10;            % tiempo entre alertas del mismo tipo por track
minRangeForVaYViene = 60; % rango mínimo para considerar ida-y-vuelta

%% ===========================
%  FUNCIÓN PARA ENVIAR ALERTAS (ACTUALIZADA)
%  ===========================
function enviarAlertaAPI(apiUrl, cameraId, location, trackId, alertType, description, duration, frameCount)
    try
        % Crear estructura de datos para la alerta
        alertData = struct();
        alertData.camera_id = cameraId;
        alertData.location = location;
        alertData.track_id = trackId;
        alertData.alert_type = alertType;
        alertData.description = description;
        alertData.duration_seconds = duration;
        alertData.frame_count = frameCount;
        alertData.timestamp = datestr(now, 'yyyy-mm-dd HH:MM:SS');
        
        % Convertir a JSON
        jsonData = jsonencode(alertData);
        
        % Mostrar información de debug
        fprintf('\n=== ENVIANDO ALERTA A VIG-IA ===\n');
        fprintf('URL: %s\n', apiUrl);
        fprintf('Tipo: %s\n', alertType);
        fprintf('Track ID: %d\n', trackId);
        fprintf('Descripción: %s\n', description);
        fprintf('JSON: %s\n', jsonData);
        
        % Configurar opciones para webwrite
        options = weboptions('RequestMethod', 'post', ...
                           'MediaType', 'application/json', ...
                           'ContentType', 'json', ...
                           'Timeout', 10, ...
                           'HeaderFields', {'Content-Type', 'application/json'});
        
        % Enviar la alerta
        try
            response = webwrite(apiUrl, jsonData, options);
            fprintf('✓ Alerta enviada exitosamente!\n');
            fprintf('Respuesta del servidor: %s\n', response);
        catch webError
            % Si falla el envío, mostrar error pero continuar
            fprintf('✗ Error enviando alerta: %s\n', webError.message);
            fprintf('Continuando con la ejecución...\n');
        end
        
        fprintf('================================\n\n');
        
    catch ME
        fprintf('✗ Error procesando alerta: %s\n', ME.message);
    end
end

%% ===========================
%  INSTRUCCIONES DE USO
%  ===========================
fprintf('\n=== VIG-IA MATLAB INTEGRATION CONFIGURADO ===\n');
fprintf('URL de la API: %s\n', apiUrl);
fprintf('Cámara ID: %s\n', cameraId);
fprintf('Ubicación: %s\n', location);
fprintf('\nPara usar este sistema:\n');
fprintf('1. Asegúrate de que Laravel esté ejecutándose en: %s\n', apiBaseUrl);
fprintf('2. Ejecuta tu código de detección principal\n');
fprintf('3. Las alertas se enviarán automáticamente a la API\n');
fprintf('4. Ve las alertas en tiempo real en: %s\n', apiBaseUrl);
fprintf('===============================================\n\n');