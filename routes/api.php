<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\ProveedorController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\AlmacenController;
use App\Http\Controllers\Api\DerivacionController;
use App\Http\Controllers\Api\MovimientoController;
use App\Http\Controllers\Api\DetalleMovimientoController;
use App\Http\Controllers\Api\VentaController;
use App\Http\Controllers\Api\DetalleVentaController;
use App\Http\Controllers\Api\TramiteController;
use App\Http\Controllers\AuthController;

// RUTAS PÚBLICAS
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

// RUTAS PROTEGIDAS POR SANCTUM
// Route::middleware('auth:sanctum')->group(function () {

    // AUTH
    Route::get('user', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);

    // CLIENTES
    Route::apiResource('clientes', ClienteController::class);

    // PROVEEDORES
    Route::apiResource('proveedores', ProveedorController::class);

    // PRODUCTOS
    Route::apiResource('productos', ProductoController::class);

    // ALMACENES
    Route::apiResource('almacenes', AlmacenController::class);

    // MOVIMIENTOS
    Route::apiResource('movimientos', MovimientoController::class);
    Route::apiResource('detalles-movimiento', DetalleMovimientoController::class);

    // VENTAS
    Route::get('ventas/reporte-detalle', [VentaController::class, 'reporteDetalle']);
    Route::get('ventas/reporte-detalle-por-usuario', [VentaController::class, 'reporteDetallePorUsuario']);
    // REPORTES
    Route::apiResource('ventas', VentaController::class);
    Route::apiResource('detalles-venta', DetalleVentaController::class);

    // Rutas para Tramite (CRUD completo)
    Route::apiResource('tramites', TramiteController::class);

    // Rutas para Derivacion (CRUD completo)
    Route::apiResource('derivaciones', DerivacionController::class);

    // Rutas para obtener derivaciones de un trámite específico (relación)
    Route::get('tramites/{tramite}/derivaciones', [DerivacionController::class, 'indexPorTramite']);

    // Ruta para crear una derivación ligada a un trámite específico
    Route::post('tramites/{tramite}/derivaciones', [DerivacionController::class, 'storePorTramite']);

// });

// Ruta base de prueba
Route::get('/', fn () => response()->json(['api' => 'backend-ventas-pro', 'version' => '1.0.0']));
