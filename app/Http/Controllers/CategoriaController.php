<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // listar
        $categorias = Categoria::get();
        return response()->json($categorias);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // renderizar un formulario de creación
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required"
        ]);
        // captura luego valida y guarda datos en la BD
        $cat = new  Categoria;
        $cat->nombre = $request->nombre;
        $cat->detalle = $request->detalle;
        $cat->save();

        return response()->json(["message" => "Categoria registrada"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // mostrar un formulario de edicion por id
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

}
