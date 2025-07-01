<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    // Listar todos los productos
    public function index()
    {
        return Producto::with(['categoria', 'imagenPredeterminada', 'precioActual'])->get();
    }

    // Crear un nuevo producto
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'categoria_producto_id' => 'required|exists:categoria_productos,id',
            'codigo_barras' => 'required|string|max:64|unique:productos,codigo_barras',
            'estado' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errores' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $data['creado_por'] = Auth::id() ?? 1; // Asigna ID del usuario autenticado o por defecto 1

        $producto = Producto::create($data);

        return response()->json($producto, 201);
    }

    // Mostrar un producto
    public function show($id)
    {
        $producto = Producto::with(['categoria', 'imagenes', 'precioActual', 'movimientosStock'])->find($id);

        if (!$producto) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto);
    }

    // Actualizar producto
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|string|max:100',
            'descripcion' => 'nullable|string',
            'categoria_producto_id' => 'sometimes|exists:categoria_productos,id',
            'codigo_barras' => "sometimes|string|max:64|unique:productos,codigo_barras,{$id}",
            'estado' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errores' => $validator->errors()
            ], 422);
        }

        $producto->update($validator->validated());

        return response()->json($producto);
    }

    // Eliminar producto
    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }

        $producto->delete();

        return response()->json(['mensaje' => 'Producto eliminado correctamente']);
    }
}

