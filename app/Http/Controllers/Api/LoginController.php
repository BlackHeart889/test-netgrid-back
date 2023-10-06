<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            return response([
                'message' => 'Sesión iniciada.',
                'data' => [
                    'nombre' => $user->nombre,
                    'rol' => $user->roles->first()->name,
                ]
            ]);
        }

        return response([
            'error' => 'Las credenciales no son válidas.',
        ], 422);
    }

    public function logout(Request $request){
        $request->session()->invalidate();

        return response([], 201);
    }

    public function register(Request $request){
        $user = $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'rol' => 'required|exists:roles,name',
        ]);

        try {
            User::create($user)->assignRole($user['rol']);
            return response([
                'message' => 'Usuario registrado correctamente.',
            ], 200);
        } catch (\Throwable $th) {
            report($th);
            return response([
                'message' => 'Ocurrió un error al registrar el usuario.',
            ], 500);
        }
    }
}
