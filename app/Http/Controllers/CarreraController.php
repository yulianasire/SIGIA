<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carreras = Carrera::all();
        return response()->json($carreras);
    }

    public function showConMaterias()
    {
        return Carrera::with('materias')->get();
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
                'nombre' => 'required|string|max:200|mix:10',
            ]);
            $myCarrera = new Carrera;
            $myCarrera->nombre = $request->nombre;
            $myCarrera->save();

             return response()->json([
                'message' => 'Carrera creada correctamente',
                'data' => $myCarrera
            ])->setStatusCode(201);

        } catch (ValidationException $e) {
            // Manejar la excepción de validación
            return response()->json([
                'message' => 'Datos enviados no válidos',
                'errors' => $e->validator->errors()
            ], 400); // Código de estado 422 para errores de validación

        } catch (\Exception $e){
            return response()->json([
                'message' => 'Error al crear la carrera',
                'error' => $e->getMessage()
            ], 500);
        }
            
        // $carrera = Carrera::create($request->all());
        // return response()->json($carrera, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function show(Carrera $carrera)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function edit(Carrera $carrera)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $myCarrera = Carrera::find($id);
        $myCarrera->nombre = $request->nombre;
        $myCarrera->save();

        return response()->json($myCarrera, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $myCarrera = Carrera::destroy($id);

        return response()->json($myCarrera, 200);
    }
}
