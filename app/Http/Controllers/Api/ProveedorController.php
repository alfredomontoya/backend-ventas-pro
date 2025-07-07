<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProveedorRequest;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    public function index()
    {
        return response()->json(
            Proveedor::with('referencias')->get()
        );
    }

    public function show($id)
    {
        $proveedor = Proveedor::with('referencias')->findOrFail($id);
        // $proveedor->load('referencias');
        return response()->json(    
            $proveedor->load('referencias')
        );
    }

    public function store(ProveedorRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $proveedor = Proveedor::create([
                'nombre' => $validated['nombre'],
                'razon_social' => $validated['razon_social'] ?? null,
                'nit' => $validated['nit'],
                'contacto' => $validated['contacto'] ?? null,
                'estado' => $validated['estado'] ?? true,
            ]);

            foreach ($validated['referencias'] ?? [] as $ref) {
                $proveedor->referencias()->create($ref);
            }

            DB::commit();
            return response()->json($proveedor->load('referencias'), 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al registrar proveedor',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    

    public function update(ProveedorRequest $request, Proveedor $proveedor)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Actualizar datos básicos del proveedor
            $proveedor->update([
                'nombre' => $validated['nombre'],
                'tipo_documento' => $validated['tipo_documento'],
                'numero_documento' => $validated['numero_documento'],
                'razon_social' => $validated['razon_social'] ?? null,
                'contacto' => $validated['contacto'] ?? null,
                'estado' => $validated['estado'] ?? true,
            ]);

            if (isset($validated['referencias'])) {
                // Obtener los IDs enviados en el request (los que deben quedar)
                $idsEnRequest = collect($validated['referencias'])->pluck('id')->filter()->all();

                // Eliminar referencias que no están en el request
                $proveedor->referencias()
                    ->whereNotIn('id', $idsEnRequest)
                    ->delete();

                foreach ($validated['referencias'] as $ref) {
                    if (isset($ref['id'])) {
                        // Actualizar referencia existente
                        $referenciaExistente = $proveedor->referencias()->where('id', $ref['id'])->first();
                        if ($referenciaExistente) {
                            $referenciaExistente->update([
                                'tipo' => $ref['tipo'],
                                'valor' => $ref['valor'],
                            ]);
                        }
                    } else {
                        // Crear nueva referencia
                        $proveedor->referencias()->create([
                            'tipo' => $ref['tipo'],
                            'valor' => $ref['valor'],
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json($proveedor->load('referencias'));

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al actualizar proveedor',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();
        return response()->json(['message' => 'Proveedor eliminado.']);
    }
}
