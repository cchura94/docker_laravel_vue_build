<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    }

    public function funProfile(Request $request){

    }

    public function funLogout(Request $request){

    }
    
}
