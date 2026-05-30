<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = [
            [
                'name' => 'Dago Heritage Hotel',
                'location' => 'Jl. Ir. H. Juanda No. 68, Dago, Bandung',
                'city' => 'Bandung',
                'description' => 'Experience colonial charm meets modern luxury in the heart of Bandung. Our heritage property offers stunning mountain views, elegant rooms, and world-class amenities.',
                'price' => 850000,
                'discount' => 15,
                'rating' => 4.8,
                'reviews_count' => 342,
                'image' => 'Dago_Heritage_1917.webp',
                'lat' => -6.8701,
                'lng' => 107.6127,
                'amenities' => ['WiFi', 'Pool', 'Spa', 'Restaurant', 'Gym', 'Parking'],
                'max_guests' => 4,
                'featured' => true,
            ],
            [
                'name' => 'SCBD Lux Apartment',
                'location' => 'Jl. Jend. Sudirman Kav. 52-53, SCBD, Jakarta',
                'city' => 'Jakarta',
                'description' => 'Ultra-modern serviced apartments in Jakarta\'s premium business district. Floor-to-ceiling windows, rooftop infinity pool, and direct access to shopping malls.',
                'price' => 1200000,
                'discount' => 20,
                'rating' => 4.9,
                'reviews_count' => 567,
                'image' => 'SCBD_Lux_Apartment.webp',
                'lat' => -6.2253,
                'lng' => 106.8060,
                'amenities' => ['WiFi', 'Pool', 'Gym', 'Parking', 'Kitchen', 'Workspace'],
                'max_guests' => 3,
                'featured' => true,
            ],
            [
                'name' => 'Tunjungan City Hotel',
                'location' => 'Jl. Basuki Rahmat No. 8-12, Tunjungan, Surabaya',
                'city' => 'Surabaya',
                'description' => 'Prime location in Surabaya\'s shopping and entertainment hub. Contemporary design, spacious rooms, and exceptional service for business and leisure travelers.',
                'price' => 750000,
                'discount' => 10,
                'rating' => 4.7,
                'reviews_count' => 289,
                'image' => 'Tunjungan_City_Hotel.webp',
                'lat' => -7.2628,
                'lng' => 112.7392,
                'amenities' => ['WiFi', 'Restaurant', 'Gym', 'Parking', 'Meeting Room'],
                'max_guests' => 2,
                'featured' => true,
            ],
        ];

        foreach ($hotels as $hotel) {
            Hotel::create($hotel);
        }
    }
}
