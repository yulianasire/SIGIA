<?php

use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\MateriaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Public Routes (No authentication required)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Authenticated Routes (Requires Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    // Carrera Routes
    Route::middleware('role:administrador')->group(function () {
        Route::post('/carreras', [CarreraController::class, 'store']);
        Route::put('/carreras/{carrera}', [CarreraController::class, 'update']);
        Route::delete('/carreras/{carrera}', [CarreraController::class, 'destroy']);
        Route::get('/carreras-con-materias', [CarreraController::class, 'CarrerasConMaterias']);
        Route::post('/materias', [MateriaController::class, 'store']);
        Route::put('/materias/{materia}', [MateriaController::class, 'update']);
        Route::delete('/materias/{materia}', [MateriaController::class, 'destroy']);
        Route::get('/inscripciones', [InscripcionController::class, 'index']);
        Route::get('/inscripciones/{inscripcion}', [InscripcionController::class, 'show']);
        Route::post('/inscripciones', [InscripcionController::class, 'store']);
        Route::put('/inscripciones/{inscripcion}', [InscripcionController::class, 'update']);
        Route::delete('/inscripciones/{inscripcion}', [InscripcionController::class, 'destroy']);
    });

    Route::middleware('role:administrador|profesor|estudiante')->group(function () {
        Route::get('/carreras', [CarreraController::class, 'index']);
        Route::get('/carreras/{carrera}', [CarreraController::class, 'show']);
        Route::get('/inscripciones', [InscripcionController::class, 'index']);
        Route::get('/inscripciones/{inscripcion}', [InscripcionController::class, 'show']);
        Route::post('/inscripciones', [InscripcionController::class, 'store']);
        Route::put('/inscripciones/{inscripcion}', [InscripcionController::class, 'update']);
        Route::delete('/inscripciones/{inscripcion}', [InscripcionController::class, 'destroy']);
        Route::get('/materias', [MateriaController::class, 'index']);
        Route::get('/materias/{materia}', [MateriaController::class, 'show']);
        Route::get('/inscripciones', [InscripcionController::class, 'index']);
        Route::get('/inscripciones/{inscripcion}', [InscripcionController::class, 'show']);
        Route::post('/inscripciones', [InscripcionController::class, 'store']);
        Route::put('/inscripciones/{inscripcion}', [InscripcionController::class, 'update']);
        Route::delete('/inscripciones/{inscripcion}', [InscripcionController::class, 'destroy']);
    });

    // Asistencia Routes
    Route::middleware('role:administrador|profesor')->group(function () {
        Route::get('/asistencias', [AsistenciaController::class, 'index']);
        Route::get('/asistencias/{asistencia}', [AsistenciaController::class, 'show']);
        Route::post('/asistencias', [AsistenciaController::class, 'store']);
        Route::put('/asistencias/{asistencia}', [AsistenciaController::class, 'update']);
        Route::delete('/asistencias/{asistencia}', [AsistenciaController::class, 'destroy']);
    });

    Route::middleware('role:profesor')->group(function () {
        Route::get('/inscripciones', [InscripcionController::class, 'index']);
        Route::get('/inscripciones/{inscripcion}', [InscripcionController::class, 'show']);
    });

    Route::middleware('role:estudiante')->group(function () {
        // Ver todas las inscripciones del estudiante autenticado
        Route::get('/mis-inscripciones', [InscripcionController::class, 'misInscripciones']);
        // Inscribirse a una materia
        Route::post('/inscripciones', [InscripcionController::class, 'store']);
    });
});

// Route::get('/saludo', function (Request $request) { return response()->json(['mensaje' => 'Hola Mundo']); });

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
