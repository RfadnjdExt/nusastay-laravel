@extends('layouts.guest')

@section('title', 'Register | Nusa Stay')

@section('content')
<section style="min-height: 80vh; display: flex; align-items: center; padding: 80px 0;">
    <div class="container">
        <div style="max-width: 480px; margin: 0 auto; background: var(--color-card-bg); padding: 48px; border-radius: var(--radius-lg); box-shadow: var(--shadow-soft);">
            <h1 style="font-size: 2rem; margin-bottom: 8px; text-align: center;">Create Account</h1>
            <p style="color: var(--color-gray); text-align: center; margin-bottom: 32px;">Join Nusa Stay today</p>

            @if($errors->any())
                <div style="background: #fee; border: 1px solid #fcc; color: #c33; padding: 12px; border-radius: var(--radius-sm); margin-bottom: 24px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div style="margin-bottom: 20px;">
                    <label for="name" style="display: block; margin-bottom: 8px; font-weight: 600;">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                        style="width: 100%; padding: 12px 16px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 1rem; transition: var(--transition);"
                        onfocus="this.style.borderColor='var(--color-primary)'" onblur="this.style.borderColor='var(--color-gray-light)'">
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="email" style="display: block; margin-bottom: 8px; font-weight: 600;">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        style="width: 100%; padding: 12px 16px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 1rem; transition: var(--transition);"
                        onfocus="this.style.borderColor='var(--color-primary)'" onblur="this.style.borderColor='var(--color-gray-light)'">
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="phone" style="display: block; margin-bottom: 8px; font-weight: 600;">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                        style="width: 100%; padding: 12px 16px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 1rem; transition: var(--transition);"
                        onfocus="this.style.borderColor='var(--color-primary)'" onblur="this.style.borderColor='var(--color-gray-light)'">
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="date_of_birth" style="display: block; margin-bottom: 8px; font-weight: 600;">Date of Birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required
                        style="width: 100%; padding: 12px 16px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 1rem; transition: var(--transition);"
                        onfocus="this.style.borderColor='var(--color-primary)'" onblur="this.style.borderColor='var(--color-gray-light)'">
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="password" style="display: block; margin-bottom: 8px; font-weight: 600;">Password</label>
                    <input type="password" id="password" name="password" required
                        style="width: 100%; padding: 12px 16px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 1rem; transition: var(--transition);"
                        onfocus="this.style.borderColor='var(--color-primary)'" onblur="this.style.borderColor='var(--color-gray-light)'">
                </div>

                <div style="margin-bottom: 24px;">
                    <label for="password_confirmation" style="display: block; margin-bottom: 8px; font-weight: 600;">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        style="width: 100%; padding: 12px 16px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 1rem; transition: var(--transition);"
                        onfocus="this.style.borderColor='var(--color-primary)'" onblur="this.style.borderColor='var(--color-gray-light)'">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 1rem;">
                    Create Account
                </button>
            </form>

            <p style="text-align: center; margin-top: 24px; color: var(--color-gray);">
                Already have an account?
                <a href="{{ route('login') }}" style="color: var(--color-primary); font-weight: 600;">Sign in</a>
            </p>
        </div>
    </div>
</section>
@endsection
