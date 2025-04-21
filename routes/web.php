<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CollectionRequestController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\AdminDashboardController;

// 1. Página de bienvenida (sin autenticación)
Route::get('/', fn() => view('welcome'))->name('welcome');

// 2. Rutas de autenticación
require __DIR__ . '/auth.php';

// 3. (Eliminado) Verificación de email -> ya incluida por Laravel Breeze o Fortify

// 4. Inicio después del login
Route::get('/home', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home');

// 5. Rutas protegidas por autenticación y verificación
Route::middleware(['auth', 'verified'])->group(function () {
    // Perfil
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Solicitudes de recolección (usuario)
    Route::prefix('collection-requests')->name('collection_requests.')->group(function () {
        Route::get('/', [CollectionRequestController::class, 'index'])->name('index');
        Route::get('create', [CollectionRequestController::class, 'create'])->name('create');
        Route::post('/', [CollectionRequestController::class, 'store'])->name('store');
        Route::patch('{request}/status', [CollectionRequestController::class, 'updateStatus'])->name('update_status');
    });

    // Colecciones (usuario)
    Route::prefix('collections')->name('collections.')->group(function () {
        Route::get('/', [CollectionController::class, 'index'])->name('index');
        Route::get('create', [CollectionController::class, 'create'])->name('create');
        Route::post('/', [CollectionController::class, 'store'])->name('store');
        Route::get('my', [CollectionController::class, 'myCollections'])->name('my');
    });
});

// 6. Panel del administrador (requiere middleware 'admin')
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::prefix('admin/collection-requests')->name('admin.collection_requests.')->group(function () {
        Route::get('/', [CollectionRequestController::class, 'adminIndex'])->name('index');
        Route::get('create', [CollectionRequestController::class, 'create'])->name('create');
        Route::post('/', [CollectionRequestController::class, 'store'])->name('store');
        Route::patch('{request}/status', [CollectionRequestController::class, 'updateStatus'])->name('update_status');
    });

    Route::prefix('admin/collections')->name('admin.collections.')->group(function () {
        Route::get('/', [CollectionController::class, 'index'])->name('index');
        Route::get('create', [CollectionController::class, 'create'])->name('create');
        Route::post('/', [CollectionController::class, 'store'])->name('store');
    });
});
