<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = $request->q;
        // listar
        // $categorias = Categoria::orderBy('id', 'asc')->where('estado', true)->get();
        $categorias = Categoria::orderBy('id', 'asc')->where('nombre', 'like', "%".$buscar."%")->get();
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
            "nombre" => "required|unique:categorias"
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
        $categoria = Categoria::find($id);

        return response()->json($categoria, 200);
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
        $request->validate([
            "nombre" => "required|unique:categorias,nombre,$id"
        ]);

        $categoria = Categoria::find($id);
        $categoria->nombre = $request->nombre;
        $categoria->detalle = $request->detalle;
        $categoria->update();

        return response()->json(["message" => "La categoria ha sido actualizada"], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria = Categoria::find($id);
        $categoria->delete();

        return response()->json(["message" => "La categoria ha sido eliminada"], 200);
    }

}
