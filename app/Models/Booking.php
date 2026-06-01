<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hotel_id',
        'booking_code',
        'check_in',
        'check_out',
        'guests',
        'nights',
        'room_type',
        'guest_name',
        'guest_bio',
        'special_requests',
        'base_price',
        'discount',
        'discount_amount',
        'tax',
        'service_fee',
        'total_price',
        'payment_method',
        'payment_status',
        'booking_status',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'guests' => 'integer',
        'nights' => 'integer',
        'base_price' => 'decimal:2',
        'discount' => 'integer',
        'discount_amount' => 'decimal:2',
        'tax' => 'decimal:2',
        'service_fee' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->booking_status) {
            'confirmed' => 'success',
            'pending' => 'warning',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }
}
