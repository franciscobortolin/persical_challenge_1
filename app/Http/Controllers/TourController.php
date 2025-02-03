<?php

namespace App\Http\Controllers;

use App\Http\Resources\TourResource;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $tours = Tour::query()
        ->priceBetween($request->min_price, $request->max_price)
        ->startDateAfter($request->start_date)
        ->endDateBefore($request->end_date)
        ->paginate($perPage);

        return TourResource::collection($tours);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $tour = Tour::create($validatedData);
        return response()->json(new TourResource($tour), 201);
    }

    public function show(Tour $tour)
    {
        return new TourResource($tour);
    }

    public function update(Request $request, Tour $tour)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
        ]);

        $tour->update($validatedData);
        return response()->json(new TourResource($tour), 200);
    }

    public function destroy(Tour $tour)
    {
        $tour->delete();
        return response()->json(null, 204);
    }
}
