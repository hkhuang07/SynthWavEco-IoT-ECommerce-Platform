@extends('layouts.app')

@section('content')
<div class="auth-container-greentech">
    <div class="auth-container">
        <div class="auth-regis-background"></div>

        <div class="auth-card">
            <div class="auth-regis-welcome">
                <div class="welcome-overlay"></div>
                <div class="welcome-content">
                    <h1>Welcome to GreenTech</h1>
                    <p class="welcome-motto">{{ 'Smart Agriculture, Fueling Markets!' }}</p>
                </div>
            </div>

            <div class="auth-form-section">
                <div class="auth-form-header">
                    <a href="{{ route('user.login') }}" class="register-link">
                        &gt; Login
                    </a>
                </div>

                <header class="navbar px-0 pb-4 mt-n2 mt-sm-0 mb-2 mb-md-3 mb-lg-4">
                    <a href="{{ route('frontend.home') }}" class="navbar-brand pt-0 d-flex align-items-center">
                        <span class="d-flex flex-shrink-0 text-primary me-2 auth-logo-greentech">
                            <img src="{{ asset('public/images/greentech-logo.jpg') }}" alt="{{ config('app.name', 'GreenTech') }} Logo" />
                        </span>
                        <span class="fw-bold fs-5">{{ config('app.name', 'GreenTech') }}</span>
                    </a>
                </header>

                <h2 class="auth-form-title">{{ __('Register') }}</h2>

                <!-- Error Messages -->
                @if ($errors->any())
                <div class="auth-message auth-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ __('Registration failed. Please check the form fields.') }}
                </div>
                @endif

                <form method="POST" action="{{ route('user.register') }}" class="auth-form" id="registerForm">
                    @csrf

                    <!-- Full Name -->
                    <div class="auth-input-group">
                        <i class="fas fa-user-circle auth-input-icon"></i>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            placeholder="{{ __('Full Name') }}"
                            value="{{ old('name') }}"
                            class="auth-input form-control-lg @error('name') auth-input-error @enderror"
                            required
                            autocomplete="name"
                            autofocus
                        >
                    </div>
                    @error('name')
                        <div class="auth-message auth-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Email -->
                    <div class="auth-input-group">
                        <i class="fas fa-envelope auth-input-icon"></i>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            placeholder="{{ __('Email Address') }}"
                            value="{{ old('email') }}"
                            class="auth-input form-control-lg @error('email') auth-input-error @enderror"
                            required
                            autocomplete="email"
                        >
                    </div>
                    @error('email')
                        <div class="auth-message auth-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Username (Optional) -->
                    <div class="auth-input-group">
                        <i class="fas fa-at auth-input-icon"></i>
                        <input
                            id="username"
                            type="text"
                            name="username"
                            placeholder="Username (Optional)"
                            value="{{ old('username') }}"
                            class="auth-input form-control-lg @error('username') auth-input-error @enderror"
                            autocomplete="username"
                        >
                    </div>
                    @error('username')
                        <div class="auth-message auth-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Phone Number (Optional) -->
                    <div class="auth-input-group">
                        <i class="fas fa-phone auth-input-icon"></i>
                        <input
                            id="phone"
                            type="text"
                            name="phone"
                            placeholder="Phone Number (Optional)"
                            value="{{ old('phone') }}"
                            class="auth-input form-control-lg @error('phone') auth-input-error @enderror"
                            autocomplete="tel"
                        >
                    </div>
                    @error('phone')
                        <div class="auth-message auth-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- ID Card / CCCD (Optional) -->
                    <div class="auth-input-group">
                        <i class="fas fa-id-card auth-input-icon"></i>
                        <input
                            id="id_card"
                            type="text"
                            name="id_card"
                            placeholder="ID Card / CCCD (Optional)"
                            value="{{ old('id_card') }}"
                            class="auth-input form-control-lg @error('id_card') auth-input-error @enderror"
                            autocomplete="off"
                        >
                    </div>
                    @error('id_card')
                        <div class="auth-message auth-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Password -->
                    <div class="auth-input-group">
                        <i class="fas fa-lock auth-input-icon"></i>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="{{ __('Password') }}"
                            class="auth-input form-control-lg @error('password') auth-input-error @enderror"
                            required
                            autocomplete="new-password"
                            minlength="8"
                        >
                    </div>
                    @error('password')
                        <div class="auth-message auth-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Confirm Password -->
                    <div class="auth-input-group">
                        <i class="fas fa-lock auth-input-icon"></i>
                        <input
                            id="password-confirm"
                            type="password"
                            name="password_confirmation"
                            placeholder="{{ __('Confirm Password') }}"
                            class="auth-input form-control-lg"
                            required
                            autocomplete="new-password"
                            minlength="8"
                        >
                    </div>

                    <button type="submit" class="auth-btn-login" id="registerButton" disabled>
                        <span class="btn-text">{{ __('Register') }}</span>
                        <span class="btn-loading">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                    </button>
                </form>

                <!-- Login Link -->
                <p class="auth-register-text">
                    Already have an account? 
                    <a href="{{ route('user.login') }}" class="auth-link">
                        Log In
                    </a>
                </p>

                <!-- Footer -->
                <p class="fs-xs mb-0 mt-4">
                    Copyright &copy; by <a class="auth-link" href="#" target="_blank">{{ config('app.name', 'GreenTech') }}</a>.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const button = document.getElementById('registerButton');
    const inputs = form.querySelectorAll('.auth-input');

    // Enable button only when all required fields are filled
    function checkFormValidity() {
        const nameInput = form.querySelector('input[name="name"]');
        const emailInput = form.querySelector('input[name="email"]');
        const passwordInput = form.querySelector('input[name="password"]');
        const confirmPasswordInput = form.querySelector('input[name="password_confirmation"]');
        
        const isValid = nameInput.value.trim() !== '' && 
                        emailInput.value.trim() !== '' && 
                        passwordInput.value.trim() !== '' &&
                        confirmPasswordInput.value.trim() !== '' &&
                        passwordInput.value === confirmPasswordInput.value;

        button.disabled = !isValid;
    }

    // Check validity on input
    inputs.forEach(input => {
        input.addEventListener('input', checkFormValidity);
        input.addEventListener('change', checkFormValidity);
    });

    // Initial check
    checkFormValidity();

    // Form submission handling
    form.addEventListener('submit', function(e) {
        button.disabled = true;
        button.classList.add('auth-btn-loading');
    });

    // Auto-hide messages after 5 seconds
    const messages = document.querySelectorAll('.auth-message');
    messages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            setTimeout(() => {
                message.style.display = 'none';
            }, 300);
        }, 5000);
    });
});
</script>

<!-- Include the CSS -->
<style>
    /* Import the updated auth styles */
    body {
        background: none !important;
    }
    
    .auth-container-greentech {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        overflow: hidden;
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 50%, #a5d6a7 100%);
    }
</style>
@endsection