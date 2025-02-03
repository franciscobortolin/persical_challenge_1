<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'hotel_id',
        'customer_name',
        'customer_email',
        'number_of_people',
        'booking_date',
        'status'
    ];

    protected $casts = [
        'status' => BookingStatus::class,
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function scopeByTourName(Builder $query, $tourName)
    {
        return $query->whereHas('tour', function ($q) use ($tourName) {
            $q->where('name', 'like', '%' . $tourName . '%');
        });
    }

    public function scopeByHotelName(Builder $query, $hotelName)
    {
        return $query->whereHas('hotel', function ($q) use ($hotelName) {
            $q->where('name', 'like', '%' . $hotelName . '%');
        });
    }

    public function scopeByCustomerName(Builder $query, $customerName)
    {
        return $query->where('customer_name', 'like', '%' . $customerName . '%');
    }

    public function scopeByStartDate(Builder $query, $startDate)
    {
        return $query->where('booking_date', '>=', $startDate);
    }

    public function scopeByEndDate(Builder $query, $endDate)
    {
        return $query->where('booking_date', '<=', $endDate);
    }

    public function scopeSortBy(Builder $query, $field, $direction = 'asc')
    {
        $validFields = ['id','booking_date', 'customer_name', 'tour_id', 'hotel_id'];
        if (in_array($field, $validFields) && in_array(strtolower($direction), ['asc', 'desc'])) {
            return $query->orderBy($field, $direction);
        }

        return $query;
    }
}
