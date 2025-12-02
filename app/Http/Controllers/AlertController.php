<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alert;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Exception;

class AlertController extends Controller
{
    /**
     * Recibe alertas desde MATLAB
     */
    public function recibirAlerta(Request $request): JsonResponse
    {
        try {
            // Validar los datos recibidos
            $validated = $request->validate([
                'camera_id' => 'required|string|max:100',
                'location' => 'required|string|max:255',
                'track_id' => 'required|integer',
                'alert_type' => 'required|in:persona_detenida,movimiento_sospechoso',
                'description' => 'required|string',
                'duration_seconds' => 'required|integer|min:0',
                'frame_count' => 'required|integer|min:0',
                'timestamp' => 'required|string'
            ]);

            // Parsear el timestamp de MATLAB
            $alertTimestamp = Carbon::createFromFormat('Y-m-d H:i:s', $validated['timestamp']);

            // Crear la alerta en la base de datos
            $alert = Alert::create([
                'camera_id' => $validated['camera_id'],
                'location' => $validated['location'],
                'track_id' => $validated['track_id'],
                'alert_type' => $validated['alert_type'],
                'description' => $validated['description'],
                'duration_seconds' => $validated['duration_seconds'],
                'frame_count' => $validated['frame_count'],
                'alert_timestamp' => $alertTimestamp,
                'is_viewed' => false,
                'is_false_alarm' => false
            ]);

            // Log para debugging
            Log::info('Nueva alerta recibida', [
                'alert_id' => $alert->id,
                'camera_id' => $validated['camera_id'],
                'track_id' => $validated['track_id'],
                'alert_type' => $validated['alert_type']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Alerta recibida correctamente',
                'alert_id' => $alert->id,
                'data' => [
                    'id' => $alert->id,
                    'camera_id' => $alert->camera_id,
                    'track_id' => $alert->track_id,
                    'alert_type' => $alert->alert_type,
                    'timestamp' => $alert->alert_timestamp->toISOString()
                ]
            ], 201);

        } catch (ValidationException $e) {
            Log::warning('Error de validación en alerta', [
                'errors' => $e->errors(),
                'data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Datos de alerta inválidos',
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {
            Log::error('Error al procesar alerta', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene todas las alertas con filtros opcionales
     */
    public function obtenerAlertas(Request $request): JsonResponse
    {
        try {
            $query = Alert::query()->orderBy('alert_timestamp', 'desc');

            // Filtros opcionales
            if ($request->has('camera_id')) {
                $query->porCamara($request->camera_id);
            }

            if ($request->has('alert_type')) {
                $query->porTipo($request->alert_type);
            }

            if ($request->has('horas')) {
                $query->recientes((int) $request->horas);
            }

            if ($request->boolean('solo_no_vistas')) {
                $query->noVistas();
            }

            // Paginación
            $perPage = $request->get('per_page', 15);
            $alerts = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $alerts->items(),
                'pagination' => [
                    'current_page' => $alerts->currentPage(),
                    'last_page' => $alerts->lastPage(),
                    'per_page' => $alerts->perPage(),
                    'total' => $alerts->total()
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener alertas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene alertas recientes (últimas 24 horas)
     */
    public function obtenerAlertasRecientes(): JsonResponse
    {
        try {
            $alerts = Alert::recientes(24)
                ->orderBy('alert_timestamp', 'desc')
                ->limit(50)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $alerts->map(function ($alert) {
                    return [
                        'id' => $alert->id,
                        'camera_id' => $alert->camera_id,
                        'location' => $alert->location,
                        'track_id' => $alert->track_id,
                        'alert_type' => $alert->alert_type,
                        'tipo_legible' => $alert->tipo_legible,
                        'description' => $alert->description,
                        'duration_seconds' => $alert->duration_seconds,
                        'frame_count' => $alert->frame_count,
                        'alert_timestamp' => $alert->alert_timestamp->toISOString(),
                        'tiempo_transcurrido' => $alert->tiempo_transcurrido,
                        'is_viewed' => $alert->is_viewed,
                        'is_false_alarm' => $alert->is_false_alarm,
                        'nivel_prioridad' => $alert->nivel_prioridad
                    ];
                }),
                'count' => $alerts->count()
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener alertas recientes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Marca una alerta como vista
     */
    public function marcarComoVista(Request $request, $id): JsonResponse
    {
        try {
            $alert = Alert::findOrFail($id);
            
            $alert->update([
                'is_viewed' => true,
                'notes' => $request->input('notes', $alert->notes)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Alerta marcada como vista',
                'data' => $alert
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al marcar alerta como vista',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina una alerta (marcar como falsa alarma)
     */
    public function eliminarAlerta($id): JsonResponse
    {
        try {
            $alert = Alert::findOrFail($id);
            
            $alert->update([
                'is_false_alarm' => true,
                'is_viewed' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Alerta marcada como falsa alarma'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar alerta',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene el estado del sistema
     */
    public function obtenerEstadoSistema(): JsonResponse
    {
        try {
            // Calcular estadísticas del sistema (solo alertas válidas)
            // Filtrar alertas válidas: no falsas alarmas, no pruebas, y recientes (menos de 2 horas)
            $alertasValidasRecientes = Alert::where('is_false_alarm', false)
                ->where('track_id', '<', 900) // Excluir IDs de prueba
                ->where('created_at', '>=', now()->subHours(2)) // Solo últimas 2 horas
                ->where('description', 'NOT LIKE', '%PRUEBA%')
                ->count();
            
            $alertasNoVistasValidas = Alert::where('is_viewed', false)
                ->where('is_false_alarm', false)
                ->where('track_id', '<', 900)
                ->where('description', 'NOT LIKE', '%PRUEBA%')
                ->count();
            
            $alertasDetenidasValidas = Alert::where('alert_type', 'persona_detenida')
                ->where('is_false_alarm', false)
                ->where('track_id', '<', 900)
                ->where('created_at', '>=', now()->subHours(2))
                ->where('description', 'NOT LIKE', '%PRUEBA%')
                ->count();
            
            $alertasSospechosasValidas = Alert::where('alert_type', 'movimiento_sospechoso')
                ->where('is_false_alarm', false)
                ->where('track_id', '<', 900)
                ->where('created_at', '>=', now()->subHours(2))
                ->where('description', 'NOT LIKE', '%PRUEBA%')
                ->count();

            // Determinar nivel de amenaza basado SOLO en alertas válidas
            $nivelAmenaza = 1; // Normal
            if ($alertasValidasRecientes > 2) {
                $nivelAmenaza = 2; // Precaución
            }
            if ($alertasDetenidasValidas > 0 || $alertasValidasRecientes > 5) {
                $nivelAmenaza = 3; // Crítico
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'alertas_24h' => $alertasValidasRecientes,
                    'alertas_no_vistas' => $alertasNoVistasValidas,
                    'alertas_detenidas' => $alertasDetenidasValidas,
                    'alertas_sospechosas' => $alertasSospechosasValidas,
                    'nivel_amenaza' => $nivelAmenaza,
                    'cameras_activas' => $alertasValidasRecientes > 0 ? '1/1' : '0/1',
                    'matlab_connected' => $alertasValidasRecientes > 0,
                    'ultima_actualizacion' => now()->toISOString()
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estado del sistema',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
