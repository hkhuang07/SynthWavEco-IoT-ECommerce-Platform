<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light" data-pwa="true">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Register an account | {{ config('app.name', 'GreenTech') }}</title>

    <link rel="stylesheet" href="{{ asset('public/assets/vendor/font-awesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/icons/cartzilla-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/css/auth.css') }}" />
</head>

<body class="auth-container-greentech">
    <main class="content-wrapper w-100">
        <div class="auth-container">
            <!-- Background với hiệu ứng gradient và blur -->
            <div class="auth-regis-background"></div>

            <div class="auth-card">
                <!-- Phần bên trái - Chào mừng và slogan -->
                <div class="auth-regis-welcome">
                    <div class="welcome-overlay"></div>
                    <div class="welcome-content">
                        <h1>Welcome to GreenTech</h1>
                        <p class="welcome-motto">Smart Agriculture, Fueling Markets!</p>
                    </div>
                </div>

                <!-- Phần bên phải - Form Đăng ký -->
                <div class="auth-form-section">
                    <!-- Header: Logo + GreenTech bên trái, Login bên phải -->
                    <div class="auth-form-header">
                        <a href="{{ route('frontend.home') }}" class="navbar-brand">
                            <span class="d-flex flex-shrink-0 text-primary me-2 auth-logo-greentech">
                                <img src="{{ asset('public/images/greentech-logo.jpg') }}" alt="Logo" />
                            </span>
                            <span class="greentech-title-header">GreenTech</span>
                        </a>
                        
                        <a href="{{ route('user.login') }}" class="register-link">
                            Login
                        </a>
                    </div>

                    <h2 class="auth-form-title">{{ __('Register') }}</h2>

                    <!-- Error Messages -->
                    @if ($errors->any())
                    <div class="auth-message auth-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ __('Registration failed. Please check the form fields.') }}
                    </div>
                    @endif

                    <form method="post" action="{{ route('user.register.post') }}" class="auth-form needs-validation" novalidate id="registerForm">
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
                                autofocus>
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
                                autocomplete="email">
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
                                autocomplete="username">
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
                                autocomplete="tel">
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
                                autocomplete="off">
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
                                minlength="8">
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
                                minlength="8">
                        </div>

                        <!-- Privacy Policy Checkbox -->
                        <div class="auth-remember">
                            <input type="checkbox" id="privacy" name="privacy" />
                            <label for="privacy" class="auth-remember-label">
                                I have read and accept
                                <a href="#" class="auth-link">Privacy policy</a>
                            </label>
                        </div>

                        <button type="submit" class="auth-btn-login" id="registerButton" disabled>
                            <span class="btn-text">{{ __('Create an account') }}</span>
                            <span class="btn-loading">
                                <i class="fas fa-spinner fa-spin"></i>
                            </span>
                        </button>
                    </form>

                    <!-- Social Login Section -->
                    <div class="social-login-section">
                        <div class="social-login-divider">
                            <span>or register with</span>
                        </div>
                        <div class="social-login-buttons">
                            <a href="{{ route('google.login') }}" class="social-btn btn-google">
                                <i class="fab fa-google"></i>
                                <span>Google</span>
                            </a>
                            <a href="#" class="social-btn btn-facebook">
                                <i class="fab fa-facebook-f"></i>
                                <span>Facebook</span>
                            </a>
                            <a href="#" class="social-btn btn-apple">
                                <i class="fab fa-apple"></i>
                                <span>Apple</span>
                            </a>
                        </div>
                    </div>

                    <!-- Login Link -->
                    <p class="auth-register-text">
                        Already have an account?
                        <a href="{{ route('user.login') }}">Sign In</a>
                    </p>

                    <!-- Footer -->
                    <p class="auth-copyright-text fs-xs mb-0 mt-4 text-center">
                        Copyright &copy; by <a href="#">{{ config('app.name', 'GreenTech') }}</a>. Sign In. Privacy policy
                    </p>
                </div>
            </div>
        </div>
    </main>

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
    <script src="{{ asset('public/assets/js/theme.min.js') }}"></script>
</body>

</html>