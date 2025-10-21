<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'usMail' => 'required|string|email|unique:users',
                'usPassword' => 'required|string|min:8',
                'usDocumento' => 'required|string|unique:users',
                'usApellido' => 'required|string',
                'usNombre' => 'required|string',
                'usTelefono' => 'required|string',
                'usDomicilio' => 'required|string',
                'usProvincia' => 'required|string',
                'usLocalidad' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $user = User::create([
                'usDocumento' => $request->usDocumento,
                'usApellido' => $request->usApellido,
                'usNombre' => $request->usNombre,
                'usTelefono' => $request->usTelefono,
                'usDomicilio' => $request->usDomicilio,
                'usProvincia' => $request->usProvincia,
                'usLocalidad' => $request->usLocalidad,
                'usMail' => $request->usMail,
                'usPassword' => Hash::make($request->usPassword),
            ]);

            $user->assignRole($request->role);

            return response()->json([
                'token' => $user->createToken('API Token')->plainTextToken,
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usMail' => 'required|string|email',
            'usPassword' => 'required|string|min:8',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::where('usMail', $request->usMail)->with('roles')->first();

        if (!$user || !Hash::check($request->usPassword, $user->usPassword)) {
            return response()->json(['error' => 'Credenciales Invalidas'], 401);
        }

        // Obtén solo los nombres de los roles
        $roleNames = $user->roles->pluck('name'); // Utiliza pluck para obtener solo la columna 'name'


        return response()->json([
            'token' => $user->createToken('API Token')->plainTextToken,
            'user' => [
                'id' => $user->id,
                'usDocumento' =>  $user->usDocumento,
                'usApellido' =>  $user->usApellido,
                'usNombre' =>  $user->usNombre,
                'usTelefono' => $user->usTelefono,
                'usDomicilio' => $user->usDomicilio,
                'usProvincia' => $user->usProvincia,
                'usLocalidad' => $user->usLocalidad,
                'usMail' => $user->usMail,
                'email_verified_at' => $user->email_verified_at,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ],
            'role' => $roleNames
        ]);
    }

    public function logout(Request $request)
    {
        if (!$request->user()){
            return response()->json(['error'=> 'No autenticado'], 401);
        }

        if (!$request->user()->hasRole('administrador')) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Sesión cerrada correctamente']);        
    }
}
