<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light" data-pwa="true">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Register an account | {{ config('app.name', 'GreenTech') }}</title>

    {{-- Tải các tài nguyên cơ bản của Cartzilla --}}
    <script src="{{ asset('public/assets/js/theme-switcher.js') }}"></script>
    <link rel="preload" href="{{ asset('public/assets/fonts/inter-variable-latin.woff2') }}" as="font" type="font/woff2" crossorigin />
    <link rel="stylesheet" href="{{ asset('public/assets/icons/cartzilla-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/font-awesome/css/all.min.css') }}" /> {{-- Font Awesome cho spinner --}}
    <link rel="stylesheet" href="{{ asset('public/assets/css/theme.min.css') }}" id="theme-styles" />

    {{-- Tải các file CSS tùy chỉnh --}}
    <link rel="stylesheet" href="{{ asset('public/css/form.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/css/layout.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/css/list.css') }}" /> 

</head>

<body class="auth-container-greentech">
    <main class="content-wrapper w-100">
        <div class="d-lg-flex">

            {{-- Cột Trái: Form Đăng ký (auth-form-section) --}}
            <div class="d-flex flex-column min-vh-100 w-100 py-4 px-3 px-lg-0 mx-auto me-lg-5 auth-form-section" style="max-width:416px">

                {{-- Logo --}}
                <header class="navbar px-0 pb-4 mt-n2 mt-sm-0 mb-2 mb-md-3 mb-lg-4">
                    <a href="{{ route('frontend.home') }}" class="navbar-brand pt-0 d-flex align-items-center">
                        <span class="d-flex flex-shrink-0 text-primary me-2 auth-logo-greentech">
                            <img src="{{ asset('public/images/greentech-logo.jpg') }}" alt="{{ config('app.name', 'GreenTech') }} Logo" />
                        </span>
                        <span class="fw-bold fs-5">{{ config('app.name', 'GreenTech') }}</span>
                    </a>
                </header>

                <h1 class="h2 mt-auto">Create a New GreenTech Account</h1>

                {{-- Link chuyển sang Login --}}
                <div class="nav fs-sm mb-4">
                    I already have an account.
                    <a class="nav-link text-decoration-underline p-0 ms-2" href="{{ route('user.login') }}">Sign In</a>
                </div>

                {{-- Hiển thị lỗi chung (dùng cấu trúc alert của Bootstrap) --}}
                @if ($errors->any())
                <div class="alert d-flex alert-danger" role="alert">
                    <i class="ci-banned fs-lg pe-1 mt-1 me-2"></i>
                    <div>{{ __('Registration failed. Please check the form fields.') }}</div>
                </div>
                @endif

                {{-- Form Đăng ký --}}
                <form method="post" action="{{ route('user.register.post') }}" class="needs-validation" novalidate id="registerForm">
                    @csrf

                    {{-- Full Name (Required) --}}
                    <div class="position-relative mb-4">
                        <!--label for="name" class="form-label">Full Name</label-->
                        <input type="text"
                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Full Name"
                            required />
                        @error('name')
                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>

                    {{-- Email (Required) --}}
                    <div class="position-relative mb-4">
                        <!--label for="email" class="form-label">Email Address</label-->
                        <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Email Address"
                            autocomplete="off"
                            required />
                        @error('email')
                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>

                    {{-- Username (Optional) --}}
                    <div class="position-relative mb-4">
                        <!--label for="username" class="form-label">Username (Optional)</label-->
                        <input type="text" class="form-control form-control-lg @error('username') is-invalid @enderror"
                            id="username"
                            name="username"
                            value="{{ old('username') }}" 
                            placeholder="Username (Option)" />
                        @error('username')
                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>

                    {{-- Phone Number (Optional) --}}
                    <div class="position-relative mb-4">
                        <!--label for="phone" class="form-label">Phone Number (Optional)</label-->
                        <input type="text" class="form-control form-control-lg @error('phone') is-invalid @enderror" 
                        id="phone" 
                        name="phone" 
                        value="{{ old('phone') }}" 
                        placeholder="Phone Number"
                        />
                        @error('phone')
                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>

                    {{-- ID Card / CCCD (Optional) --}}
                    <div class="position-relative mb-4">
                        <!--label for="id_card" class="form-label">ID Card / CCCD (Optional)</label-->
                        <input type="text" class="form-control form-control-lg @error('id_card') is-invalid @enderror" 
                        id="id_card" 
                        name="id_card" 
                        value="{{ old('id_card') }}" 
                        placeholder="ID Card"/>
                        @error('id_card')
                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>

                    {{-- Password (Required) --}}
                    <div class="mb-4">
                        <!--label for="password" class="form-label">Password</label-->
                        <div class="password-toggle">
                            <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                            id="password" 
                            name="password" 
                            autocomplete="new-password" 
                            minlength="8" 
                            placeholder="Password (Minimum 8 characters)" 
                            required />
                            @error('password')
                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                            @enderror
                            <label class="password-toggle-button fs-lg">
                                <input type="checkbox" class="btn-check" />
                            </label>
                        </div>
                    </div>

                    {{-- Confirm Password (Required) --}}
                    <div class="mb-4">
                        <!--label for="password-confirm" class="form-label">Confirm Password</label-->
                        <div class="password-toggle">
                            <input type="password" class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" 
                            id="password-confirm" 
                            name="password_confirmation" 
                            autocomplete="new-password" 
                            minlength="8" 
                            placeholder="Confirm Password (Minimum 8 characters)" 
                            required />
                            @error('password_confirmation')
                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                            @enderror
                            <label class="password-toggle-button fs-lg">
                                <input type="checkbox" class="btn-check" />
                            </label>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-2 mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="privacy" name="privacy" />
                            <label for="privacy" class="form-check-label">I have read and accept <a class="text-dark-emphasis" href="#">Privacy policy</a></label>
                        </div>
                    </div>

                    {{-- Submit Button (Dùng lớp auth-btn-login tùy chỉnh) --}}
                    <button type="submit" class="auth-btn-login btn btn-lg btn-primary w-100" id="registerButton">
                        <span class="btn-text">Create an account</span>
                        <span class="btn-loading" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                    </button>
                </form>

                {{-- Social login --}}
                <div class="d-flex align-items-center my-4">
                    <hr class="w-100 m-0">
                    <span class="text-body-emphasis fw-medium text-nowrap mx-4">or register with</span>
                    <hr class="w-100 m-0">
                </div>
                <div class="d-flex flex-column flex-sm-row gap-3 pb-4 mb-3 mb-lg-4">
                    <a href="{{ route('google.login') }}" class="btn btn-lg btn-outline-secondary w-100 px-2">
                        <i class="ci-google ms-1 me-1"></i> Google
                    </a>
                    <a href="#" class="btn btn-lg btn-outline-secondary w-100 px-2">
                        <i class="ci-facebook ms-1 me-1"></i> Facebook
                    </a>
                    <a href="#" class="btn btn-lg btn-outline-secondary w-100 px-2">
                        <i class="ci-apple ms-1 me-1"></i> Apple
                    </a>
                </div>

                {{-- Footer --}}
                <p class="fs-xs mb-0">
                    Copyright &copy; by <span class="animate-underline"><a class="animate-target text-dark-emphasis text-decoration-none" href="#" target="_blank">{{ config('app.name', 'GreenTech') }}</a></span>.
                </p>

            </div>

            <div class="d d-lg-block w-100 py-4 ms-auto auth-cover-greentech" style="max-width:1034px">
                <div class="d-flex flex-column justify-content-center h-100 rounded-5 overflow-hidden">

                    <div class="text-center p-5 auth-welcome-content">
                        <h1 class="display-3 fw-bold mb-3">GreenTech IoT</h1>
                        <p class="lead fw-medium">Smart Agriculture, Fueling Markets.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Script cho Loading Spinner (Tương tự login) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            const button = document.getElementById('registerButton');

            // Xử lý khi nhấn Submit
            form.addEventListener('submit', function(e) {
                // Sử dụng HTML5 checkValidity để kiểm tra các trường required
                if (form.checkValidity()) {
                    button.disabled = true;
                    button.querySelector('.btn-text').style.display = 'none';
                    button.querySelector('.btn-loading').style.display = 'inline-block';
                }
            });
        });
    </script>
    <script src="{{ asset('public/assets/js/theme.min.js') }}"></script>
</body>

</html>