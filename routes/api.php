<?php

use App\Http\Controllers\PersonaController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// end point user (crud)
Route::apiResource("user", UserController::class);
// end point persona (crud)
Route::apiResource("persona", PersonaController::class);

