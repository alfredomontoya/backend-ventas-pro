<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VentaRequest;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        return response()->json(
            Venta::with(['cliente', 'usuario', 'detalles.producto'])->get()
        );
    }

    public function store(VentaRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $subtotal = 0;
            foreach ($validated['detalles'] as $detalle) {
                $subtotal += $detalle['cantidad'] * $detalle['precio_unitario'];
            }

            $descuento = $validated['descuento'] ?? 0;
            $total = $subtotal - $descuento;
            $cambio = $validated['monto_pagado'] - $total;

            $venta = Venta::create([
                'cliente_id' => $validated['cliente_id'] ?? null,
                'usuario_id' => $validated['usuario_id'],
                'fecha_venta' => $validated['fecha_venta'],
                'total' => $total,
                'descuento' => $descuento,
                'tipo_pago' => $validated['tipo_pago'],
                'moneda' => $validated['moneda'],
                'tipo_cambio' => $validated['tipo_cambio'],
                'monto_pagado' => $validated['monto_pagado'],
                'monto_pagado_usd' => $validated['monto_pagado_usd'],
                'cambio' => $cambio,
                'estado' => $validated['estado'] ?? 'pagada',
                'observaciones' => $validated['observaciones'] ?? null,
            ]);

            foreach ($validated['detalles'] as $detalle) {
                $venta->detalles()->create([
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'subtotal' => $detalle['cantidad'] * $detalle['precio_unitario'],
                ]);
            }

            DB::commit();

            return response()->json($venta->load('detalles.producto'), 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al registrar venta',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Venta $venta)
    {
        return response()->json($venta->load(['cliente', 'usuario', 'detalles.producto']));
    }

    public function destroy(Venta $venta)
    {
        $venta->delete();
        return response()->json(['message' => 'Venta eliminada']);
    }

    public function update(VentaRequest $request, Venta $venta)
{
    $validated = $request->validated();

    DB::beginTransaction();

    try {
            // Calcular subtotal
            $subtotal = 0;
            foreach ($validated['detalles'] as $detalle) {
                $subtotal += $detalle['cantidad'] * $detalle['precio_unitario'];
            }

            $descuento = $validated['descuento'] ?? 0;
            $total = $subtotal - $descuento;
            $cambio = $validated['monto_pagado'] - $total;

            // Actualizar la venta
            $venta->update([
                'cliente_id' => $validated['cliente_id'] ?? null,
                'usuario_id' => $validated['usuario_id'],
                'fecha_venta' => $validated['fecha_venta'],
                'total' => $total,
                'descuento' => $descuento,
                'tipo_pago' => $validated['tipo_pago'],
                'moneda' => $validated['moneda'],
                'tipo_cambio' => $validated['tipo_cambio'],
                'monto_pagado' => $validated['monto_pagado'],
                'monto_pagado_usd' => $validated['monto_pagado_usd'],
                'cambio' => $cambio,
                'estado' => $validated['estado'] ?? 'pagada',
                'observaciones' => $validated['observaciones'] ?? null,
            ]);

            // Eliminar detalles anteriores
            $venta->detalles()->delete();

            // Insertar los nuevos detalles
            foreach ($validated['detalles'] as $detalle) {
                $venta->detalles()->create([
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'subtotal' => $detalle['cantidad'] * $detalle['precio_unitario'],
                ]);
            }

            DB::commit();

            return response()->json($venta->load('detalles.producto'));

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al actualizar venta',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Reportes
    public function reporteDetalle(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        // Usar fecha actual si no se proporciona alguna
        $fechaInicio = $fechaInicio ? Carbon::parse($fechaInicio) : Carbon::today();
        $fechaFin = $fechaFin ? Carbon::parse($fechaFin) : Carbon::today();

        // Obtener las ventas en el rango de fechas
        $ventas = Venta::with('usuario', 'cliente', 'detalles.producto')
            ->whereBetween('fecha_venta', [$fechaInicio->startOfDay(), $fechaFin->endOfDay()])
            ->get();

        return response()->json($ventas);
    }

}
