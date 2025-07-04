<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovimientoController extends Controller
{
    public function index()
    {
        return Movimiento::with('usuario', 'almacen')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo' => 'required|in:entrada,salida,ajuste',
            'motivo' => 'nullable|string|max:255',
            'usuario_id' => 'required|exists:users,id',
            'almacen_id' => 'required|exists:almacenes,id',
            'observaciones' => 'nullable|string',
            'detalles' => 'required|array|min:1',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Crear el movimiento
            $movimiento = Movimiento::create([
                'tipo' => $data['tipo'],
                'motivo' => $data['motivo'] ?? null,
                'usuario_id' => $data['usuario_id'],
                'almacen_id' => $data['almacen_id'],
                'observaciones' => $data['observaciones'] ?? null,
            ]);

            // Crear detalles
            foreach ($data['detalles'] as $detalle) {
                $movimiento->detalles()->create([
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'] ?? null,
                ]);
            }

            DB::commit();

            return response()->json($movimiento->load('detalles.producto'), 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al registrar movimiento',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function show(Movimiento $movimiento)
    {
        return $movimiento->load('usuario', 'almacen', 'detalles.producto');
    }

    public function update(Request $request, Movimiento $movimiento)
    {
        $data = $request->validate([
            'tipo' => 'required|in:entrada,salida,ajuste',
            'motivo' => 'nullable|string|max:255',
            'usuario_id' => 'required|exists:users,id',
            'almacen_id' => 'required|exists:almacenes,id',
            'observaciones' => 'nullable|string',
            'detalles' => 'required|array|min:1',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Actualizar el movimiento
            $movimiento->update([
                'tipo' => $data['tipo'],
                'motivo' => $data['motivo'] ?? null,
                'usuario_id' => $data['usuario_id'],
                'almacen_id' => $data['almacen_id'],
                'observaciones' => $data['observaciones'] ?? null,
            ]);

            // Eliminar detalles antiguos
            $movimiento->detalles()->delete();

            // Crear los nuevos
            foreach ($data['detalles'] as $detalle) {
                $movimiento->detalles()->create([
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'] ?? null,
                ]);
            }

            DB::commit();

            return response()->json($movimiento->load('detalles.producto'));

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al actualizar movimiento',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Movimiento $movimiento)
    {
        $movimiento->delete();
        return response()->json(['message' => 'Movimiento eliminado.']);
    }
}
