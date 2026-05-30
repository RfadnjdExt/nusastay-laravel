@extends('layouts.guest')

@section('title', 'Nusa Stay | Your Urban Escape')

@section('content')
<section style="min-height: 80vh; display: flex; align-items: center; background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%); color: var(--color-light); position: relative; overflow: hidden;">
    <div class="container" style="position: relative; z-index: 2;">
        <div style="max-width: 700px;">
            <div class="badge" style="margin-bottom: 24px;">✨ Premium Urban Stays</div>
            <h1 style="font-size: 4rem; margin-bottom: 24px; line-height: 1.1;">
                Your Urban <span style="color: var(--color-gold);">Escape</span> Awaits
            </h1>
            <p style="font-size: 1.25rem; margin-bottom: 32px; opacity: 0.9;">
                Discover handpicked hotels and apartments in Indonesia's most vibrant cities. Modern comfort meets local charm.
            </p>
            <div style="display: flex; gap: 16px;">
                <a href="{{ route('register') }}" class="btn btn-primary" style="font-size: 1.125rem; padding: 16px 32px;">
                    Get Started →
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline" style="font-size: 1.125rem; padding: 16px 32px; background: rgba(255,255,255,0.1); border-color: var(--color-light); color: var(--color-light);">
                    Sign In
                </a>
            </div>
        </div>
    </div>
    <div style="position: absolute; top: 0; right: 0; width: 50%; height: 100%; opacity: 0.1; background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><circle cx=%2250%22 cy=%2250%22 r=%2240%22 fill=%22white%22/></svg>') repeat; background-size: 100px;"></div>
</section>

<section style="padding: 80px 0;">
    <div class="container">
        <div class="text-center" style="margin-bottom: 64px;">
            <h2 style="font-size: 2.5rem; margin-bottom: 16px;">Why Choose Nusa Stay?</h2>
            <p style="color: var(--color-gray); font-size: 1.125rem;">Experience the difference with our curated selection</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 32px;">
            <div style="background: var(--color-card-bg); padding: 32px; border-radius: var(--radius-md); box-shadow: var(--shadow-soft); text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 16px;">🏨</div>
                <h3 style="margin-bottom: 12px;">Handpicked Properties</h3>
                <p style="color: var(--color-gray);">Every hotel is carefully selected for quality, location, and value.</p>
            </div>

            <div style="background: var(--color-card-bg); padding: 32px; border-radius: var(--radius-md); box-shadow: var(--shadow-soft); text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 16px;">💰</div>
                <h3 style="margin-bottom: 12px;">Best Price Guarantee</h3>
                <p style="color: var(--color-gray);">Find the best deals with exclusive discounts up to 20% off.</p>
            </div>

            <div style="background: var(--color-card-bg); padding: 32px; border-radius: var(--radius-md); box-shadow: var(--shadow-soft); text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 16px;">⚡</div>
                <h3 style="margin-bottom: 12px;">Instant Confirmation</h3>
                <p style="color: var(--color-gray);">Book now and receive instant confirmation for your stay.</p>
            </div>
        </div>
    </div>
</section>

<section style="padding: 80px 0; background: var(--color-bg);">
    <div class="container">
        <div class="text-center" style="margin-bottom: 64px;">
            <h2 style="font-size: 2.5rem; margin-bottom: 16px;">Popular Destinations</h2>
            <p style="color: var(--color-gray); font-size: 1.125rem;">Explore Indonesia's most vibrant cities</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 32px;">
            <div style="position: relative; border-radius: var(--radius-lg); overflow: hidden; height: 400px; cursor: pointer; transition: var(--transition);">
                <img src="{{ asset('images/bandung.webp') }}" alt="Bandung" style="width: 100%; height: 100%; object-fit: cover;">
                <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); display: flex; flex-direction: column; justify-content: flex-end; padding: 32px; color: white;">
                    <h3 style="font-size: 2rem; margin-bottom: 8px;">Bandung</h3>
                    <p style="opacity: 0.9;">12+ Properties</p>
                </div>
            </div>

            <div style="position: relative; border-radius: var(--radius-lg); overflow: hidden; height: 400px; cursor: pointer; transition: var(--transition);">
                <img src="{{ asset('images/jakarta.webp') }}" alt="Jakarta" style="width: 100%; height: 100%; object-fit: cover;">
                <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); display: flex; flex-direction: column; justify-content: flex-end; padding: 32px; color: white;">
                    <h3 style="font-size: 2rem; margin-bottom: 8px;">Jakarta</h3>
                    <p style="opacity: 0.9;">24+ Properties</p>
                </div>
            </div>

            <div style="position: relative; border-radius: var(--radius-lg); overflow: hidden; height: 400px; cursor: pointer; transition: var(--transition);">
                <img src="{{ asset('images/surabaya.webp') }}" alt="Surabaya" style="width: 100%; height: 100%; object-fit: cover;">
                <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); display: flex; flex-direction: column; justify-content: flex-end; padding: 32px; color: white;">
                    <h3 style="font-size: 2rem; margin-bottom: 8px;">Surabaya</h3>
                    <p style="opacity: 0.9;">18+ Properties</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section style="padding: 80px 0; background: var(--color-primary); color: var(--color-light); text-align: center;">
    <div class="container">
        <h2 style="font-size: 2.5rem; margin-bottom: 24px;">Ready to Start Your Journey?</h2>
        <p style="font-size: 1.25rem; margin-bottom: 32px; opacity: 0.9;">Join thousands of travelers who trust Nusa Stay</p>
        <a href="{{ route('register') }}" class="btn btn-primary" style="font-size: 1.125rem; padding: 16px 32px; background: var(--color-accent);">
            Create Free Account →
        </a>
    </div>
</section>
@endsection