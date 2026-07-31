<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; // <-- ESTA LÍNEA ES ESENCIAL
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    // Listar todas las rutas con sus puntos de interés
    public function index()
    {
        $routes = Route::with('pointsOfInterest')->where('is_active', true)->get();
        return response()->json($routes, 200);
    }

    // Crear una nueva ruta (para el Admin Web)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'difficulty' => 'in:Easy,Medium,Hard',
            'distance_km' => 'required|numeric',
            'estimated_duration_min' => 'required|integer',
            'location_name' => 'nullable|string',
            'image_url' => 'nullable|string',
        ]);

        $route = Route::create($validated);
        return response()->json($route, 201);
    }

    // Ver detalle de una ruta específica
    public function show($id)
    {
        $route = Route::with('pointsOfInterest')->findOrFail($id);
        return response()->json($route, 200);
    }

    // Actualizar ruta
    public function update(Request $request, $id)
    {
        $route = Route::findOrFail($id);
        $route->update($request->all());
        return response()->json($route, 200);
    }

    // Eliminar ruta
    public function destroy($id)
    {
        $route = Route::findOrFail($id);
        $route->delete();
        return response()->json(['message' => 'Ruta eliminada correctamente'], 200);
    }
}