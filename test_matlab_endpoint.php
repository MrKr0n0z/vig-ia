<?php

$apiUrl = 'https://vig-ia-production.up.railway.app/api/recibir-alerta';

// Datos de prueba exactamente como los envía MATLAB
$testData = [
    [
        'camera_id' => 'camara_01',
        'location' => 'Callejon Principal',
        'track_id' => 12,
        'alert_type' => 'persona_detenida',
        'description' => 'Persona detenida por 15 segundos',
        'duration_seconds' => 15,
        'frame_count' => 450,
        'timestamp' => date('Y-m-d H:i:s')
    ],
    [
        'camera_id' => 'camara_01', 
        'location' => 'Callejon Principal',
        'track_id' => 15,
        'alert_type' => 'movimiento_sospechoso',
        'description' => 'Track 15: Movimiento repetitivo detectado - 6 cambios',
        'duration_seconds' => 32,
        'frame_count' => 960,
        'timestamp' => date('Y-m-d H:i:s', strtotime('+2 minutes'))
    ]
];

function sendAlertToAPI($url, $data) {
    $options = [
        'http' => [
            'header' => "Content-type: application/json\r\n",
            'method' => 'POST',
            'content' => json_encode($data),
            'timeout' => 30 // Timeout más largo para conexiones de internet
        ]
    ];
    
    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);
    
    if ($result === false) {
        $error = error_get_last();
        echo "❌ Error enviando alerta: " . ($error['message'] ?? 'Error desconocido') . "\n";
        return false;
    }
    
    $response = json_decode($result, true);
    return $response;
}

echo "🧪 Probando endpoint de MATLAB en PRODUCCIÓN...\n";
echo "🔗 URL: " . $apiUrl . "\n\n";

foreach ($testData as $index => $alertData) {
    echo "Enviando alerta " . ($index + 1) . "...\n";
    echo "Datos: " . json_encode($alertData, JSON_PRETTY_PRINT) . "\n";
    
    $response = sendAlertToAPI($apiUrl, $alertData);
    
    if ($response && isset($response['success']) && $response['success']) {
        echo "✅ Alerta enviada exitosamente!\n";
        echo "   Alert ID: " . $response['alert_id'] . "\n";
        echo "   Mensaje: " . $response['message'] . "\n";
    } else {
        echo "❌ Error en la respuesta:\n";
        if ($response) {
            echo "   " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
        } else {
            echo "   No se recibió respuesta del servidor\n";
        }
    }
    
    echo "\n" . str_repeat('-', 50) . "\n\n";
    sleep(3); // Esperar 3 segundos entre alertas
}

echo "🏁 Pruebas completadas!\n";
echo "🌐 Ve a: https://vig-ia-production.up.railway.app/ para ver los resultados\n";
?>
