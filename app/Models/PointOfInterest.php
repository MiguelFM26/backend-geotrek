<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointOfInterest extends Model
{
    use HasFactory;

    protected $table = 'points_of_interest';

    protected $fillable = [
        'route_id',
        'category_id',
        'name',
        'description',
        'latitude',
        'longitude',
        'radius_meters',
        'audio_url',
        'image_url',
        'status',
        'user_id'
    ];

    /**
     * Conversión automática de tipos para JSON/API.
     */
    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
        'radius_meters' => 'integer',
        'route_id' => 'integer',
        'category_id' => 'integer',
        'user_id' => 'integer',
    ];

    // Relación con Ruta
    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    // Relación con Categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación con Reseñas
    public function reviews()
    {
        return $this->hasMany(Review::class, 'point_of_interest_id');
    }

    // Relación con el Usuario creador
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}