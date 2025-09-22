<?php

use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\MateriaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/saludo', function (Request $request) {
    return response()->json(['mensaje' => 'Hola Mundo']);
});

// Route::get('/carreras', [CarreraController::class, 'index']);

// Route::post('/carreras', [CarreraController::class, 'store']);
// Route::put('/carreras/{id}', [CarreraController::class, 'update']);
// Route::delete('/carreras/{id}', [CarreraController::class, 'destroy']);

Route::get('/carrerasConMaterias', [CarreraController::class, 'showConMaterias']);
Route::apiResource('/carreras', CarreraController::class);

Route::get('/materias', [MateriaController::class, 'index']);
Route::post('/materias', [MateriaController::class, 'store']);
Route::put('/materias/{id}', [MateriaController::class, 'update']);
Route::delete('/materias/{id}', [MateriaController::class, 'destroy']);

Route::apiResource('inscripciones', InscripcionController::class);

Route::apiResource('asistencias', AsistenciaController::class);