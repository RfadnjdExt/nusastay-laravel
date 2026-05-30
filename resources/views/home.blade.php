@extends('layouts.app')

@section('title', 'Home | Nusa Stay')

@section('content')
<section style="padding: 48px 0; background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%); color: var(--color-light);">
    <div class="container">
        <h1 style="font-size: 2.5rem; margin-bottom: 16px;">Welcome back, {{ auth()->user()->name }}!</h1>
        <p style="font-size: 1.125rem; opacity: 0.9;">Ready to plan your next urban escape?</p>
    </div>
</section>

<section style="padding: 64px 0;">
    <div class="container">
        <div style="background: var(--color-card-bg); padding: 32px; border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); margin-bottom: 64px;">
            <h2 style="font-size: 1.5rem; margin-bottom: 24px;">Find Your Perfect Stay</h2>
            <form action="{{ route('hotels.search') }}" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                <div>
                    <label for="location" style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem;">Location</label>
                    <input type="text" id="location" name="location" placeholder="e.g., Bandung, Jakarta"
                        style="width: 100%; padding: 12px 16px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 1rem;">
                </div>
                <div>
                    <label for="check_in" style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem;">Check-in</label>
                    <input type="date" id="check_in" name="check_in"
                        style="width: 100%; padding: 12px 16px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 1rem;">
                </div>
                <div>
                    <label for="check_out" style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem;">Check-out</label>
                    <input type="date" id="check_out" name="check_out"
                        style="width: 100%; padding: 12px 16px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 1rem;">
                </div>
                <div>
                    <label for="guests" style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem;">Guests</label>
                    <input type="number" id="guests" name="guests" min="1" value="2"
                        style="width: 100%; padding: 12px 16px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 1rem;">
                </div>
                <div style="display: flex; align-items: flex-end;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px;">
                        Search Hotels
                    </button>
                </div>
            </form>
        </div>

        <h2 style="font-size: 2rem; margin-bottom: 32px;">Featured Hotels</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 32px;">
            @forelse($featuredHotels as $hotel)
                <a href="{{ route('hotels.show', $hotel->id) }}" style="background: var(--color-card-bg); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-soft); transition: var(--transition); display: block;"
                    onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='var(--shadow-hover)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-soft)'">
                    <div style="position: relative; height: 240px; overflow: hidden;">
                        <img src="{{ asset('images/' . $hotel->image) }}" alt="{{ $hotel->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @if($hotel->discount > 0)
                            <div class="badge" style="position: absolute; top: 16px; right: 16px;">-{{ $hotel->discount }}%</div>
                        @endif
                    </div>
                    <div style="padding: 24px;">
                        <h3 style="font-size: 1.25rem; margin-bottom: 8px; color: var(--color-dark);">{{ $hotel->name }}</h3>
                        <p style="color: var(--color-gray); font-size: 0.875rem; margin-bottom: 12px;">📍 {{ $hotel->city }}</p>
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                            <span style="color: var(--color-gold); font-weight: 700;">⭐ {{ $hotel->rating }}</span>
                            <span style="color: var(--color-gray); font-size: 0.875rem;">({{ $hotel->reviews_count }} reviews)</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                @if($hotel->discount > 0)
                                    <div style="text-decoration: line-through; color: var(--color-gray); font-size: 0.875rem;">
                                        Rp {{ number_format($hotel->price, 0, ',', '.') }}
                                    </div>
                                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--color-primary);">
                                        Rp {{ number_format($hotel->discounted_price, 0, ',', '.') }}
                                    </div>
                                @else
                                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--color-primary);">
                                        Rp {{ number_format($hotel->price, 0, ',', '.') }}
                                    </div>
                                @endif
                                <div style="color: var(--color-gray); font-size: 0.875rem;">per night</div>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <p style="color: var(--color-gray); text-align: center; grid-column: 1 / -1;">No featured hotels available.</p>
            @endforelse
        </div>
    </div>
</section>

<section style="padding: 64px 0; background: var(--color-bg);">
    <div class="container">
        <h2 style="font-size: 2rem; margin-bottom: 32px;">Popular Destinations</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 32px;">
            @foreach($popularDestinations as $destination)
                <a href="{{ route('hotels.search', ['location' => $destination['name']]) }}"
                    style="position: relative; border-radius: var(--radius-lg); overflow: hidden; height: 300px; display: block; transition: var(--transition);"
                    onmouseover="this.style.transform='scale(1.02)'"
                    onmouseout="this.style.transform='scale(1)'">
                    <img src="{{ asset('images/' . $destination['image']) }}" alt="{{ $destination['name'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); display: flex; flex-direction: column; justify-content: flex-end; padding: 32px; color: white;">
                        <h3 style="font-size: 2rem; margin-bottom: 8px;">{{ $destination['name'] }}</h3>
                        <p style="opacity: 0.9;">{{ $destination['hotels_count'] }}+ Properties</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
