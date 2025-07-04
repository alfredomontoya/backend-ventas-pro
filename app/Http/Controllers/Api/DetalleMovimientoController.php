<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetalleMovimiento;
use Illuminate\Http\Request;

class DetalleMovimientoController extends Controller
{
    public function index()
    {
        return DetalleMovimiento::with('movimiento', 'producto')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'movimiento_id' => 'required|exists:movimientos,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'nullable|numeric|min:0',
        ]);

        $detalle = DetalleMovimiento::create($data);
        return response()->json($detalle, 201);
    }

    public function show(DetalleMovimiento $detalleMovimiento)
    {
        return $detalleMovimiento->load('movimiento', 'producto');
    }

    public function update(Request $request, DetalleMovimiento $detalleMovimiento)
    {
        $data = $request->validate([
            'cantidad' => 'sometimes|integer|min:1',
            'precio_unitario' => 'nullable|numeric|min:0',
        ]);

        $detalleMovimiento->update($data);
        return response()->json($detalleMovimiento);
    }

    public function destroy(DetalleMovimiento $detalleMovimiento)
    {
        $detalleMovimiento->delete();
        return response()->json(['message' => 'Detalle de movimiento eliminado.']);
    }
}
