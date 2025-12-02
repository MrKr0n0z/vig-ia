<?php

// Script de prueba para la API VIG-IA
// Este script prueba todos los endpoints de la API

echo "=== PROBANDO API VIG-IA ===\n\n";

// Configuración
$baseUrl = 'http://127.0.0.1:8000';
$endpoints = [
    'GET /api/sistema/estado' => $baseUrl . '/api/sistema/estado',
    'GET /api/alertas/recientes' => $baseUrl . '/api/alertas/recientes',
    'GET /api/alertas' => $baseUrl . '/api/alertas'
];

// Función para hacer peticiones HTTP
function makeRequest($url, $method = 'GET', $data = null) {
    $context = stream_context_create([
        'http' => [
            'method' => $method,
            'header' => [
                'Content-Type: application/json',
                'Accept: application/json'
            ],
            'content' => $data ? json_encode($data) : null,
            'timeout' => 10
        ]
    ]);
    
    $response = @file_get_contents($url, false, $context);
    
    if ($response === false) {
        return ['error' => 'No se pudo conectar con el servidor'];
    }
    
    return json_decode($response, true);
}

// Probar cada endpoint
foreach ($endpoints as $name => $url) {
    echo "Probando: $name\n";
    echo "URL: $url\n";
    
    $response = makeRequest($url);
    
    if (isset($response['error'])) {
        echo "❌ Error: {$response['error']}\n";
    } else {
        echo "✅ Respuesta exitosa:\n";
        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    }
    
    echo str_repeat("-", 60) . "\n\n";
}

// Probar envío de alerta (POST)
echo "Probando: POST /api/recibir-alerta\n";
$alertaData = [
    'camera_id' => 'camara_01',
    'location' => 'Callejón Principal',
    'track_id' => 999,
    'alert_type' => 'persona_detenida',
    'description' => 'PRUEBA desde PHP: Persona detenida por 30 segundos',
    'duration_seconds' => 30,
    'frame_count' => 900,
    'timestamp' => date('Y-m-d H:i:s')
];

echo "Datos a enviar:\n";
echo json_encode($alertaData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => [
            'Content-Type: application/json',
            'Accept: application/json'
        ],
        'content' => json_encode($alertaData),
        'timeout' => 10
    ]
]);

$response = @file_get_contents($baseUrl . '/api/recibir-alerta', false, $context);

if ($response === false) {
    echo "❌ Error al enviar alerta\n";
} else {
    echo "✅ Alerta enviada exitosamente:\n";
    echo json_encode(json_decode($response, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
}

echo "\n=== PRUEBAS COMPLETADAS ===\n";