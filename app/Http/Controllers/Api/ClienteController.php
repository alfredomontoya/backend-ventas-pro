<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with(['telefonos', 'correos', 'direcciones'])->get();
        return response()->json($clientes);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ci' => 'required|string|max:32|unique:clientes,ci',
            'nombres' => 'required|string|max:64',
            'apellido_paterno' => 'required|string|max:64',
            'apellido_materno' => 'nullable|string|max:64',
            'fecha_nacimiento' => 'nullable|date',
            'estado' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cliente = Cliente::create($validator->validated());

        return response()->json($cliente, 201);
    }

    public function show(Cliente $cliente)
    {
        $cliente->load(['telefonos', 'correos', 'direcciones']);
        return response()->json($cliente);
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validator = Validator::make($request->all(), [
            'ci' => 'sometimes|string|max:32|unique:clientes,ci,' . $cliente->id,
            'nombres' => 'sometimes|string|max:64',
            'apellido_paterno' => 'sometimes|string|max:64',
            'apellido_materno' => 'nullable|string|max:64',
            'fecha_nacimiento' => 'nullable|date',
            'estado' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cliente->update($validator->validated());

        return response()->json($cliente);
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return response()->json(null, 204);
    }
}
