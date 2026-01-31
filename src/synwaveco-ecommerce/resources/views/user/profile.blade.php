@extends('layouts.frontend')
@section('title', 'Personal Profile')
@section('content')


<main class="content-wrapper">
    <nav class="container pt-3 my-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home Page</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Customer</a></li>
            <li class="breadcrumb-item active">Personal Profile</li>
        </ol>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <aside class="col-lg-3">
                <div class="offcanvas-lg offcanvas-start pe-lg-0 pe-xl-4" id="accountSidebar">
                    <div class="offcanvas-header d-lg-block py-3 p-lg-0">

                        <div class="d-flex align-items-center">
                            
                            <!--div class="h5 d-flex justify-content-center align-items-center flex-shrink-0 text-primary bg-primary-subtle lh-1 rounded-circle mb-0" style="width:3rem; height:3rem">{{ strtoupper(substr($user->name, 0, 1)) }}</div-->
                            <img id="currentAvatar" src="{{ asset('storage/app/private') }}/{{$user->avatar}}" alt="Avatar" class="d-flex justify-content-center align-items-center flex-shrink-0 text-primary bg-primary-subtle lh-1 rounded-circle mb-0" style="width:3rem; height:3rem">


                            <div class="min-w-0 ps-3">

                                <h5 class="h6 mb-0">{{ $user->name }}</h5>

                                <div class="nav flex-nowrap text-nowrap min-w-0">

                                    <a class="nav-link animate-underline text-body p-0" href="{{ route('user.home') }}">
                                        {{-- Icon và text Loyal customers giữ nguyên --}}
                                        <svg class="text-warning flex-shrink-0 me-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor">
                                            <path d="M1.333 9.667H7.5V16h-5c-.64 0-1.167-.527-1.167-1.167V9.667zm13.334 0v5.167c0 .64-.527 1.167-1.167 1.167h-5V9.667h6.167zM0 5.833V7.5c0 .64.527 1.167 1.167 1.167h.167H7.5v-1-3H1.167C.527 4.667 0 5.193 0 5.833zm14.833-1.166H8.5v3 1h6.167.167C15.473 8.667 16 8.14 16 7.5V5.833c0-.64-.527-1.167-1.167-1.167z" />
                                            <path d="M8 5.363a.5.5 0 0 1-.495-.573C7.752 3.123 9.054-.03 12.219-.03c1.807.001 2.447.977 2.447 1.813 0 1.486-2.069 3.58-6.667 3.58zM12.219.971c-2.388 0-3.295 2.27-3.595 3.377 1.884-.088 3.072-.565 3.756-.971.949-.563 1.287-1.193 1.287-1.595 0-.599-.747-.811-1.447-.811z" />
                                            <path d="M8.001 5.363c-4.598 0-6.667-2.094-6.667-3.58 0-.836.641-1.812 2.448-1.812 3.165 0 4.467 3.153 4.713 4.819a.5.5 0 0 1-.495.573zM3.782.971c-.7 0-1.448.213-1.448.812 0 .851 1.489 2.403 5.042 2.566C7.076 3.241 6.169.971 3.782.971z" />
                                        </svg>
                                        <span class="text-body fw-normal text-truncate mt-1">Loyal customers</span>
                                    </a>

                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-close d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#accountSidebar"></button>
                    </div>
                    <div class="offcanvas-body d-block pt-2 pt-lg-4 pb-lg-0">
                        <nav class="list-group list-group-borderless">
                            <a class="list-group-item list-group-item-action d-flex align-items-center pe-none active" href="{{ route('user.profile') }}">
                                <i class="ci-user fs-base opacity-75 me-2"></i> Personal Profile
                            </a>

                            <a class="list-group-item list-group-item-action d-flex align-items-center" href="{{ route('user.order') }}">
                                <i class="ci-shopping-bag fs-base opacity-75 me-2"></i> My Orders
                                <span class="badge bg-primary rounded-pill ms-auto">2</span>
                                <!--span class="badge bg-primary rounded-pill ms-auto"></span-->
                            </a>

                            <a class="list-group-item list-group-item-action d-flex align-items-center" href="#">
                                <i class="ci-heart fs-base opacity-75 me-2"></i> Favorite Products
                            </a>
                            <a class="list-group-item list-group-item-action d-flex align-items-center" href="#">
                                <i class="ci-star fs-base opacity-75 me-2"></i> Product Reviews
                            </a>
                            <a class="list-group-item list-group-item-action d-flex align-items-center" href="#">
                                <i class="ci-map-pin fs-base opacity-75 me-2"></i> Address Book
                            </a>
                            <a class="list-group-item list-group-item-action d-flex align-items-center" href="#">
                                <i class="ci-credit-card fs-base opacity-75 me-2"></i> Payment Methods
                            </a>
                            <a class="list-group-item list-group-item-action d-flex align-items-center" href="#">
                                <i class="ci-bell fs-base opacity-75 mt-1 me-2"></i> Notification Settings
                            </a>
                        </nav>
                        <nav class="list-group list-group-borderless pt-3">
                            {{-- Sửa route logout sang route đã định nghĩa 'user.logout' --}}
                            <a class="list-group-item list-group-item-action d-flex align-items-center" href="{{ route('user.logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="ci-log-out fs-base opacity-75 me-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('user.logout') }}" method="post" class="d-none">
                                @csrf
                            </form>
                        </nav>
                    </div>
                </div>
            </aside>

            <div class="col-lg-9">
                <div class="ps-lg-3 ps-xl-0">
                    <h1 class="h2 mb-1 mb-sm-2">Personal Profile</h1>

                    <div class="border-bottom py-4">
                        @if(session('warning'))
                        <div class="alert d-flex alert-danger" role="alert">
                            <i class="ci-banned fs-lg pe-1 mt-1 me-2"></i>
                            <div>{{ session('warning') }}</div>
                        </div>
                        @endif
                        @if(session('success'))
                        <div class="alert d-flex alert-success" role="alert">
                            <i class="ci-check-circle fs-lg pe-1 mt-1 me-2"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                        @endif

                        {{-- FORM CẬP NHẬT PROFILE --}}
                        <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
                            <h2 class="h6 mb-0">Basic Information</h2>
                        </div>
                        <form action="{{ route('user.profile') }}" method="post" class="row g-3 g-sm-4 needs-validation" novalidate>
                            @csrf
                            <div class="col-sm-6">
                                <label for="name" class="form-label">Full name</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required />
                                    <div class="invalid-feedback">Please enter your full name!</div>
                                    @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="email" class="form-label">Email</label>
                                <div class="position-relative">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required />
                                    <div class="invalid-feedback">Please enter your email address!</div>
                                    @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            {{-- Thêm trường Phone/Address (Dựa trên migration) --}}
                            <div class="col-sm-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" />
                            </div>
                            <div class="col-sm-6">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address) }}" />
                            </div>

                            <div class="col-12">
                                <div class="d-flex gap-3 pt-2 pt-sm-0">
                                    <button type="submit" class="btn btn-primary">Update profile</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="border-bottom py-4">
                        <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
                            <div class="d-flex align-items-center gap-3 me-4">
                                <h2 class="h6 mb-0">Change Password</h2>
                            </div>
                        </div>
                        <form action="{{ route('user.change-password') }}" method="post" class="row g-3 g-sm-4 needs-validation" novalidate>
                            @csrf
                            <div class="col-sm-6">
                                <label for="current-password" class="form-label">Current password</label>
                                <div class="password-toggle">
                                    <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="current-password" name="old_password" placeholder="Enter your current password" required />
                                    <label class="password-toggle-button">
                                        <input type="checkbox" class="btn-check" />
                                    </label>
                                    @error('old_password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="new-password" class="form-label">New password</label>
                                <div class="password-toggle">
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new-password" name="new_password" placeholder="Enter new password" required />
                                    <label class="password-toggle-button">
                                        <input type="checkbox" class="btn-check" />
                                    </label>
                                    @error('new_password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex gap-3 pt-2 pt-sm-0">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="pt-3 mt-2 mt-sm-3">
                        <h2 class="h6">Delete Account</h2>
                        <p class="fs-sm">When you delete your account, your public profile will be disabled immediately. If you change your mind before the 14-day period is over, please log in using your email and password, and we will send you a link to reactivate your account.</p>
                        <a class="text-danger fs-sm fw-medium" href="#">Confirm delete account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<button type="button" class="fixed-bottom z-sticky w-100 btn btn-lg btn-dark border-0 border-top border-light border-opacity-10 rounded-0 pb-4 d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#accountSidebar" data-bs-theme="light">
    <i class="ci-sidebar fs-base me-2"></i> Account Management
</button>
@endsection