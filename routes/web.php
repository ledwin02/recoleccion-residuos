<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CollectionRequestController;

Route::get('/', function () {
    return view('welcome');
});

// Esta línea tenía un error de sintaxis (punto y coma mal ubicado)
Route::get('/dashboard', function () {
    return redirect()->route('collections.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas protegidas
Route::middleware(['auth', 'verified'])->group(function () {

    // Solicitudes de recolección (usuarios y admin)
    Route::prefix('collection-requests')->name('collection_requests.')->group(function () {
        Route::get('/', [CollectionRequestController::class, 'index'])->name('index');
        Route::get('/create', [CollectionRequestController::class, 'create'])->name('create');
        Route::post('/', [CollectionRequestController::class, 'store'])->name('store');
        Route::patch('/{collectionRequest}/status', [CollectionRequestController::class, 'updateStatus'])->name('update_status');
        Route::get('/admin', [CollectionRequestController::class, 'adminIndex'])->name('admin_index');
    });

    // Colecciones del usuario
    Route::prefix('collections')->name('collections.')->group(function () {
        Route::get('/', [CollectionController::class, 'index'])->name('index');
        Route::get('/create', [CollectionController::class, 'create'])->name('create');
        Route::post('/', [CollectionController::class, 'store'])->name('store');
        Route::get('/my', [CollectionController::class, 'myCollections'])->name('my');
        // Route::get('/schedule', [CollectionController::class, 'schedule'])->name('schedule'); // ← revisar si existe
    });

    // Perfil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
