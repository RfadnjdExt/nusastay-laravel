<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredHotels = Hotel::where('featured', true)
            ->orderBy('rating', 'desc')
            ->take(6)
            ->get();

        $popularDestinations = [
            ['name' => 'Bandung', 'image' => 'bandung.webp', 'hotels_count' => 12],
            ['name' => 'Jakarta', 'image' => 'jakarta.webp', 'hotels_count' => 24],
            ['name' => 'Surabaya', 'image' => 'surabaya.webp', 'hotels_count' => 18],
        ];

        return view('home', compact('featuredHotels', 'popularDestinations'));
    }
}
