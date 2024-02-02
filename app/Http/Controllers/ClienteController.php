<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $clie = new Cliente();
        $clie->nombre_completo = $request->nombre_completo;

        $clie->ci_nit = $request->ci_nit;
        $clie->telefono = $request->telefono;
        $clie->direccion = $request->direccion;
        $clie->save();

        return response()->json($clie, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function buscarCliente(Request $request){
        $cliente = [];
        if(isset($request->q)){
            $cliente = Cliente::where("nombre_completo", "iLike", "%$request->q%")
                                ->orwhere("ci_nit", "iLike", "%$request->q%")
                                ->orwhere("direccion", "iLike", "%$request->q%")
                                ->first();
        }
        
        return response()->json($cliente, 200);
    }
}
