@extends('layouts.app')

@section('title', $hotel->name . ' | Nusa Stay')

@push('styles')
<style>
#map { height: 400px; width: 100%; border-radius: var(--radius-md); }
</style>
@endpush

@section('content')
<section style="padding: 64px 0;">
    <div class="container">
        <div style="margin-bottom: 32px;">
            <a href="{{ route('hotels.search') }}" style="color: var(--color-primary); font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                ← Back to Search
            </a>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 400px; gap: 32px;">
            <div>
                <div style="position: relative; height: 500px; border-radius: var(--radius-lg); overflow: hidden; margin-bottom: 32px;">
                    <img src="{{ asset('images/' . $hotel->image) }}" alt="{{ $hotel->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @if($hotel->discount > 0)
                        <div class="badge" style="position: absolute; top: 24px; right: 24px; font-size: 1rem; padding: 8px 16px;">
                            -{{ $hotel->discount }}% OFF
                        </div>
                    @endif
                </div>

                <h1 style="font-size: 2.5rem; margin-bottom: 16px;">{{ $hotel->name }}</h1>
                <p style="color: var(--color-gray); font-size: 1.125rem; margin-bottom: 16px;">📍 {{ $hotel->location }}</p>

                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 32px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="color: var(--color-gold); font-weight: 700; font-size: 1.25rem;">⭐ {{ $hotel->rating }}</span>
                        <span style="color: var(--color-gray);">({{ $hotel->reviews_count }} reviews)</span>
                    </div>
                </div>

                <div style="background: var(--color-card-bg); padding: 32px; border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); margin-bottom: 32px;">
                    <h2 style="font-size: 1.75rem; margin-bottom: 16px;">About This Property</h2>
                    <p style="color: var(--color-gray); line-height: 1.8; font-size: 1rem;">{{ $hotel->description }}</p>
                </div>

                <div style="background: var(--color-card-bg); padding: 32px; border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); margin-bottom: 32px;">
                    <h2 style="font-size: 1.75rem; margin-bottom: 20px;">Amenities</h2>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px;">
                        @foreach($hotel->amenities ?? [] as $amenity)
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <span style="color: var(--color-primary); font-size: 1.25rem;">✓</span>
                                <span style="font-weight: 500;">{{ $amenity }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div style="background: var(--color-card-bg); padding: 32px; border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); margin-bottom: 32px;">
                    <h2 style="font-size: 1.75rem; margin-bottom: 20px;">Location</h2>
                    <div id="map"></div>
                </div>

                @if($similarHotels->count() > 0)
                    <div style="margin-top: 64px;">
                        <h2 style="font-size: 1.75rem; margin-bottom: 24px;">Similar Properties</h2>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                            @foreach($similarHotels as $similar)
                                <a href="{{ route('hotels.show', $similar->id) }}" style="background: var(--color-card-bg); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-soft); transition: var(--transition); display: block;"
                                    onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='var(--shadow-hover)'"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-soft)'">
                                    <div style="height: 180px; overflow: hidden;">
                                        <img src="{{ asset('images/' . $similar->image) }}" alt="{{ $similar->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div style="padding: 20px;">
                                        <h3 style="font-size: 1.125rem; margin-bottom: 8px; color: var(--color-dark);">{{ $similar->name }}</h3>
                                        <p style="color: var(--color-gray); font-size: 0.875rem; margin-bottom: 12px;">{{ $similar->city }}</p>
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <span style="color: var(--color-gold); font-weight: 700;">⭐ {{ $similar->rating }}</span>
                                            <span style="font-weight: 700; color: var(--color-primary);">Rp {{ number_format($similar->price, 0, ',', '.') }} / night</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div>
                <div style="background: var(--color-card-bg); padding: 32px; border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); position: sticky; top: 100px;">
                    <div style="margin-bottom: 24px;">
                        @if($hotel->discount > 0)
                            <div style="text-decoration: line-through; color: var(--color-gray); font-size: 1.125rem;">
                                Rp {{ number_format($hotel->price, 0, ',', '.') }}
                            </div>
                            <div style="font-size: 2.5rem; font-weight: 700; color: var(--color-primary); margin-bottom: 4px;">
                                Rp {{ number_format($hotel->discounted_price, 0, ',', '.') }}
                            </div>
                        @else
                            <div style="font-size: 2.5rem; font-weight: 700; color: var(--color-primary); margin-bottom: 4px;">
                                Rp {{ number_format($hotel->price, 0, ',', '.') }}
                            </div>
                        @endif
                        <div style="color: var(--color-gray);">/ night</div>
                    </div>

                    <div style="padding: 20px; background: var(--color-bg); border-radius: var(--radius-md); margin-bottom: 24px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                            <span style="color: var(--color-gray);">Max Guests:</span>
                            <span style="font-weight: 600;">{{ $hotel->max_guests }} guests</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--color-gray);">Location:</span>
                            <span style="font-weight: 600;">{{ $hotel->city }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index', $hotel->id) }}" class="btn btn-primary" style="width: 100%; padding: 16px; font-size: 1.125rem; text-align: center; display: block;">
                        Book Now
                    </a>

                    <p style="text-align: center; color: var(--color-gray); font-size: 0.875rem; margin-top: 16px;">
                        Free cancellation • Instant confirmation
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
const map = L.map('map').setView([{{ $hotel->lat }}, {{ $hotel->lng }}], 15);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);
L.marker([{{ $hotel->lat }}, {{ $hotel->lng }}]).addTo(map)
    .bindPopup('<b>{{ $hotel->name }}</b><br>{{ $hotel->location }}').openPopup();
</script>
@endpush
@endsection
