<?php

use App\Http\Controllers\AjustesController;
use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\CostoController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\RutasController;
use App\Http\Controllers\SectorController;
use Illuminate\Support\Facades\Route;

Route::get('/', RutasController::class)->name('home');

Route::get('/registro', [AutenticacionController::class, 'mostrarFormularioRegistro'])->name('vista.registro');
Route::post('/registro', [AutenticacionController::class, 'registrarUsuario'])->name('usuarios.guardar');

Route::get('/login', [AutenticacionController::class, 'mostrarFormularioLogin'])->name('login');
Route::post('/login', [AutenticacionController::class, 'iniciarSesion'])->name('usuarios.login');


Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // Ajustes
    Route::get('/ajustes', [AjustesController::class, 'mostrarformulario'])->name('vista.ajustes');
    // Sectoresvista.ajustes
    Route::get('/sectores', [SectorController::class, 'index'])->name('sectores.index'); // Lista sectores
    Route::post('/sectores', [SectorController::class, 'store'])->name('sectores.store'); // Guardar sector
    Route::put('/sectores/{sector}', [SectorController::class, 'update'])->name('sectores.update');
    Route::delete('/sectores/{sector}', [SectorController::class, 'destroy'])->name('sectores.destroy'); // Eliminar sector

    // LOTES
    Route::get('/lotes', [LoteController::class, 'index'])->name('lotes.index'); // Lista lotes
    Route::post('/lotes', [LoteController::class, 'store'])->name('lotes.store'); // Guardar lote
    Route::put('/lotes/{lote}', [LoteController::class, 'update'])->name('lotes.update'); // Actualizar
    Route::delete('/lotes/{lote}', [LoteController::class, 'destroy'])->name('lotes.destroy'); // Eliminar

    // Mostrar los lotes de un sector
    Route::get('/sectores/{sector}/lotes', [SectorController::class, 'loteDetalle'])
        ->name('sectores.lote_detalle');

    // HISTORIAL
    Route::get('/historial', [HistorialController::class, 'index'])
        ->name('historial.index');
    Route::get('/costos', [CostoController::class, 'index'])->name('costos.index');


});
