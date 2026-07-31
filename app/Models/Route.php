<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'difficulty',
        'distance_km',
        'estimated_duration_min',
        'location_name',
        'image_url',
        'is_active',
    ];

    // Una ruta tiene muchos puntos de interés
    public function pointsOfInterest()
    {
        return $table = $this->hasMany(PointOfInterest::class);
    }
}