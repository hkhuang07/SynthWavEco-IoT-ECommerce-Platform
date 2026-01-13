<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light" data-pwa="true">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Login | {{ config('app.name', 'GreenTech') }}</title>

    <link rel="stylesheet" href="{{ asset('public/assets/vendor/font-awesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/icons/cartzilla-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/css/auth.css') }}" />
</head>

<body class="auth-container-greentech">
    <main class="content-wrapper w-100">
        <div class="auth-container">
            <!-- Background với hiệu ứng gradient và blur -->
            <div class="auth-background"></div>

            <div class="auth-card">
                <!-- Phần bên trái - Chào mừng và slogan -->
                <div class="auth-welcome">
                    <div class="welcome-overlay"></div>
                    <div class="welcome-content">
                        <h1>Welcome to GreenTech</h1>
                        <p class="welcome-motto">Smart Agriculture, Fueling Markets!</p>
                    </div>
                </div>

                <!-- Phần bên phải - Form Đăng nhập -->
                <div class="auth-form-section">
                    <!-- Header: Logo + GreenTech bên trái, Register bên phải -->
                    <div class="auth-form-header">
                        <a href="{{ route('frontend.home') }}" class="navbar-brand">
                            <span class="d-flex flex-shrink-0 text-primary me-2 auth-logo-greentech">
                                <img src="{{ asset('public/images/greentech-logo.jpg') }}" alt="Logo" />
                            </span>
                            <span class="greentech-title-header">GreenTech</span>
                        </a>
                        
                        <a href="{{ route('user.register') }}" class="register-link">
                            Register
                        </a>
                    </div>

                    <h2 class="auth-form-title">Login</h2>

                    <!-- Success/Error Messages -->
                    @if(session('warning'))
                    <div class="auth-message auth-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ session('warning') }}
                    </div>
                    @endif

                    @if (session('status'))
                    <div class="auth-message auth-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('status') }}
                    </div>
                    @endif

                    @if (session('success'))
                    <div class="auth-message auth-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                    @endif

                    <form method="post" action="{{ route('user.login.post') }}" class="auth-form needs-validation" novalidate id="loginForm">
                        @csrf

                        <!-- Trường Username/Email/Phone -->
                        <div class="auth-input-group">
                            <i class="fas fa-user auth-input-icon"></i>
                            <input
                                type="text"
                                name="email"
                                placeholder="Email, Username, ID Card or Phone Number"
                                value="{{ old('email') }}"
                                class="auth-input form-control-lg @error('email') auth-input-error @enderror"
                                required
                                autocomplete="login"
                                autofocus>
                        </div>
                        @error('email')
                        <div class="auth-message auth-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </div>
                        @enderror
                        @error('username')
                        <div class="auth-message auth-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </div>
                        @enderror
                        @error('login')
                        <div class="auth-message auth-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </div>
                        @enderror

                        <!-- Trường Password -->
                        <div class="auth-input-group">
                            <i class="fas fa-lock auth-input-icon"></i>
                            <input
                                type="password"
                                name="password"
                                placeholder="Password"
                                class="auth-input form-control-lg @error('password') auth-input-error @enderror"
                                required
                                autocomplete="current-password">
                        </div>
                        @error('password')
                        <div class="auth-message auth-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </div>
                        @enderror

                        <!-- Liên kết đổi mật khẩu -->
                        <div class="auth-form-links">
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="auth-link">
                                Forgot Password?
                            </a>
                            @endif
                        </div>

                        <!-- Remember Me -->
                        <div class="auth-remember">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="auth-remember-label">Remember Me</label>
                        </div>

                        <!-- Nút Login -->
                        <button type="submit" class="auth-btn-login" id="loginButton" disabled>
                            <span class="btn-text">Log In</span>
                            <span class="btn-loading">
                                <i class="fas fa-spinner fa-spin"></i>
                            </span>
                        </button>
                    </form>

                    <!-- Social Login Section -->
                    <div class="social-login-section">
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

                    <!-- Register Link -->
                    <p class="auth-register-text">
                        Don't have an account yet?
                        <a href="{{ route('user.register') }}">Sign Up</a>
                    </p>

                    <!-- Footer -->
                    <p class="fs-xs mb-0 mt-4 text-center">
                        Copyright &copy; by <a href="#" target="_blank">{{ config('app.name', 'GreenTech') }}</a>. Sign In. Privacy policy
                    </p>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const button = document.getElementById('loginButton');
            const inputs = form.querySelectorAll('.auth-input');

            // Enable button only when all required fields are filled
            function checkFormValidity() {
                const loginInput = form.querySelector('input[name="email"]');
                const passwordInput = form.querySelector('input[name="password"]');

                const isValid = loginInput.value.trim() !== '' && passwordInput.value.trim() !== '';
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