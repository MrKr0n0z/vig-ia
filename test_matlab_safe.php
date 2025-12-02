<?php

$apiUrl = 'https://vig-ia-production.up.railway.app/api/recibir-alerta';
$alertasUrl = 'https://vig-ia-production.up.railway.app/api/alertas';

// Datos de prueba con IDs únicos para identificarlas fácilmente
$testData = [
    [
        'camera_id' => 'camara_01',
        'location' => 'Callejon Principal',
        'track_id' => 999, // ID especial para pruebas
        'alert_type' => 'persona_detenida',
        'description' => 'PRUEBA: Persona detenida por 15 segundos',
        'duration_seconds' => 15,
        'frame_count' => 450,
        'timestamp' => date('Y-m-d H:i:s')
    ]
];

function sendAlertToAPI($url, $data) {
    $options = [
        'http' => [
            'header' => "Content-type: application/json\r\n",
            'method' => 'POST',
            'content' => json_encode($data),
            'timeout' => 30
        ]
    ];
    
    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);
    
    if ($result === false) {
        $error = error_get_last();
        echo "❌ Error enviando alerta: " . ($error['message'] ?? 'Error desconocido') . "\n";
        return false;
    }
    
    return json_decode($result, true);
}

function deleteAlert($alertId) {
    $deleteUrl = "https://vig-ia-production.up.railway.app/api/alertas/$alertId";
    $options = [
        'http' => [
            'header' => "Content-type: application/json\r\n",
            'method' => 'DELETE'
        ]
    ];
    
    $context = stream_context_create($options);
    $result = @file_get_contents($deleteUrl, false, $context);
    return $result !== false;
}

function limpiarAlertasPrueba() {
    global $alertasUrl;
    
    echo "🧹 Limpiando alertas de prueba anteriores...\n";
    
    $response = @file_get_contents($alertasUrl);
    if ($response === false) {
        echo "❌ Error obteniendo alertas\n";
        return;
    }
    
    $data = json_decode($response, true);
    if (!$data || !$data['success']) {
        echo "❌ Error en respuesta de alertas\n";
        return;
    }
    
    $eliminadas = 0;
    foreach ($data['data'] as $alerta) {
        // Eliminar alertas de prueba (track_id >= 999 o contienen "PRUEBA")
        if ($alerta['track_id'] >= 999 || strpos($alerta['description'], 'PRUEBA') !== false) {
            if (deleteAlert($alerta['id'])) {
                echo "🗑️ Eliminada alerta de prueba ID: {$alerta['id']}\n";
                $eliminadas++;
            }
        }
    }
    
    if ($eliminadas > 0) {
        echo "✅ $eliminadas alertas de prueba eliminadas\n\n";
    } else {
        echo "ℹ️ No se encontraron alertas de prueba para eliminar\n\n";
    }
}

// Preguntar qué hacer
echo "🧪 TEST MATLAB ENDPOINT - MODO SEGURO\n";
echo "==========================================\n\n";

echo "Opciones disponibles:\n";
echo "1. Enviar UNA alerta de prueba (se elimina después)\n";
echo "2. Solo limpiar alertas de prueba existentes\n";
echo "3. Cancelar\n\n";

echo "Selecciona una opción (1, 2 o 3): ";
$opcion = trim(fgets(STDIN));

switch ($opcion) {
    case '1':
        echo "\n🧪 Enviando alerta de prueba...\n";
        echo "🔗 URL: " . $apiUrl . "\n\n";
        
        $alertData = $testData[0];
        echo "Datos: " . json_encode($alertData, JSON_PRETTY_PRINT) . "\n";
        
        $response = sendAlertToAPI($apiUrl, $alertData);
        
        if ($response && isset($response['success']) && $response['success']) {
            echo "✅ Alerta enviada exitosamente!\n";
            echo "   Alert ID: " . $response['alert_id'] . "\n";
            echo "   Mensaje: " . $response['message'] . "\n\n";
            
            echo "⏳ Esperando 10 segundos para que aparezca en la interfaz...\n";
            sleep(10);
            
            echo "🧹 Eliminando alerta de prueba...\n";
            if (deleteAlert($response['alert_id'])) {
                echo "✅ Alerta de prueba eliminada\n";
            } else {
                echo "❌ Error eliminando alerta de prueba\n";
            }
        } else {
            echo "❌ Error en la respuesta:\n";
            if ($response) {
                echo "   " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
            } else {
                echo "   No se recibió respuesta del servidor\n";
            }
        }
        break;
        
    case '2':
        limpiarAlertasPrueba();
        break;
        
    case '3':
        echo "Cancelado por el usuario.\n";
        exit(0);
        
    default:
        echo "❌ Opción no válida.\n";
        exit(1);
}

echo "\n🌐 Ve a: https://vig-ia-production.up.railway.app/ para ver los resultados\n";
?>