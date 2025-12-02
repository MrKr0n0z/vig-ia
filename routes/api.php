<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlertController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('api')->group(function () {
    // Endpoint para recibir alertas de MATLAB
    Route::post('/recibir-alerta', [AlertController::class, 'recibirAlerta']);
    
    // Endpoints adicionales para el frontend
    Route::get('/alertas', [AlertController::class, 'obtenerAlertas']);
    Route::get('/alertas/recientes', [AlertController::class, 'obtenerAlertasRecientes']);
    Route::post('/alertas/{id}/marcar-vista', [AlertController::class, 'marcarComoVista']);
    Route::delete('/alertas/{id}', [AlertController::class, 'eliminarAlerta']);
    
    // Endpoint para obtener estado del sistema
    Route::get('/sistema/estado', [AlertController::class, 'obtenerEstadoSistema']);
});