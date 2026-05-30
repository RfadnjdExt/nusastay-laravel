<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'city',
        'description',
        'price',
        'discount',
        'rating',
        'reviews_count',
        'image',
        'lat',
        'lng',
        'amenities',
        'max_guests',
        'featured',
    ];

    protected $casts = [
        'amenities' => 'array',
        'price' => 'decimal:2',
        'discount' => 'integer',
        'rating' => 'decimal:1',
        'reviews_count' => 'integer',
        'lat' => 'float',
        'lng' => 'float',
        'max_guests' => 'integer',
        'featured' => 'boolean',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getDiscountedPriceAttribute()
    {
        if ($this->discount > 0) {
            return $this->price * (1 - $this->discount / 100);
        }
        return $this->price;
    }
}
