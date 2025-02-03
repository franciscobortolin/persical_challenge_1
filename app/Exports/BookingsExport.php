<?php
namespace App\Exports;

use App\Models\Booking;
use App\Http\Resources\BookingResource;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Booking::with('tour', 'hotel')
            ->select('id', 'tour_id', 'hotel_id', 'customer_name', 'customer_email', 'number_of_people', 'booking_date', 'status')
            ->get()
            ->map(function ($booking) {
                return new BookingResource($booking);
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tour Name',
            'Hotel Name',
            'Customer Name',
            'Customer Email',
            'Booking Date',
            'Number of People',
            'Status'
        ];
    }
}
