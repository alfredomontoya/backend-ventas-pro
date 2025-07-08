<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DerivacionRequest;
use App\Models\Derivacion;

class DerivacionController extends Controller
{
    public function index()
    {
        // Devuelve todas las derivaciones con sus relaciones
        return Derivacion::with(['tramite', 'usuarioOrigen', 'usuarioDestino'])->get();
    }

    public function store(DerivacionRequest $request)
    {
        $data = $request->validated();
        // Obtener el último orden del trámite
        $ultimoOrden = Derivacion::where('tramite_id', $data['tramite_id'])->max('orden') ?? 0;

        // Asignar el nuevo orden
        $data['orden'] = $ultimoOrden + 1;

        $derivacion = Derivacion::create($data);

        return response()->json([
            'message' => 'Derivación registrada exitosamente',
            'data' => $derivacion
        ], 201);
    }

    public function show(Derivacion $derivacion)
    {
        return response()->json(
            $derivacion->load(['tramite', 'usuarioOrigen', 'usuarioDestino'])
        );
    }

    public function update(DerivacionRequest $request, Derivacion $derivacion)
    {
        $derivacion->update($request->validated());

        return response()->json([
            'message' => 'Derivación actualizada correctamente',
            'data' => $derivacion
        ]);
    }

    public function destroy(Derivacion $derivacion)
    {
        $derivacion->delete();

        return response()->json([
            'message' => 'Derivación eliminada correctamente'
        ]);
    }
}
