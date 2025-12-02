<?php

$apiUrl = 'https://vig-ia-production.up.railway.app/api/alertas';

echo "🧹 Limpiando base de datos de producción...\n";

// Obtener todas las alertas
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);

if (!$data || !$data['success']) {
    die("❌ Error obteniendo alertas\n");
}

$alertas = $data['data'];
$eliminadas = 0;

echo "📊 Total de alertas en BD: " . count($alertas) . "\n";

foreach ($alertas as $alerta) {
    // Determinar si es una alerta a eliminar
    $esAlertaPrueba = $alerta['track_id'] >= 900 || 
                     strpos($alerta['description'], 'PRUEBA') !== false;
    
    $esFalsaAlarma = $alerta['is_false_alarm'] === true;
    
    // Alertas muy antiguas (más de 1 día)
    $fechaAlerta = strtotime($alerta['created_at'] ?? $alerta['alert_timestamp']);
    $unDiaAtras = time() - (24 * 60 * 60);
    $esMuyAntigua = $fechaAlerta < $unDiaAtras;
    
    if ($esAlertaPrueba || $esFalsaAlarma || $esMuyAntigua) {
        echo "🗑️  Eliminando ID {$alerta['id']}: Track {$alerta['track_id']} - " . 
             substr($alerta['description'], 0, 50) . "...\n";
        
        // Eliminar la alerta
        $deleteUrl = "https://vig-ia-production.up.railway.app/api/alertas/{$alerta['id']}";
        $options = [
            'http' => [
                'header' => "Content-type: application/json\r\n",
                'method' => 'DELETE'
            ]
        ];
        
        $context = stream_context_create($options);
        $result = @file_get_contents($deleteUrl, false, $context);
        
        if ($result) {
            $eliminadas++;
        } else {
            echo "   ❌ Error eliminando alerta {$alerta['id']}\n";
        }
        
        // Pausa para no saturar el servidor
        usleep(200000); // 0.2 segundos
    }
}

echo "\n✅ Limpieza completada!\n";
echo "📊 Alertas eliminadas: $eliminadas\n";
echo "📊 Alertas restantes: " . (count($alertas) - $eliminadas) . "\n";

// Verificar el estado final
echo "\n🔄 Verificando estado del sistema...\n";
$estadoResponse = file_get_contents('https://vig-ia-production.up.railway.app/api/sistema/estado');
$estadoData = json_decode($estadoResponse, true);

if ($estadoData && $estadoData['success']) {
    $estado = $estadoData['data'];
    echo "📊 Estado final:\n";
    echo "   - Alertas 24h: {$estado['alertas_24h']}\n";
    echo "   - Personas detenidas: {$estado['alertas_detenidas']}\n";
    echo "   - Movimientos sospechosos: {$estado['alertas_sospechosas']}\n";
    echo "   - Nivel de amenaza: {$estado['nivel_amenaza']}\n";
}

echo "\n🌐 Ve a: https://vig-ia-production.up.railway.app/ para verificar\n";
?>