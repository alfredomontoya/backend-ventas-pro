<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TramiteRequest;
use App\Models\Tramite;
use Illuminate\Http\Request;

class TramiteController extends Controller
{
    public function index()
    {
        $tramites = Tramite::with('user')->latest()->get();
        return response()->json($tramites);
    }

    public function store(TramiteRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = auth()->id(); // Asigna el usuario autenticado

            // Obtener el número de trámite según la gestión (año)
            $gestion = date('Y', strtotime($data['fecha']));
            $ultimoNro = Tramite::whereYear('fecha', $gestion)->max('nro') ?? 0;
            $data['nro'] = $ultimoNro + 1;

            $tramite = Tramite::create($data);

            return response()->json($tramite->load('user'), 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al registrar trámite', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Tramite $tramite)
    {
        return response()->json($tramite->load(['user', 'derivaciones']));
    }

    public function update(TramiteRequest $request, Tramite $tramite)
    {
        $tramite->update($request->validated());
        return response()->json($tramite->fresh()->load('user'));
    }

    public function destroy(Tramite $tramite)
    {
        $tramite->delete();
        return response()->json(['message' => 'Trámite eliminado']);
    }
}
