<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index($hotelId)
    {
        $hotel = Hotel::findOrFail($hotelId);
        return view('checkout.index', compact('hotel'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'hotel_id' => ['required', 'exists:hotels,id'],
            'check_in' => ['required', 'date', 'after:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => ['required', 'integer', 'min:1'],
            'room_type' => ['required', 'string'],
            'special_requests' => ['nullable', 'string', 'max:500'],
            'payment_method' => ['required', 'in:credit_card,debit_card,bank_transfer,e_wallet'],
            'cardholder_name' => ['required_if:payment_method,credit_card,debit_card', 'string', 'max:255'],
            'card_number' => ['required_if:payment_method,credit_card,debit_card', 'string', 'size:16'],
            'expiry_date' => ['required_if:payment_method,credit_card,debit_card', 'string'],
            'cvv' => ['required_if:payment_method,credit_card,debit_card', 'string', 'size:3'],
        ]);

        $hotel = Hotel::findOrFail($validated['hotel_id']);

        // Calculate nights and total price
        $checkIn = \Carbon\Carbon::parse($validated['check_in']);
        $checkOut = \Carbon\Carbon::parse($validated['check_out']);
        $nights = $checkIn->diffInDays($checkOut);

        $basePrice = $hotel->price * $nights;
        $discount = $hotel->discount ?? 0;
        $discountAmount = $basePrice * ($discount / 100);
        $subtotal = $basePrice - $discountAmount;
        $tax = $subtotal * 0.11; // 11% tax
        $serviceFee = 50000; // Fixed service fee
        $totalPrice = $subtotal + $tax + $serviceFee;

        // Generate unique booking code
        $bookingCode = 'NS-' . strtoupper(Str::random(8));

        // Create booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'hotel_id' => $validated['hotel_id'],
            'booking_code' => $bookingCode,
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'guests' => $validated['guests'],
            'nights' => $nights,
            'room_type' => $validated['room_type'],
            'special_requests' => $validated['special_requests'],
            'base_price' => $basePrice,
            'discount' => $discount,
            'discount_amount' => $discountAmount,
            'tax' => $tax,
            'service_fee' => $serviceFee,
            'total_price' => $totalPrice,
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'completed',
            'booking_status' => 'confirmed',
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Booking confirmed! Your booking code is: ' . $bookingCode);
    }
}
