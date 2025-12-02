<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'camera_id',
        'location',
        'track_id',
        'alert_type',
        'description',
        'duration_seconds',
        'frame_count',
        'alert_timestamp',
        'is_viewed',
        'is_false_alarm',
        'notes'
    ];

    protected $casts = [
        'alert_timestamp' => 'datetime',
        'is_viewed' => 'boolean',
        'is_false_alarm' => 'boolean',
    ];

    protected $dates = [
        'alert_timestamp',
        'created_at',
        'updated_at'
    ];

    // Scopes para filtrado
    public function scopeRecientes($query, $horas = 24)
    {
        return $query->where('alert_timestamp', '>=', Carbon::now()->subHours($horas));
    }

    public function scopeNoVistas($query)
    {
        return $query->where('is_viewed', false);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('alert_type', $tipo);
    }

    public function scopePorCamara($query, $cameraId)
    {
        return $query->where('camera_id', $cameraId);
    }

    // Accessors
    public function getTipoLegibleAttribute()
    {
        $tipos = [
            'persona_detenida' => 'Persona Detenida',
            'movimiento_sospechoso' => 'Movimiento Sospechoso'
        ];

        return $tipos[$this->alert_type] ?? $this->alert_type;
    }

    public function getTiempoTranscurridoAttribute()
    {
        return $this->alert_timestamp->diffForHumans();
    }

    public function getNivelPrioridadAttribute()
    {
        switch ($this->alert_type) {
            case 'persona_detenida':
                return $this->duration_seconds > 60 ? 'alta' : 'media';
            case 'movimiento_sospechoso':
                return 'media';
            default:
                return 'baja';
        }
    }
}
