<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\FinanceController;

// --- REDIRECCIÓN INICIAL ---
Route::get('/', function () { return redirect('/login'); });

// --- AUTENTICACIÓN ---
Route::get('/login', function () { return view('login'); })->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/registro', function () { return view('registro'); })->name('registro');
Route::post('/registro', [AuthController::class, 'registrar'])->name('auth.registrar');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- RUTAS PROTEGIDAS (CLIENTE / DOÑA MARI) ---
Route::middleware(['auth'])->group(function () {
    
    // Resumen / Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Inventario
    Route::get('/inventario', [ProductController::class, 'index'])->name('inventario');
    Route::post('/inventario', [ProductController::class, 'store'])->name('productos.guardar');

    // Punto de Venta (POS)
    Route::get('/pos', [PosController::class, 'index'])->name('pos');
    Route::get('/pos/search', [PosController::class, 'search'])->name('pos.search');
    Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');

    // Finanzas
    Route::get('/finanzas', [FinanceController::class, 'index'])->name('finanzas');
    Route::post('/finanzas/egreso', [FinanceController::class, 'storeEgreso'])->name('finanzas.egreso');

    // Configuración (Vista simple)
    Route::get('/configuracion', function () { return view('configuracion'); })->name('configuracion');
});

// --- RUTA DEL ADMINISTRADOR ---
Route::get('/administrador', function () { return view('admin'); })->name('admin.panel')->middleware('auth');