<?php

use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

/**
 * Rotas da API para o módulo de agenda.
 */
Route::apiResource('schedules', ScheduleController::class);
