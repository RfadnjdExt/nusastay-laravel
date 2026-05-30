@extends('layouts.guest')

@section('title', 'Login | Nusa Stay')

@section('content')
<section style="min-height: 80vh; display: flex; align-items: center; padding: 80px 0;">
    <div class="container">
        <div style="max-width: 480px; margin: 0 auto; background: var(--color-card-bg); padding: 48px; border-radius: var(--radius-lg); box-shadow: var(--shadow-soft);">
            <h1 style="font-size: 2rem; margin-bottom: 8px; text-align: center;">Welcome Back</h1>
            <p style="color: var(--color-gray); text-align: center; margin-bottom: 32px;">Sign in to your account</p>

            @if($errors->any())
                <div style="background: #fee; border: 1px solid #fcc; color: #c33; padding: 12px; border-radius: var(--radius-sm); margin-bottom: 24px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div style="margin-bottom: 24px;">
                    <label for="email" style="display: block; margin-bottom: 8px; font-weight: 600;">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        style="width: 100%; padding: 12px 16px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 1rem; transition: var(--transition);"
                        onfocus="this.style.borderColor='var(--color-primary)'"
                        onblur="this.style.borderColor='var(--color-gray-light)'"
                    >
                </div>

                <div style="margin-bottom: 24px;">
                    <label for="password" style="display: block; margin-bottom: 8px; font-weight: 600;">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 1rem; transition: var(--transition);"
                        onfocus="this.style.borderColor='var(--color-primary)'"
                        onblur="this.style.borderColor='var(--color-gray-light)'"
                    >
                </div>

                <div style="margin-bottom: 24px; display: flex; align-items: center;">
                    <input type="checkbox" id="remember" name="remember" style="margin-right: 8px;">
                    <label for="remember" style="color: var(--color-gray); font-size: 0.875rem;">Remember me</label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 1rem;">
                    Sign In
                </button>
            </form>

            <p style="text-align: center; margin-top: 24px; color: var(--color-gray);">
                Don't have an account?
                <a href="{{ route('register') }}" style="color: var(--color-primary); font-weight: 600;">Sign up</a>
            </p>
        </div>
    </div>
</section>
@endsection
