<?php

echo "🧹 LIMPIADOR DE ALERTAS - VIG-IA PRODUCCIÓN\n";
echo "==========================================\n\n";

$alertasUrl = 'https://vig-ia-production.up.railway.app/api/alertas';

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

// Obtener todas las alertas
echo "📡 Obteniendo alertas de la base de datos...\n";
$response = @file_get_contents($alertasUrl);

if ($response === false) {
    die("❌ Error conectando con la API\n");
}

$data = json_decode($response, true);
if (!$data || !$data['success']) {
    die("❌ Error en respuesta de la API\n");
}

$alertas = $data['data'];
$totalAlertas = count($alertas);

echo "📊 Total de alertas en BD: $totalAlertas\n\n";

if ($totalAlertas === 0) {
    echo "✅ No hay alertas para limpiar.\n";
    exit(0);
}

// Mostrar resumen
$alertasPrueba = 0;
$alertasReales = 0;
$alertasFalsas = 0;

foreach ($alertas as $alerta) {
    if ($alerta['track_id'] >= 999 || strpos($alerta['description'], 'PRUEBA') !== false) {
        $alertasPrueba++;
    } elseif ($alerta['is_false_alarm'] === true) {
        $alertasFalsas++;
    } else {
        $alertasReales++;
    }
}

echo "📋 Resumen:\n";
echo "   - Alertas de prueba: $alertasPrueba\n";
echo "   - Falsas alarmas: $alertasFalsas\n";
echo "   - Alertas reales: $alertasReales\n\n";

echo "Opciones de limpieza:\n";
echo "1. Eliminar solo alertas de prueba ($alertasPrueba alertas)\n";
echo "2. Eliminar alertas de prueba y falsas alarmas (" . ($alertasPrueba + $alertasFalsas) . " alertas)\n";
echo "3. Eliminar TODAS las alertas ($totalAlertas alertas) - ¡CUIDADO!\n";
echo "4. Cancelar\n\n";

echo "Selecciona una opción (1, 2, 3 o 4): ";
$opcion = trim(fgets(STDIN));

$alertasEliminar = [];

switch ($opcion) {
    case '1':
        echo "\n🎯 Eliminando solo alertas de prueba...\n";
        foreach ($alertas as $alerta) {
            if ($alerta['track_id'] >= 999 || strpos($alerta['description'], 'PRUEBA') !== false) {
                $alertasEliminar[] = $alerta;
            }
        }
        break;
        
    case '2':
        echo "\n🎯 Eliminando alertas de prueba y falsas alarmas...\n";
        foreach ($alertas as $alerta) {
            if ($alerta['track_id'] >= 999 || 
                strpos($alerta['description'], 'PRUEBA') !== false || 
                $alerta['is_false_alarm'] === true) {
                $alertasEliminar[] = $alerta;
            }
        }
        break;
        
    case '3':
        echo "\n⚠️ ¡ADVERTENCIA! Esto eliminará TODAS las alertas.\n";
        echo "¿Estás completamente seguro? Escribe 'ELIMINAR TODO' para confirmar: ";
        $confirmacion = trim(fgets(STDIN));
        if ($confirmacion === 'ELIMINAR TODO') {
            echo "\n💥 Eliminando TODAS las alertas...\n";
            $alertasEliminar = $alertas;
        } else {
            echo "Confirmación incorrecta. Operación cancelada.\n";
            exit(0);
        }
        break;
        
    case '4':
        echo "Operación cancelada por el usuario.\n";
        exit(0);
        
    default:
        echo "❌ Opción no válida.\n";
        exit(1);
}

// Proceder con la eliminación
$eliminadas = 0;
$errores = 0;

foreach ($alertasEliminar as $alerta) {
    echo "🗑️ Eliminando ID {$alerta['id']}: Track {$alerta['track_id']} - " . 
         substr($alerta['description'], 0, 50) . "...\n";
    
    if (deleteAlert($alerta['id'])) {
        $eliminadas++;
    } else {
        $errores++;
        echo "   ❌ Error eliminando esta alerta\n";
    }
    
    // Pausa pequeña para no saturar el servidor
    usleep(100000); // 0.1 segundos
}

echo "\n✅ Proceso completado!\n";
echo "📊 Resultados:\n";
echo "   - Alertas eliminadas: $eliminadas\n";
echo "   - Errores: $errores\n";
echo "   - Alertas restantes: " . ($totalAlertas - $eliminadas) . "\n\n";

echo "🌐 Ve a: https://vig-ia-production.up.railway.app/ para verificar\n";
?>