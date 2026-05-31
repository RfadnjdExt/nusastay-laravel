<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Booking::where('user_id', $user->id)
            ->with('hotel')
            ->orderBy('created_at', 'desc');

        // Filter by payment status
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        // Filter by payment method
        if ($request->filled('method')) {
            $query->where('payment_method', $request->method);
        }

        $bookings = $query->get();

        // Summary stats
        $totalSpent    = $bookings->where('payment_status', 'completed')->sum('total_price');
        $totalBookings = $bookings->count();
        $pending       = $bookings->where('payment_status', 'pending')->count();
        $completed     = $bookings->where('payment_status', 'completed')->count();

        return view('payment.index', compact(
            'bookings', 'totalSpent', 'totalBookings', 'pending', 'completed'
        ));
    }

    public function show($bookingCode)
    {
        $booking = Booking::where('booking_code', $bookingCode)
            ->where('user_id', auth()->id())
            ->with('hotel')
            ->firstOrFail();

        return view('payment.show', compact('booking'));
    }
}
