<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function funLogin(Request $request){
        // validar´
        $credenciales = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        if(!Auth::attempt($credenciales)){
            return response()->json(["message"=> "Credenciales Incorrectas"], 401);
        }

        $usuario = $request->user();
        $token = $usuario->createToken("token personal")->plainTextToken;

        return response()->json([
            "access_token" => $token,
            "user" => $usuario
        ], 201);      
    }

    public function funRegister(Request $request){
        // validar
        $request->validate([
            "name" => "required",
            "email" => "required|email",
            "password" => "required",
            "c_password" => "required|same:password"
        ]);
        // registrar
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->save();

        // respuesta
        return response()->json(["message" => "Usuario registrado"], 201);

    }

    public function funProfile(Request $request){

        return response()->json($request->user());

    }

    public function funLogout(Request $request){

        $request->user()->tokens()->delete();

        return response()->json(["message" => "Logout: Salió"], 200);

    }
    
}
