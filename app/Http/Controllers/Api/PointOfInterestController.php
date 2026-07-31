<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PointOfInterest;
use Illuminate\Http\Request;

class PointOfInterestController extends Controller
{
    public function index(Request $request)
    {
        // Retorna todos los puntos existentes en tu base de datos
        $pois = PointOfInterest::all();
        return response()->json($pois, 200);
    }

    public function store(Request $request)
    {
        $lat = $request->latitude ?? $request->lat;
        $lng = $request->longitude ?? $request->lng;

        $poi = PointOfInterest::create([
            'name' => $request->name,
            'description' => $request->description ?? '',
            'latitude' => $lat,
            'longitude' => $lng,
            'route_id' => $request->route_id ?? null,
            'category_id' => $request->category_id ?? null,
            'radius_meters' => $request->radius_meters ?? 20,
            'status' => $request->status ?? 'pendiente',
            'user_id' => $request->user()->id ?? null,
        ]);

        return response()->json([
            'message' => 'Punto registrado con éxito.',
            'data' => $poi
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $poi = PointOfInterest::findOrFail($id);
        $poi->update($request->all());
        return response()->json($poi, 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $poi = PointOfInterest::findOrFail($id);
        $poi->status = $request->status ?? 'aprobado';
        $poi->save();

        return response()->json(['message' => 'Estado actualizado', 'data' => $poi], 200);
    }

    public function destroy($id)
    {
        $poi = PointOfInterest::findOrFail($id);
        $poi->delete();
        return response()->json(['message' => 'Punto eliminado'], 200);
    }
}