<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $articles = [
            [
                'id' => 1,
                'title' => '10 Hidden Gems in Bandung',
                'excerpt' => 'Discover the best-kept secrets of Bandung...',
                'image' => 'bandung.webp',
                'date' => '2024-03-15',
                'author' => 'Travel Team',
            ],
            [
                'id' => 2,
                'title' => 'Jakarta Nightlife Guide',
                'excerpt' => 'Experience the vibrant nightlife of Jakarta...',
                'image' => 'jakarta.webp',
                'date' => '2024-03-10',
                'author' => 'Travel Team',
            ],
            [
                'id' => 3,
                'title' => 'Surabaya Food Tour',
                'excerpt' => 'Taste the authentic flavors of Surabaya...',
                'image' => 'surabaya.webp',
                'date' => '2024-03-05',
                'author' => 'Travel Team',
            ],
        ];

        return view('blog.index', compact('articles'));
    }
}
