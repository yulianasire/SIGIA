<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $inscripciones = Inscripcion::all();
            return response()->json([
                'message' => 'Inscripciones obtenidas correctamente',
                'data' => $inscripciones
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las inscripciones',
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
        try{
        $request->validate([
            'idEstudiante' => 'required|exists:users,usId',
            'idMateria' => 'required|exists:materias,matId',
            'insCicloLectivo' => 'required|string|max:10',
            'insEstado' => 'required|string|max:20',
        ]);

        $inscripcion = Inscripcion::create([
            'idEstudiante' => $request->idEstudiante,
            'idMateria' => $request->idMateria,
            'insCicloLectivo' => $request->insCicloLectivo,
            'insEstado' => $request->insEstado,
        ]);

            return response()->json([
                'message' => 'Inscripción creada correctamente',
                'data' => $inscripcion
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Datos enviados no válidos',
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear la inscripción',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    /**
     * $id???
     * @param \App\Models\Inscripcion $inscripcion
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Inscripcion $inscripcion)
    {
        try {
            $inscripcion = Inscripcion::with(['estudiante', 'materia'])->findOrFail($inscripcion->id);

            return response()->json([
                'message' => 'Inscripción encontrada',
                'data' => $inscripcion
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Inscripción no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al buscar la inscripción',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function edit(Inscripcion $inscripcion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'idEstudiante' => 'required|integer|exists:users,id',
                'idMateria' => 'required|integer|exists:materias,id',
                'insCicloLectivo' => 'required|string|max:20',
                'insEstado' => 'required|string|max:50'
            ]);

            $inscripcion = Inscripcion::findOrFail($id);
            $inscripcion->update($request->all());

            return response()->json([
                'message' => 'Inscripción actualizada correctamente',
                'data' => $inscripcion
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Datos enviados no válidos',
                'errors' => $e->validator->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Inscripción no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la inscripción',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inscripcion  $inscripcion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $inscripcion = Inscripcion::findOrFail($id);
            $inscripcion->delete();

            return response()->json([
                'message' => 'Inscripción eliminada correctamente'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Inscripción no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la inscripción',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function misInscripciones(Request $request)
{
    try {
        $userId = $request->user()->usId; // ID del usuario autenticado
        $inscripciones = Inscripcion::with(['materia'])
            ->where('idEstudiante', $userId)
            ->get();

        return response()->json([
            'message' => 'Inscripciones del estudiante autenticado obtenidas correctamente.',
            'data' => $inscripciones
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al obtener las inscripciones del estudiante.',
            'error' => $e->getMessage()
        ], 500);
    }
}
}