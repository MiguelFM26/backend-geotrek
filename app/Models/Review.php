<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'point_of_interest_id',
        'user_name',
        'rating',
        'comment',
        'status'
    ];

    public function pointOfInterest()
    {
        return $this->belongsTo(PointOfInterest::class, 'point_of_interest_id');
    }
}