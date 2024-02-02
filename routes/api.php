<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/perfil', function (Request $request) {
    return $request->user();
});

// end point user (crud)
Route::apiResource("user", UserController::class);
// end point persona (crud)
Route::apiResource("persona", PersonaController::class);

// Autenticación

Route::prefix('v1/auth')->group(function(){

    Route::post("login", [AuthController::class, 'funLogin']);
    Route::post("register", [AuthController::class, 'funRegister']);
    
    Route::middleware('auth:sanctum')->group(function(){
    
        Route::get("profile", [AuthController::class, 'funProfile']);
        Route::post("logout", [AuthController::class, 'funLogout']);
    
    });
});

Route::middleware('auth:sanctum')->group(function(){
    // subida de imagenes
    Route::post("producto/{id}/carga-imagen", [ProductoController::class, "actualizarImagen"]);

    // buscar cliente
    Route::get("/cliente/buscar", [ClienteController::class, "buscarCliente"]);
    
    Route::apiResource("categoria", CategoriaController::class);
    Route::apiResource("producto", ProductoController::class);
    Route::apiResource("cliente", ClienteController::class);

});

Route::get("/no-autorizado", function(){

    return response()->json(["mensahe" => "No estas autorizado para ver esta pagina"]);

})->name('login');
