<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'rating',
        'price_per_night',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeRatingBetween($query, $min = null, $max = null)
    {
        if (!is_null($min)) {
            $query->where('rating', '>=', $min);
        }
        if (!is_null($max)) {
            $query->where('rating', '<=', $max);
        }
        return $query;
    }

    public function scopePriceBetween($query, $min = null, $max = null)
    {
        if (!is_null($min)) {
            $query->where('price_per_night', '>=', $min);
        }
        if (!is_null($max)) {
            $query->where('price_per_night', '<=', $max);
        }
        return $query;
    }
}
