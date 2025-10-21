<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $asistencias = Asistencia::all();

            if ($asistencias->isEmpty()) {
                return response()->json([
                    'message' => 'No hay rgistros de asistencias disponibles.'
                ], 404);
            }

            return response()->json([
                'message' => 'Listado de asistencias obtenido correctamente.',
                'data' => $asistencias
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtenerr las asistencias.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'idEstudiante' => 'required|exists:users,id',
                'idMateria' => 'required|exists:materias,id',
                'fecha' => 'required|date',
                'estado' => 'required|in:presente,ausente,justificado'
            ]);

            $asistencia = Asistencia::create($validated);

            return response()->json([
                'message' => 'Asistencia registrada correctamente.',
                'data' => $asistencia
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Datos inválidos para registrar la asistencia.',
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Materia o estudiante no encontrados.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar la asistencia.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $asistencia = Asistencia::findOrFail($id);

            return response()->json([
                'message' => 'Asistencia encontrada.',
                'data' => $asistencia
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Asistencia no encontrada.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al buscar la asistencia.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function edit(Asistencia $asistencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $asistencia = Asistencia::findOrFail($id);

            $validated = $request->validate([
                'estado' => 'sometimes|required|in:presente,ausente,justificado'
            ]);

            $asistencia->update($validated);

            return response()->json([
                'message' => 'Asistencia actualizada correctamente.',
                'data' => $asistencia
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Asistencia no encontrada.'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación al actualizar la asistencia.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la asistencia.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $asistencia = Asistencia::findOrFail($id);
            $asistencia->delete();

            return response()->json([
                'message' => 'Asistencia eliminada correctamente.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Asistencia no encontrada.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la asistencia.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function misAsistencias(Request $request)
    {
        try {
            $user = $request->user(); // Usuario autenticado

            // Validar que el usuario esté autenticado (aunque Sanctum ya lo hace)
            if (!$user) {
                return response()->json([
                    'message' => 'Usuario no autenticado.'
                ], 401);
            }

            // Buscar asistencias del estudiante
            $asistencias = Asistencia::where('idEstudiante', $user->id)->get();

            // Si no tiene asistencias registradas
            if ($asistencias->isEmpty()) {
                return response()->json([
                    'message' => 'No tienes asistencias registradas.'
                ], 404);
            }

            return response()->json([
                'message' => 'Asistencias del estudiante obtenidas correctamente.',
                'data' => $asistencias
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las asistencias del estudiante.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
