<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;

// Rutas públicas (sin autenticación)
Route::prefix('auth')->group(function () {
    // Mostrar formulario de login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login.form');
    // Manejar el inicio de sesión (requiere validación)
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');
});

// Rutas protegidas por Sanctum (requiere token de autenticación)
Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
    // Cerrar sesión (requiere token válido)
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
