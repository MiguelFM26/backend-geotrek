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

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}