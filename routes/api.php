<?php

use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\MateriaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/saludo', function (Request $request) {
    return response()->json(['mensaje' => 'Hola Mundo']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/login', [AuthController::class, 'login']);


// Authenticated Routes (Requires Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
     Route::get('/user', function (Request $request) {
        return $request->user();
    });

    

    Route::post('/logout', [AuthController::class, 'logout']);
     // Carrera Routes
    Route::middleware('role:administrador')->group(function () {
        Route::post('carreras', [CarreraController::class, 'store']);
        Route::put('carreras/{id}', [CarreraController::class, 'update']);
        Route::delete('carreras/{id}', [CarreraController::class, 'destroy']);

        Route::post('materias', [MateriaController::class, 'store']);
        Route::put('materias/{id}', [MateriaController::class, 'update']);
        Route::delete('materias/{id}', [MateriaController::class, 'destroy']);
        Route::get('/carrerasConMaterias', [CarreraController::class, 'showConMaterias']);
    });

    Route::middleware('role:administrador|profesor|estudiante')->group(function () {
        // Rutas para Carreras
        Route::get('carreras', [CarreraController::class, 'index']);
        Route::get('carrerasWithUC', [CarreraController::class, 'showWithUC']);
        //Route::get('/carreras/{id}', [CarrerasController::class, 'show']);


        // Rutas para Unidades Curriculares
        Route::get('materias', [MateriaController::class, 'index']);
        
    });
 
});



// Route::get('/carreras', [CarreraController::class, 'index']);

// Route::post('/carreras', [CarreraController::class, 'store']);
// Route::put('/carreras/{id}', [CarreraController::class, 'update']);
// Route::delete('/carreras/{id}', [CarreraController::class, 'destroy']);


// Route::apiResource('/carreras', CarreraController::class);

// Route::get('/materias', [MateriaController::class, 'index']);
// Route::post('/materias', [MateriaController::class, 'store']);
// Route::put('/materias/{id}', [MateriaController::class, 'update']);
// Route::delete('/materias/{id}', [MateriaController::class, 'destroy']);

// Route::apiResource('inscripciones', InscripcionController::class);

// Route::apiResource('asistencias', AsistenciaController::class);

