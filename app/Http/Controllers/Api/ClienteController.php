<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    // Listar todos los clientes
    public function index()
    {
        return response()->json(
            Cliente::with(['telefonos', 'correos', 'direcciones'])->get()
        );
    }

    // Mostrar un cliente específico
    public function show(Cliente $cliente)
    {
        return response()->json(
            $cliente->load(['telefonos', 'correos', 'direcciones'])
        );
    }

    // Crear un nuevo cliente
    public function store(ClienteRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Crear cliente
            $cliente = Cliente::create([
                'ci' => $validated['ci'],
                'nombres' => $validated['nombres'],
                'apellido_paterno' => $validated['apellido_paterno'],
                'apellido_materno' => $validated['apellido_materno'] ?? null,
                'fecha_nacimiento' => $validated['fecha_nacimiento'] ?? null,
                'estado' => $validated['estado'] ?? true,
            ]);

            // Crear teléfonos
            foreach ($validated['telefonos'] ?? [] as $telefono) {
                $cliente->telefonos()->create([
                    'numero' => $telefono['numero'],
                    'es_principal' => $telefono['es_principal'] ?? false,
                ]);
            }

            // Crear correos
            foreach ($validated['correos'] ?? [] as $correo) {
                $cliente->correos()->create([
                    'email' => $correo['email'],
                    'es_principal' => $correo['es_principal'] ?? false,
                ]);
            }

            // Crear direcciones
            foreach ($validated['direcciones'] ?? [] as $direccion) {
                $cliente->direcciones()->create([
                    'direccion' => $direccion['direccion'],
                    'es_principal' => $direccion['es_principal'] ?? false,
                ]);
            }

            DB::commit();

            return response()->json(
                $cliente->load('telefonos', 'correos', 'direcciones'),
                201
            );

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al registrar cliente',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Actualizar un cliente
    public function update(ClienteRequest $request, Cliente $cliente)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Actualizar cliente
            $cliente->update([
                'ci' => $validated['ci'],
                'nombres' => $validated['nombres'],
                'apellido_paterno' => $validated['apellido_paterno'],
                'apellido_materno' => $validated['apellido_materno'] ?? null,
                'fecha_nacimiento' => $validated['fecha_nacimiento'] ?? null,
                'estado' => $validated['estado'] ?? true,
            ]);

            // Reemplazar teléfonos
            if (isset($validated['telefonos'])) {
                $cliente->telefonos()->delete();
                foreach ($validated['telefonos'] as $telefono) {
                    $cliente->telefonos()->create([
                        'numero' => $telefono['numero'],
                        'es_principal' => $telefono['es_principal'] ?? false,
                    ]);
                }
            }

            // Reemplazar correos
            if (isset($validated['correos'])) {
                $cliente->correos()->delete();
                foreach ($validated['correos'] as $correo) {
                    $cliente->correos()->create([
                        'email' => $correo['email'],
                        'es_principal' => $correo['es_principal'] ?? false,
                    ]);
                }
            }

            // Reemplazar direcciones
            if (isset($validated['direcciones'])) {
                $cliente->direcciones()->delete();
                foreach ($validated['direcciones'] as $direccion) {
                    $cliente->direcciones()->create([
                        'direccion' => $direccion['direccion'],
                        'es_principal' => $direccion['es_principal'] ?? false,
                    ]);
                }
            }

            DB::commit();

            return response()->json(
                $cliente->load('telefonos', 'correos', 'direcciones')
            );

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al actualizar cliente',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Eliminar un cliente
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return response()->json(['message' => 'Cliente eliminado.']);
    }
}
