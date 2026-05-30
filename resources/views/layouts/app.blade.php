<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Nusa Stay | Your Urban Escape')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link rel="stylesheet" href="{{ asset('css/nusastay.css') }}">
    @stack('styles')
</head>
<body>
    <nav class="scrolled">
        <div class="container flex items-center justify-between">
            <a href="{{ route('home') }}" class="logo">
                <span>🏝️</span> Nusa Stay
            </a>

            <ul class="nav-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('hotels.search') }}">Search</a></li>
                <li><a href="{{ route('blog.index') }}">Blog</a></li>
            </ul>

            <div class="nav-actions">
                <div class="user-menu">
                    <button class="user-menu-btn">
                        <span>👤</span>
                        <span>{{ auth()->user()->name }}</span>
                        <span>▼</span>
                    </button>
                    <div class="user-menu-dropdown hidden">
                        <div class="user-menu-content">
                            <a href="{{ route('profile.index') }}">My Bookings</a>
                            <a href="{{ route('profile.settings') }}">Settings</a>
                            <hr>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main style="padding-top: 80px;">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer style="background: var(--color-dark); color: var(--color-light); padding: 48px 0; margin-top: 80px;">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 32px;">
                <div>
                    <div class="logo" style="color: var(--color-light); margin-bottom: 16px;">
                        <span>🏝️</span> Nusa Stay
                    </div>
                    <p style="color: var(--color-gray);">Your gateway to Indonesia's finest urban accommodations.</p>
                </div>
                <div>
                    <h4 style="margin-bottom: 16px;">Quick Links</h4>
                    <ul style="display: flex; flex-direction: column; gap: 8px;">
                        <li><a href="{{ route('home') }}" style="color: var(--color-gray);">Home</a></li>
                        <li><a href="{{ route('hotels.search') }}" style="color: var(--color-gray);">Search Hotels</a></li>
                        <li><a href="{{ route('blog.index') }}" style="color: var(--color-gray);">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="margin-bottom: 16px;">Contact</h4>
                    <p style="color: var(--color-gray);">Email: info@nusastay.com</p>
                    <p style="color: var(--color-gray);">Phone: +62 21 1234 5678</p>
                </div>
            </div>
            <hr style="margin: 32px 0; border-color: rgba(255,255,255,0.1);">
            <p style="text-align: center; color: var(--color-gray);">&copy; 2024 Nusa Stay. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.querySelector('.user-menu-btn').addEventListener('click', function() {
            document.querySelector('.user-menu-dropdown').classList.toggle('hidden');
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-menu')) {
                document.querySelector('.user-menu-dropdown').classList.add('hidden');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
