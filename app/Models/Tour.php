<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'start_date',
        'end_date',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }


    public function scopePriceBetween($query, $min = null, $max = null)
    {
        if (!is_null($min)) {
            $query->where('price', '>=', $min);
        }
        if (!is_null($max)) {
            $query->where('price', '<=', $max);
        }
        return $query;
    }

    public function scopeStartDateAfter($query, $date)
    {
        return $date ? $query->where('start_date', '>=', $date) : $query;
    }

    public function scopeEndDateBefore($query, $date)
    {
        return $date ? $query->where('end_date', '<=', $date) : $query;
    }
}
