@extends('layouts.app')

@section('title', 'My Bookings | Nusa Stay')

@section('content')
<section style="padding: 48px 0; background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%); color: var(--color-light);">
    <div class="container">
        <h1 style="font-size: 2.5rem; margin-bottom: 16px;">My Bookings</h1>
        <p style="font-size: 1.125rem; opacity: 0.9;">Manage your reservations and travel plans</p>
    </div>
</section>

<section style="padding: 64px 0;">
    <div class="container">
        <div style="display: flex; gap: 32px;">
            <div style="flex: 0 0 280px;">
                <div style="background: var(--color-card-bg); padding: 24px; border-radius: var(--radius-lg); box-shadow: var(--shadow-soft);">
                    <h3 style="font-size: 1.25rem; margin-bottom: 20px;">Account</h3>
                    <nav style="display: flex; flex-direction: column; gap: 8px;">
                        <a href="{{ route('profile.index') }}" style="padding: 12px 16px; border-radius: var(--radius-sm); background: var(--color-primary); color: var(--color-light); font-weight: 600;">
                            My Bookings
                        </a>
                        <a href="{{ route('profile.settings') }}" style="padding: 12px 16px; border-radius: var(--radius-sm); color: var(--color-gray); transition: var(--transition);"
                            onmouseover="this.style.background='var(--color-bg)'" onmouseout="this.style.background='transparent'">
                            Settings
                        </a>
                    </nav>
                </div>
            </div>

            <div style="flex: 1;">
                <div style="background: var(--color-card-bg); padding: 32px; border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); margin-bottom: 32px;">
                    <h2 style="font-size: 1.5rem; margin-bottom: 8px;">Welcome, {{ $user->name }}!</h2>
                    <p style="color: var(--color-gray);">{{ $user->email }}</p>
                </div>

                <h2 style="font-size: 1.75rem; margin-bottom: 24px;">Your Bookings</h2>

                @forelse($bookings as $booking)
                    <div style="background: var(--color-card-bg); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-soft); margin-bottom: 24px;">
                        <div style="display: flex; gap: 24px;">
                            <div style="flex: 0 0 240px;">
                                <img src="{{ asset('images/' . $booking->hotel->image) }}" alt="{{ $booking->hotel->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div style="flex: 1; padding: 24px; display: flex; flex-direction: column; justify-content: space-between;">
                                <div>
                                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                                        <div>
                                            <h3 style="font-size: 1.5rem; margin-bottom: 8px; color: var(--color-dark);">{{ $booking->hotel->name }}</h3>
                                            <p style="color: var(--color-gray); font-size: 0.875rem;">📍 {{ $booking->hotel->location }}</p>
                                        </div>
                                        <span class="badge" style="background:
                                            @if($booking->booking_status == 'confirmed') var(--color-success)
                                            @elseif($booking->booking_status == 'pending') var(--color-gold)
                                            @else var(--color-gray)
                                            @endif; color: white;">
                                            {{ ucfirst($booking->booking_status) }}
                                        </span>
                                    </div>

                                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-top: 20px; padding: 16px; background: var(--color-bg); border-radius: var(--radius-sm);">
                                        <div>
                                            <p style="color: var(--color-gray); font-size: 0.875rem; margin-bottom: 4px;">Booking Code</p>
                                            <p style="font-weight: 700; color: var(--color-primary);">{{ $booking->booking_code }}</p>
                                        </div>
                                        <div>
                                            <p style="color: var(--color-gray); font-size: 0.875rem; margin-bottom: 4px;">Check-in</p>
                                            <p style="font-weight: 600;">{{ $booking->check_in->format('M d, Y') }}</p>
                                        </div>
                                        <div>
                                            <p style="color: var(--color-gray); font-size: 0.875rem; margin-bottom: 4px;">Check-out</p>
                                            <p style="font-weight: 600;">{{ $booking->check_out->format('M d, Y') }}</p>
                                        </div>
                                        <div>
                                            <p style="color: var(--color-gray); font-size: 0.875rem; margin-bottom: 4px;">Guests</p>
                                            <p style="font-weight: 600;">{{ $booking->guests }} {{ Str::plural('guest', $booking->guests) }}</p>
                                        </div>
                                        <div>
                                            <p style="color: var(--color-gray); font-size: 0.875rem; margin-bottom: 4px;">Nights</p>
                                            <p style="font-weight: 600;">{{ $booking->nights }} {{ Str::plural('night', $booking->nights) }}</p>
                                        </div>
                                        <div>
                                            <p style="color: var(--color-gray); font-size: 0.875rem; margin-bottom: 4px;">Room Type</p>
                                            <p style="font-weight: 600;">{{ $booking->room_type }}</p>
                                        </div>
                                    </div>

                                    @if($booking->special_requests)
                                        <div style="margin-top: 16px; padding: 12px; background: var(--color-bg); border-radius: var(--radius-sm);">
                                            <p style="color: var(--color-gray); font-size: 0.875rem; margin-bottom: 4px;">Special Requests</p>
                                            <p style="font-size: 0.875rem;">{{ $booking->special_requests }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--color-gray-light);">
                                    <div>
                                        <p style="color: var(--color-gray); font-size: 0.875rem;">Total Amount</p>
                                        <p style="font-size: 1.75rem; font-weight: 700; color: var(--color-primary);">
                                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div style="display: flex; gap: 12px;">
                                        <a href="{{ route('hotels.show', $booking->hotel_id) }}" class="btn btn-outline" style="padding: 10px 20px; font-size: 0.875rem;">
                                            View Hotel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 64px 0;">
                        <div style="font-size: 4rem; margin-bottom: 16px;">🏨</div>
                        <h3 style="font-size: 1.5rem; margin-bottom: 12px;">No bookings yet</h3>
                        <p style="color: var(--color-gray); margin-bottom: 24px;">Start planning your next urban escape!</p>
                        <a href="{{ route('hotels.search') }}" class="btn btn-primary">
                            Browse Hotels
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
