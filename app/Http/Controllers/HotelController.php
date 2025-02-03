<?php

namespace App\Http\Controllers;

use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $hotels = Hotel::query()
        ->ratingBetween($request->min_rating, $request->max_rating)
        ->priceBetween($request->min_price, $request->max_price)
        ->paginate($perPage);

        return HotelResource::collection($hotels);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'rating' => 'required|integer',
            'price_per_night' => 'required|numeric',
        ]);

        $hotel = Hotel::create($validatedData);
        return response()->json(new HotelResource($hotel), 201);
    }

    public function show(Hotel $hotel)
    {
        return new HotelResource($hotel);
    }

    public function update(Request $request, Hotel $hotel)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'address' => 'sometimes|string',
            'rating' => 'sometimes|integer',
            'price_per_night' => 'sometimes|numeric',
        ]);

        $hotel->update($validatedData);
        return response()->json(new HotelResource($hotel), 200);
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return response()->json(null, 204);
    }
}
