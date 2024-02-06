<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::with(['cliente', 'productos'])->paginate(10);

        return response()->json($pedidos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "cliente_id" => "required",
            "productos" => "required"
        ]);

        DB::beginTransaction();
        try {
            $pedido = new Pedido();
            $pedido->fecha = date('Y-m-d H:i:s');
            $pedido->estado = 1;
            $pedido->observaciones = $request->observacion;
            $pedido->cliente_id = $request->cliente_id;
            $pedido->save();

            foreach ($request->productos as $prod) {
                $producto_id = $prod['producto_id'];
                $cantidad = $prod['cantidad'];

                $pedido->productos()->attach($producto_id, ["cantidad" => $cantidad]);

            }            
        
            DB::commit();
            // all good
            return response()->json(["message" => "Pedido registrado"], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["message" => "Error al registrar el pedido", "error" => $e], 422);
        }

        
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
}
