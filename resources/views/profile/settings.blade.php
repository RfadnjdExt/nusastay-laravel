@extends('layouts.app')

@section('title', 'Settings | Nusa Stay')

@section('content')
<section style="padding: 48px 0; background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%); color: var(--color-light);">
    <div class="container">
        <h1 style="font-size: 2.5rem; margin-bottom: 16px;">Account Settings</h1>
        <p style="font-size: 1.125rem; opacity: 0.9;">Manage your profile and preferences</p>
    </div>
</section>

<section style="padding: 64px 0;">
    <div class="container">
        <div style="display: flex; gap: 32px;">
            <div style="flex: 0 0 280px;">
                <div style="background: var(--color-card-bg); padding: 24px; border-radius: var(--radius-lg); box-shadow: var(--shadow-soft);">
                    <h3 style="font-size: 1.25rem; margin-bottom: 20px;">Account</h3>
                    <nav style="display: flex; flex-direction: column; gap: 8px;">
                        <a href="{{ route('profile.index') }}" style="padding: 12px 16px; border-radius: var(--radius-sm); color: var(--color-gray); transition: var(--transition);"
                            onmouseover="this.style.background='var(--color-bg)'" onmouseout="this.style.background='transparent'">
                            My Bookings
                        </a>
                        <a href="{{ route('profile.settings') }}" style="padding: 12px 16px; border-radius: var(--radius-sm); background: var(--color-primary); color: var(--color-light); font-weight: 600;">
                            Settings
                        </a>
                    </nav>
                </div>
            </div>

            <div style="flex: 1; max-width: 600px;">
                <div style="background: var(--color-card-bg); padding: 40px; border-radius: var(--radius-lg); box-shadow: var(--shadow-soft);">
                    <h2 style="font-size: 1.75rem; margin-bottom: 32px;">Profile Information</h2>

                    @if(session('success'))
                        <div style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 12px; border-radius: var(--radius-sm); margin-bottom: 24px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div style="background: #fee; border: 1px solid #fcc; color: #c33; padding: 12px; border-radius: var(--radius-sm); margin-bottom: 24px;">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf

                        <div style="margin-bottom: 24px;">
                            <label for="name" style="display: block; margin-bottom: 8px; font-weight: 600;">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                style="width: 100%; padding: 12px 16px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 1rem; transition: var(--transition);"
                                onfocus="this.style.borderColor='var(--color-primary)'" onblur="this.style.borderColor='var(--color-gray-light)'">
                        </div>

                        <div style="margin-bottom: 24px;">
                            <label for="email" style="display: block; margin-bottom: 8px; font-weight: 600;">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                style="width: 100%; padding: 12px 16px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 1rem; transition: var(--transition);"
                                onfocus="this.style.borderColor='var(--color-primary)'" onblur="this.style.borderColor='var(--color-gray-light)'">
                        </div>

                        <div style="margin-bottom: 24px;">
                            <label for="phone" style="display: block; margin-bottom: 8px; font-weight: 600;">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required
                                style="width: 100%; padding: 12px 16px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 1rem; transition: var(--transition);"
                                onfocus="this.style.borderColor='var(--color-primary)'" onblur="this.style.borderColor='var(--color-gray-light)'">
                        </div>

                        <div style="margin-bottom: 32px;">
                            <label for="date_of_birth" style="display: block; margin-bottom: 8px; font-weight: 600;">Date of Birth</label>
                            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}" required
                                style="width: 100%; padding: 12px 16px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 1rem; transition: var(--transition);"
                                onfocus="this.style.borderColor='var(--color-primary)'" onblur="this.style.borderColor='var(--color-gray-light)'">
                        </div>

                        <hr style="margin: 32px 0; border: none; border-top: 1px solid var(--color-gray-light);">

                        <h3 style="font-size: 1.25rem; margin-bottom: 24px;">Change Password</h3>
                        <p style="color: var(--color-gray); font-size: 0.875rem; margin-bottom: 20px;">Leave blank to keep current password</p>

                        <div style="margin-bottom: 20px;">
                            <label for="current_password" style="display: block; margin-bottom: 8px; font-weight: 600;">Current Password</label>
                            <input type="password" id="current_password" name="current_password"
                                style="width: 100%; padding: 12px 16px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 1rem; transition: var(--transition);"
                                onfocus="this.style.borderColor='var(--color-primary)'" onblur="this.style.borderColor='var(--color-gray-light)'">
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label for="new_password" style="display: block; margin-bottom: 8px; font-weight: 600;">New Password</label>
                            <input type="password" id="new_password" name="new_password"
                                style="width: 100%; padding: 12px 16px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 1rem; transition: var(--transition);"
                                onfocus="this.style.borderColor='var(--color-primary)'" onblur="this.style.borderColor='var(--color-gray-light)'">
                        </div>

                        <div style="margin-bottom: 32px;">
                            <label for="new_password_confirmation" style="display: block; margin-bottom: 8px; font-weight: 600;">Confirm New Password</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                style="width: 100%; padding: 12px 16px; border: 2px solid var(--color-gray-light); border-radius: var(--radius-sm); font-size: 1rem; transition: var(--transition);"
                                onfocus="this.style.borderColor='var(--color-primary)'" onblur="this.style.borderColor='var(--color-gray-light)'">
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 1rem;">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
