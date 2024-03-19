<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// rotas liberadas (não precisa de login)
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// retorna infos do perfil do usuário
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// rotas de schedules, que necessitam de login
Route::apiResource('schedules', ScheduleController::class)
    ->middleware('auth:sanctum');

