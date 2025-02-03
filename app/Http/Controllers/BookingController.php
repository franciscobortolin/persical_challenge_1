<?php

namespace App\Http\Controllers;

use App\Enums\BookingStatus;
use App\Exports\BookingsExport;
use App\Http\Resources\BookingResource;
use App\Jobs\ExportBookingsJob;
use App\Models\Booking;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Response;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::query()->with(['tour', 'hotel']);

        if ($request->has('start_date')) {
            $query->byStartDate($request->start_date);
        }

        if ($request->has('end_date')) {
            $query->byEndDate($request->end_date);
        }

        if ($request->has('tour_name')) {
            $query->byTourName($request->tour_name);
        }
    
        if ($request->has('hotel_name')) {
            $query->byHotelName($request->hotel_name);
        }
    
        if ($request->has('customer_name')) {
            $query->byCustomerName($request->customer_name);
        }

        if ($request->has('sort_by') && $request->has('direction')) {
            $query->sortBy($request->sort_by, $request->direction);
        }
        
        $bookings = $query->get();

        $perPage = $request->input('per_page', 10);
        $bookings = $query->paginate($perPage);
    
        return BookingResource::collection($bookings);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'hotel_id' => 'required|exists:hotels,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'number_of_people' => 'required|integer|min:1',
            'booking_date' => 'required|date',
        ]);

        $booking = Booking::create($validatedData);
        return response()->json($booking, 201);
    }

    public function show(Booking $booking)
    {
        return response()->json($booking, 200);
    }

    public function update(Request $request, Booking $booking)
    {
        $validatedData = $request->validate([
            'tour_id' => 'sometimes|exists:tours,id',
            'hotel_id' => 'sometimes|exists:hotels,id',
            'customer_name' => 'sometimes|string|max:255',
            'customer_email' => 'sometimes|email|max:255',
            'number_of_people' => 'sometimes|integer|min:1',
            'booking_date' => 'sometimes|date',
        ]);

        $booking->update($validatedData);
        return response()->json($booking, 200);
    }

    public function export()
    {
        $filename = 'bookings_' . now()->format('d_m_Y_H_i_s') . '.csv';
        ExportBookingsJob::dispatch($filename);

        return response()->json(['message' => 'Export job queued.'], 202);
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status === BookingStatus::CANCELED) {
            return response()->json(['message' => 'Booking is already canceled.'], Response::HTTP_BAD_REQUEST);
        }

        $booking->status = BookingStatus::CANCELED;
        $booking->save();

        return response()->json([
            'message' => 'Booking canceled successfully.',
            'data' => new BookingResource($booking),
        ], Response::HTTP_OK);
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return response()->json(null, 204);
    }
}
