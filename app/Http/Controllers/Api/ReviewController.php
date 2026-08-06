<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\PointOfInterest;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::latest()->get();
        return response()->json($reviews, 200);
    }

    public function store(Request $request)
    {
        try {
            $poiId = $request->point_of_interest_id ?? $request->poi_id;

            if (!$poiId || !PointOfInterest::where('id', $poiId)->exists()) {
                $poi = PointOfInterest::first();
                if (!$poi) {
                    $poi = PointOfInterest::create([
                        'name' => 'Atractivo General Puno',
                        'description' => 'Punto base de prueba',
                        'latitude' => -15.8407,
                        'longitude' => -70.0281,
                        'status' => 'aprobado'
                    ]);
                }
                $poiId = $poi->id;
            }

            // Captura la foto enviada desde Flutter (base64 o URL)
            $image = $request->image ?? $request->photo ?? $request->photo_base64;

            $review = Review::create([
                'point_of_interest_id' => $poiId,
                'user_name' => $request->user_name ?? $request->userName ?? 'Turista GeoTrek',
                'rating' => $request->rating ?? 5,
                'comment' => $request->comment ?? 'Excelente lugar',
                'image' => $image, // <-- GUARDA LA FOTO EN LA BD
                'status' => 'Aprobado',
            ]);

            return response()->json([
                'message' => 'Reseña guardada con éxito',
                'data' => $review
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $review = Review::find($id);
        if ($review) {
            $review->delete();
        }
        return response()->json(['message' => 'Reseña eliminada'], 200);
    }
}