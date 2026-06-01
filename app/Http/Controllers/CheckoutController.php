<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index($hotelId)
    {
        $hotel = Hotel::findOrFail($hotelId);
        $maxGuests = max(1, (int) $hotel->max_guests);

        // Load payment method logos from public/images/payments
        $paymentMethods = [];
        $displayMap = [
            'gopay' => 'GoPay', 'dana' => 'DANA', 'ovo' => 'OVO', 'shopeepay' => 'ShopeePay',
            'mandiri' => 'Mandiri', 'bca' => 'BCA', 'bri' => 'BRI', 'bsi' => 'BSI',
            'card' => 'Card', 'timezone-card' => 'Timezone Card', 'e-wallet' => 'E-Wallet'
        ];

        $path = public_path('images/payments');
        if (File::exists($path)) {
            foreach (File::files($path) as $f) {
                $ext = strtolower($f->getExtension());
                if (!in_array($ext, ['svg', 'png', 'jpg', 'jpeg'])) continue;
                $name = pathinfo($f->getFilename(), PATHINFO_FILENAME);
                $key = strtolower($name);
                $paymentMethods[$key] = [
                    'file' => 'images/payments/' . $f->getFilename(),
                    'label' => $displayMap[$key] ?? ucfirst($name),
                ];
            }
        }

        if (empty($paymentMethods)) {
            $paymentMethods = [
                'gopay' => ['file' => 'images/payments/gopay.png', 'label' => 'GoPay'],
                'dana' => ['file' => 'images/payments/dana.png', 'label' => 'DANA'],
            ];
        }

        $defaultPayment = array_key_first($paymentMethods);

        return view('checkout.index', compact('hotel', 'maxGuests', 'paymentMethods', 'defaultPayment'));
    }

    public function process(Request $request)
    {
        $hotel = Hotel::findOrFail($request->input('hotel_id'));
        $maxGuests = max(1, (int) $hotel->max_guests);

        // Build allowed payment keys from files available
        $paymentPath = public_path('images/payments');
        $allowed = [];
        if (File::exists($paymentPath)) {
            foreach (File::files($paymentPath) as $f) {
                $allowed[] = strtolower(pathinfo($f->getFilename(), PATHINFO_FILENAME));
            }
        }
        if (empty($allowed)) {
            $allowed = ['gopay', 'dana'];
        }

        $validated = $request->validate([
            'hotel_id' => ['required', 'exists:hotels,id'],
            'check_in' => ['required', 'date', 'after:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_bio' => ['required', 'string', 'max:1000'],
            'guests' => ['required', 'integer', 'min:1', 'max:' . $maxGuests],
            'room_type' => ['required', 'string'],
            'special_requests' => ['nullable', 'string', 'max:500'],
            'payment_method' => ['required', 'in:' . implode(',', $allowed)],
        ]);

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
            'guest_name' => $validated['guest_name'],
            'guest_bio' => $validated['guest_bio'],
            'special_requests' => $validated['special_requests'],
            'base_price' => $basePrice,
            'discount' => $discount,
            'discount_amount' => $discountAmount,
            'tax' => $tax,
            'service_fee' => $serviceFee,
            'total_price' => $totalPrice,
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'booking_status' => 'pending',
        ]);

        return redirect()->route('payment.show', $bookingCode)
            ->with('success', 'Booking created! Complete your payment using ' . strtoupper($validated['payment_method']) . '.');
    }
}
