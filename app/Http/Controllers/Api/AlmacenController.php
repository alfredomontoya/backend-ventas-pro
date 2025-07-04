<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Almacen;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    public function index()
    {
        return Almacen::with('usuario')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'ubicacion' => 'nullable|string',
            'descripcion' => 'nullable|string',
            'usuario_id' => 'required|exists:users,id',
        ]);

        $almacen = Almacen::create($data);
        return response()->json($almacen, 201);
    }

    public function show(Almacen $almacen)
    {
        return $almacen->load('usuario');
    }

    public function update(Request $request, Almacen $almacen)
    {
        $data = $request->validate([
            'nombre' => 'sometimes|string|max:100',
            'ubicacion' => 'nullable|string',
            'descripcion' => 'nullable|string',
        ]);

        $almacen->update($data);
        return response()->json($almacen);
    }

    public function destroy(Almacen $almacen)
    {
        $almacen->delete();
        return response()->json(['message' => 'Almacén eliminado.']);
    }
}
