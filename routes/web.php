<?php

use App\Http\Controllers\AjustesController;
use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\CostoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeteccionController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\PoultryDetectionController;
use App\Http\Controllers\RutasController;
use App\Http\Controllers\SatisfaccionController;
use App\Http\Controllers\SectorController;
use Illuminate\Support\Facades\Route;

Route::get('/', RutasController::class)->name('home');

Route::get('/registro', [AutenticacionController::class, 'mostrarFormularioRegistro'])->name('vista.registro');
Route::post('/registro', [AutenticacionController::class, 'registrarUsuario'])->name('usuarios.guardar');

Route::get('/login', [AutenticacionController::class, 'mostrarFormularioLogin'])->name('login');
Route::post('/login', [AutenticacionController::class, 'iniciarSesion'])->name('usuarios.login');


Route::middleware('auth')->group(function () {

    // Dashboard

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
// routes/web.php
    Route::post('/lotes/detectar', [LoteController::class, 'detectar'])->name('lotes.detectar');


    // Mostrar los lotes de un sector
    Route::get('/sectores/{sector}/lotes', [SectorController::class, 'loteDetalle'])
        ->name('sectores.lote_detalle');

    // HISTORIAL
    Route::get('/historial', [HistorialController::class, 'index'])
        ->name('historial.index');
// Historial detallado por sector
    Route::get('/historial/sector/{sector}', [HistorialController::class, 'sectorDetalle'])
        ->name('historial.sector_detalle');



    // COSTOS
    Route::get('/costos', [CostoController::class, 'index'])->name('costos.index');
    Route::get('/costos-formulario', [CostoController::class, 'costos_form'])->name('costos.form');
    Route::put('/costos/{costo}', [CostoController::class, 'update'])->name('costos.update');

    Route::post('/costos', [CostoController::class, 'store'])->name('costos.store');

    // DETECCIONES
    Route::get('/detecciones', [DeteccionController::class, 'index'])->name('detecciones.index'); // listado
    Route::post('/detecciones', [DeteccionController::class, 'store'])->name('detecciones.store'); // guardar
    Route::get('/detecciones/{deteccion}', [DeteccionController::class, 'show'])->name('detecciones.show'); // detalle



    Route::get('/poultry/detect', [PoultryDetectionController::class, 'showUploadForm'])->name('poultry.upload');
    Route::post('/poultry/detect', [PoultryDetectionController::class, 'processImage'])->name('poultry.process');



    //SATISFACCION
    Route::post('/satisfaccion', [SatisfaccionController::class, 'store'])->name('satisfaccion.store');



});
