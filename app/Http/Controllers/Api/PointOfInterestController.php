<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PointOfInterest;
use Illuminate\Http\Request;

class PointOfInterestController extends Controller
{
    public function index(Request $request)
    {
        // Carga los POIs junto con sus relaciones y calcula el promedio de calificación
        $pois = PointOfInterest::with(['reviews', 'category', 'route'])->get()->map(function ($poi) {
            $totalReviews = $poi->reviews ? $poi->reviews->count() : 0;
            $avgRating = $totalReviews > 0 ? $poi->reviews->avg('rating') : 0;

            return [
                'id' => $poi->id,
                'name' => $poi->name,
                'description' => $poi->description ?? '',
                'latitude' => (float) $poi->latitude,
                'longitude' => (float) $poi->longitude,
                'route_id' => $poi->route_id,
                'category_id' => $poi->category_id,
                'radius_meters' => $poi->radius_meters ?? 20,
                'status' => $poi->status ?? 'pendiente',
                'rating' => round($avgRating, 1), // Promedio ej: 4.5
                'reviews_count' => $totalReviews,  // Cantidad total de reseñas
                'category' => $poi->category,
                'route' => $poi->route,
                'reviews' => $poi->reviews,
            ];
        });

        return response()->json($pois, 200);
    }

    public function show($id)
    {
        $poi = PointOfInterest::with(['reviews', 'category', 'route'])->find($id);

        if (!$poi) {
            return response()->json(['message' => 'Punto de interés no encontrado'], 404);
        }

        $totalReviews = $poi->reviews ? $poi->reviews->count() : 0;
        $avgRating = $totalReviews > 0 ? $poi->reviews->avg('rating') : 0;

        $data = $poi->toArray();
        $data['rating'] = round($avgRating, 1);
        $data['reviews_count'] = $totalReviews;

        return response()->json($data, 200);
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