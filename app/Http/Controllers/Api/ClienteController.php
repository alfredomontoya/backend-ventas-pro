<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use BadMethodCallException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class ClienteController extends Controller
{
    // Listar todos los clientes
    public function index(Request $request)
    {
        try {
            $query = Cliente::with(['telefonos', 'correos', 'direcciones']);

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('ci', 'like', "%$search%")
                    ->orWhere('nombres', 'like', "%$search%")
                    ->orWhere('apellido_paterno', 'like', "%$search%");
                });
            }

            $clientes = $query->paginate(10);


            return response()->json([
                'success' => true,
                'data' => $clientes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener clientes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Mostrar un cliente específico
    public function show($id)
    {
        try {
            $cliente = Cliente::with(['telefonos', 'correos', 'direcciones'])
                            ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $cliente
            ]);

        } catch (ModelNotFoundException $e) {
            Log::warning("Cliente no encontrado: ID $id");

            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado'
            ], 404);

        } catch (BadMethodCallException $e) {
            Log::error("Relación no válida solicitada en ClienteController@show: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener relaciones del cliente.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);

        } catch (\Exception $e) {
            Log::error("Error inesperado en ClienteController@show: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
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
    public function update(ClienteRequest $request, int $id)
    {

        try {
            $cliente = Cliente::findOrFail($id); // Solo verificamos existencia aquí
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Cliente no encontrado'
            ], 404);
        }
        
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
    public function destroy(int $id)
    {
        try {
            $cliente = Cliente::findOrFail($id); // Solo verificamos existencia aquí
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Cliente no encontrado'
            ], 404);
        }
        try {
            $cliente->delete();
            return response()->json(['message' => 'Cliente eliminado.']);
        } catch (\Throwable $e) {
            //throw $th;
            return response()->json([
                'error' => 'Error al eliminar cliente',
                'message' => $e->getMessage(),
            ], 500);
        }
        
    }
}
