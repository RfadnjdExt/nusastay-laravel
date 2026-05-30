<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function search(Request $request)
    {
        $query = Hotel::query();

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Filter by check-in/check-out dates
        if ($request->filled('check_in') && $request->filled('check_out')) {
            // In a real app, you'd check availability against bookings
            // For now, we'll just pass these to the view
            $checkIn = $request->check_in;
            $checkOut = $request->check_out;
        }

        // Filter by guests
        if ($request->filled('guests')) {
            $query->where('max_guests', '>=', $request->guests);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by rating
        if ($request->filled('min_rating')) {
            $query->where('rating', '>=', $request->min_rating);
        }

        // Filter by amenities
        if ($request->filled('amenities')) {
            $amenities = $request->amenities;
            foreach ($amenities as $amenity) {
                $query->whereJsonContains('amenities', $amenity);
            }
        }

        // Sort
        $sortBy = $request->get('sort', 'rating');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $hotels = $query->paginate(12);

        return view('hotels.search', compact('hotels'));
    }

    public function show($id)
    {
        $hotel = Hotel::findOrFail($id);

        // Get similar hotels (same location, similar price range)
        $similarHotels = Hotel::where('id', '!=', $id)
            ->where('location', $hotel->location)
            ->whereBetween('price', [$hotel->price * 0.7, $hotel->price * 1.3])
            ->orderBy('rating', 'desc')
            ->take(3)
            ->get();

        return view('hotels.show', compact('hotel', 'similarHotels'));
    }
}
