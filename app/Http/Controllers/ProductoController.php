<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     * obtener lista de productos, busqueda, paginacion
     */
    public function index(Request $request)
    {
        $limit = $request->limit?$request->limit:10;
        if(isset($request->q)){
            $productos = Producto::with('categoria')->orderBy('id', 'desc')->where('nombre', 'ilike', "%".$request->q."%")->paginate($limit);
        }else{
            $productos = Producto::with('categoria')->orderBy('id', 'desc')->paginate($limit);
        }

        return response()->json($productos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required|unique:productos",
            "precio" => "required",
            "stock" => "required",
            "estado" => "required",
            "categoria_id" => "required"
        ]);

        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;
        $producto->estado = $request->estado;
        $producto->categoria_id = $request->categoria_id;
        $producto->save();

        return response()->json(["message" => "Producto Registrado"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::findOrFail($id);

        return response()->json($producto, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "nombre" => "required",
            "categoria_id" => "required"
        ]);

        $producto = Producto::findOrFail($id);
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;
        $producto->estado = $request->estado;
        $producto->categoria_id = $request->categoria_id;
        $producto->update();

        return response()->json(["message" => "Producto Actualizado"], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->estado = false;

        $producto->update();
        return response()->json(["message" => "Producto Inactivado"], 200);
    }

    public function actualizarImagen(Request $request, $id){

        if($file = $request->file('imagen')){
            $direccion_imagen = time()."-". $file->getClientOriginalName();
            $file->move("imagenes/", $direccion_imagen);

            $direccion_imagen = "imagenes/".$direccion_imagen;

            $producto = Producto::find($id);
            $producto->imagen = $direccion_imagen;
            $producto->update();

            return response()->json(["message" => "Imagen actualizado"], 200);

        }else{
            return response()->json(["message" => "La Imagen es Obligatorio"], 422);
        }

    }
}
