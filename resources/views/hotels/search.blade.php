@extends('layouts.app')

@section('title', 'Search Hotels | Nusa Stay')

@section('content')
<section style="padding: 48px 0; background: var(--color-bg);">
    <div class="container">
        <h1 style="font-size: 2rem; margin-bottom: 32px;">Search Results</h1>

        <div style="background: var(--color-card-bg); padding: 24px; border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); margin-bottom: 32px;">
            <form action="{{ route('hotels.search') }}" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px;">
                <div>
                    <label for="location" style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem;">Location</label>
                    <input type="text" id="location" name="location" value="{{ request('location') }}" placeholder="City or area"
                        style="width: 100%; padding: 10px 14px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 0.875rem;">
                </div>
                <div>
                    <label for="check_in" style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem;">Check-in</label>
                    <input type="date" id="check_in" name="check_in" value="{{ request('check_in') }}"
                        style="width: 100%; padding: 10px 14px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 0.875rem;">
                </div>
                <div>
                    <label for="check_out" style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem;">Check-out</label>
                    <input type="date" id="check_out" name="check_out" value="{{ request('check_out') }}"
                        style="width: 100%; padding: 10px 14px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 0.875rem;">
                </div>
                <div>
                    <label for="guests" style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.875rem;">Guests</label>
                    <input type="number" id="guests" name="guests" min="1" value="{{ request('guests', 2) }}"
                        style="width: 100%; padding: 10px 14px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 0.875rem;">
                </div>
                <div style="display: flex; align-items: flex-end;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px; font-size: 0.875rem;">
                        Update Search
                    </button>
                </div>
            </form>
        </div>

        <div style="display: flex; gap: 32px;">
            <div style="flex: 0 0 280px;">
                <div style="background: var(--color-card-bg); padding: 24px; border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); position: sticky; top: 100px;">
                    <h3 style="font-size: 1.25rem; margin-bottom: 20px;">Filters</h3>

                    <form action="{{ route('hotels.search') }}" method="GET">
                        <input type="hidden" name="location" value="{{ request('location') }}">
                        <input type="hidden" name="check_in" value="{{ request('check_in') }}">
                        <input type="hidden" name="check_out" value="{{ request('check_out') }}">
                        <input type="hidden" name="guests" value="{{ request('guests') }}">

                        <div style="margin-bottom: 24px;">
                            <label style="display: block; margin-bottom: 12px; font-weight: 600; font-size: 0.875rem;">Price Range</label>
                            <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}"
                                style="width: 100%; padding: 8px 12px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 0.875rem; margin-bottom: 8px;">
                            <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}"
                                style="width: 100%; padding: 8px 12px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 0.875rem;">
                        </div>

                        <div style="margin-bottom: 24px;">
                            <label style="display: block; margin-bottom: 12px; font-weight: 600; font-size: 0.875rem;">Minimum Rating</label>
                            <select name="min_rating" style="width: 100%; padding: 8px 12px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 0.875rem;">
                                <option value="">Any</option>
                                <option value="4.5" {{ request('min_rating') == '4.5' ? 'selected' : '' }}>4.5+</option>
                                <option value="4.0" {{ request('min_rating') == '4.0' ? 'selected' : '' }}>4.0+</option>
                                <option value="3.5" {{ request('min_rating') == '3.5' ? 'selected' : '' }}>3.5+</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px; font-size: 0.875rem;">
                            Apply Filters
                        </button>
                    </form>
                </div>
            </div>

            <div style="flex: 1;">
                <div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
                    <p style="color: var(--color-gray);">{{ $hotels->total() }} properties found</p>
                    <form action="{{ route('hotels.search') }}" method="GET" style="display: flex; gap: 8px; align-items: center;">
                        <input type="hidden" name="location" value="{{ request('location') }}">
                        <label style="font-size: 0.875rem; color: var(--color-gray);">Sort by:</label>
                        <select name="sort" onchange="this.form.submit()" style="padding: 8px 12px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 0.875rem;">
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating</option>
                            <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price</option>
                        </select>
                    </form>
                </div>

                <div style="display: grid; gap: 24px;">
                    @forelse($hotels as $hotel)
                        <a href="{{ route('hotels.show', $hotel->id) }}" style="background: var(--color-card-bg); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-soft); display: flex; gap: 24px; transition: var(--transition);"
                            onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='var(--shadow-hover)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-soft)'">
                            <div style="flex: 0 0 280px; position: relative;">
                                <img src="{{ asset('images/' . $hotel->image) }}" alt="{{ $hotel->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @if($hotel->discount > 0)
                                    <div class="badge" style="position: absolute; top: 16px; right: 16px;">-{{ $hotel->discount }}%</div>
                                @endif
                            </div>
                            <div style="flex: 1; padding: 24px; display: flex; flex-direction: column; justify-content: space-between;">
                                <div>
                                    <h3 style="font-size: 1.5rem; margin-bottom: 8px; color: var(--color-dark);">{{ $hotel->name }}</h3>
                                    <p style="color: var(--color-gray); font-size: 0.875rem; margin-bottom: 12px;">📍 {{ $hotel->location }}</p>
                                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                                        <span style="color: var(--color-gold); font-weight: 700;">⭐ {{ $hotel->rating }}</span>
                                        <span style="color: var(--color-gray); font-size: 0.875rem;">({{ $hotel->reviews_count }} reviews)</span>
                                    </div>
                                    <p style="color: var(--color-gray); font-size: 0.875rem; line-height: 1.6;">{{ Str::limit($hotel->description, 120) }}</p>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 16px;">
                                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                        @foreach(array_slice($hotel->amenities ?? [], 0, 3) as $amenity)
                                            <span style="background: var(--color-bg); padding: 4px 12px; border-radius: var(--radius-pill); font-size: 0.75rem; color: var(--color-gray);">{{ $amenity }}</span>
                                        @endforeach
                                    </div>
                                    <div style="text-align: right;">
                                        @if($hotel->discount > 0)
                                            <div style="text-decoration: line-through; color: var(--color-gray); font-size: 0.875rem;">
                                                Rp {{ number_format($hotel->price, 0, ',', '.') }}
                                            </div>
                                            <div style="font-size: 1.75rem; font-weight: 700; color: var(--color-primary);">
                                                Rp {{ number_format($hotel->discounted_price, 0, ',', '.') }}
                                            </div>
                                        @else
                                            <div style="font-size: 1.75rem; font-weight: 700; color: var(--color-primary);">
                                                Rp {{ number_format($hotel->price, 0, ',', '.') }}
                                            </div>
                                        @endif
                                        <div style="color: var(--color-gray); font-size: 0.875rem;">per night</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div style="text-align: center; padding: 64px 0;">
                            <p style="color: var(--color-gray); font-size: 1.125rem;">No hotels found matching your criteria.</p>
                            <a href="{{ route('hotels.search') }}" class="btn btn-primary" style="margin-top: 24px;">Clear Filters</a>
                        </div>
                    @endforelse
                </div>

                @if($hotels->hasPages())
                    <div style="margin-top: 48px;">
                        {{ $hotels->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
