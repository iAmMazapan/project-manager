<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\ArchivoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rutas públicas
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Usuarios
    Route::resource('usuarios', UsuarioController::class);
    
    // Proyectos
    Route::resource('proyectos', ProyectoController::class);
    
    // Tareas
    Route::resource('tareas', TareaController::class);
    Route::patch('/tareas/{tarea}/estado', [TareaController::class, 'actualizarEstado'])->name('tareas.actualizar-estado');
    
    // Archivos
    Route::delete('/archivos/{archivo}', [ArchivoController::class, 'destroy'])->name('archivos.destroy');
    Route::get('/archivos/{archivo}/download', [ArchivoController::class, 'download'])->name('archivos.download');
});