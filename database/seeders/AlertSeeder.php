<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alert;
use Carbon\Carbon;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        // Crear alertas de ejemplo
        $alerts = [
            [
                'camera_id' => 'camara_01',
                'location' => 'Callejón Principal',
                'track_id' => 1,
                'alert_type' => 'persona_detenida',
                'description' => 'Persona detenida por 25 segundos en área vigilada',
                'duration_seconds' => 25,
                'frame_count' => 750,
                'alert_timestamp' => $now->subMinutes(10),
                'is_viewed' => false,
                'is_false_alarm' => false
            ],
            [
                'camera_id' => 'camara_01',
                'location' => 'Callejón Principal',
                'track_id' => 2,
                'alert_type' => 'movimiento_sospechoso',
                'description' => 'Movimiento sospechoso detectado (va-y-viene). Cambios de dirección: 6',
                'duration_seconds' => 45,
                'frame_count' => 1350,
                'alert_timestamp' => $now->subMinutes(5),
                'is_viewed' => false,
                'is_false_alarm' => false
            ],
            [
                'camera_id' => 'camara_01',
                'location' => 'Callejón Principal',
                'track_id' => 3,
                'alert_type' => 'persona_detenida',
                'description' => 'Persona permanece más de 20 segundos en área',
                'duration_seconds' => 22,
                'frame_count' => 660,
                'alert_timestamp' => $now->subMinutes(2),
                'is_viewed' => false,
                'is_false_alarm' => false
            ],
            [
                'camera_id' => 'camara_01',
                'location' => 'Callejón Principal',
                'track_id' => 1,
                'alert_type' => 'persona_detenida',
                'description' => 'Persona detenida por 65 segundos',
                'duration_seconds' => 65,
                'frame_count' => 1950,
                'alert_timestamp' => $now->subHours(2),
                'is_viewed' => true,
                'is_false_alarm' => false
            ],
            [
                'camera_id' => 'camara_01',
                'location' => 'Callejón Principal',
                'track_id' => 4,
                'alert_type' => 'movimiento_sospechoso',
                'description' => 'Comportamiento sospechoso detectado en zona de vigilancia',
                'duration_seconds' => 30,
                'frame_count' => 900,
                'alert_timestamp' => $now->subHours(4),
                'is_viewed' => true,
                'is_false_alarm' => true
            ]
        ];
        
        foreach ($alerts as $alertData) {
            Alert::create($alertData);
        }
        
        $this->command->info('Se crearon ' . count($alerts) . ' alertas de ejemplo.');
    }
}
