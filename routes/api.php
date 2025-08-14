<?php

use App\Http\Controllers\CarreraController;
use App\Http\Controllers\MateriaController;
 use App\Models\Materia;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Route;
 
 Route::get('/saludo', function (Request $request) {
 return response()->json(['mensaje' => 'Hola Mundo']);
 });

 Route::get('/carreras', [CarreraController::class, 'index']);

 Route::get('/materias', [MateriaController::class, 'index']);