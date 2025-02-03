<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'tour_name' => $this->tour->name,
            'hotel_name' => $this->hotel->name,
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'booking_date' => $this->booking_date,
            'number_of_people' => $this->number_of_people,
            'status' => $this->status->value
        ];
    }
}
