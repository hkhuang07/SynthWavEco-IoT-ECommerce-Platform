@extends('layouts.frontend')
@section('title', 'Order Checkout')
@section('content')
<main class="content-wrapper">
    <nav class="container pt-3 my-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home Page</a></li>
            <li class="breadcrumb-item"><a href="{{ route('frontend.shoppingcard') }}">Shopping Cart</a></li>
            <li class="breadcrumb-item active">Order Checkout</li>
        </ol>
    </nav>
    <div class="container mb-3">
        <div class="row pt-1 pt-sm-3 pt-lg-4 pb-2">
            <div class="col-lg-8 col-xl-7 position-relative z-2 mb-4 mb-lg-0">
                
                <form action="{{ route('user.place-order') }}" method="post" class="needs-validation" novalidate id="checkout-form">
                    @csrf
                    
                    <div class="d-flex align-items-start">
                        <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle fs-sm fw-semibold lh-1 flex-shrink-0" style="width:2rem; height:2rem; margin-top:-.125rem">1</div>
                        <div class="w-100 ps-3 ps-md-4">
                            <h1 class="h5 mb-md-4">Shipping Information</h1>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{ Auth::user()->name ?? '' }}" readonly />
                            </div>
                            <div class="mb-3">
                                <label for="contact_phone" class="form-label">Contact Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg @error('contact_phone') is-invalid @enderror" id="contact_phone" name="contact_phone" required />
                                @error('contact_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">Shipping Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg @error('shipping_address') is-invalid @enderror" id="shipping_address" name="shipping_address" required />
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            </div>
                    </div>
                    
                    <div class="d-flex align-items-start pt-3">
                        <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle fs-sm fw-semibold lh-1 flex-shrink-0" style="width:2rem; height:2rem; margin-top:-.125rem">2</div>
                        <div class="w-100 ps-3 ps-md-4">
                            <h2 class="h5 mb-0">Payment Information</h2>
                            <div class="mb-4" id="paymentMethod" role="list">
                                <div class="mt-4">
                                    <div class="form-check mb-0" role="listitem">
                                        <label class="form-check-label w-100 text-dark-emphasis fw-semibold">
                                            <input type="radio" class="form-check-input fs-base me-2 me-sm-3" name="payment_method" value="Cash on Delivery" checked />
                                            Cash on Delivery
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="form-check mb-0" role="listitem">
                                        <label class="form-check-label d-flex align-items-center text-dark-emphasis fw-semibold">
                                            <input type="radio" class="form-check-input fs-base me-2 me-sm-3" name="payment_method" value="Credit Card" />
                                            Credit or Debit Card
                                            <span class="d-none d-sm-flex gap-2 ms-3">
                                                <img src="{{ asset('public/assets/img/payment-methods/amex.svg') }}" class="d-block bg-info rounded-1" width="36" alt="Amex" />
                                                <img src="{{ asset('public/assets/img/payment-methods/visa-light-mode.svg') }}" class="d-none-dark" width="36" alt="Visa" /><img src="{{ asset('public/assets/img/payment-methods/visa-dark-mode.svg') }}" class="d-none d-block-dark" width="36" alt="Visa" />
                                                <img src="{{ asset('public/assets/img/payment-methods/mastercard.svg') }}" width="36" alt="Mastercard" />
                                                <img src="{{ asset('public/assets/img/payment-methods/maestro.svg') }}" width="36" alt="Maestro" />
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="form-check mb-0" role="listitem">
                                        <label class="form-check-label d-flex align-items-center text-dark-emphasis fw-semibold">
                                            <input type="radio" class="form-check-input fs-base me-2 me-sm-3" name="payment_method" value="PayPal" />
                                            PayPal
                                            <img src="{{ asset('public/assets/img/payment-methods/paypal-icon.svg') }}" class="ms-3" width="16" alt="PayPal" />
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="form-check mb-0" role="listitem">
                                        <label class="form-check-label d-flex align-items-center text-dark-emphasis fw-semibold">
                                            <input type="radio" class="form-check-input fs-base me-2 me-sm-3" name="payment_method" value="Google Pay" />
                                            Google Pay
                                            <img src="{{ asset('public/assets/img/payment-methods/google-icon.svg') }}" class="ms-3" width="20" alt="Google Pay" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-check mb-lg-4">
                                <input type="checkbox" class="form-check-input" id="accept-terms" name="accept-terms" checked required>
                                <label for="accept-terms" class="form-check-label nav align-items-center">
                                    I agree to the
                                    <a class="nav-link text-decoration-underline fw-normal ms-1 p-0" href="#">Terms and Conditions</a>
                                </label>
                            </div>
                            
                            <button type="submit" class="btn btn-lg btn-primary w-100 d-none d-lg-flex mt-4">
                                Pay ${{ Cart::total() ?? 0 }}
                            </button>
                        </div>
                    </div>
                </form>
                </div>
            
            <aside class="col-lg-4 offset-xl-1" style="margin-top:-100px">
                <div class="position-sticky top-0" style="padding-top:100px">
                    <div class="bg-body-tertiary rounded-5 p-4 mb-3">
                        <div class="p-sm-2 p-lg-0 p-xl-2">
                            <div class="border-bottom pb-4 mb-4">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <h5 class="mb-0">Order Summary</h5>
                                </div>
                                <a class="d-flex align-items-center gap-2 text-decoration-none" href="#orderPreview" data-bs-toggle="offcanvas">
                                    @foreach(Cart::content() as $value)
                                    <div class="ratio ratio-1x1" style="max-width:64px">
                                        <img src="{{ asset('storage/app/private/' . $value->options->image ) }}" class="d-block p-1" alt="{{ $value->name }}" />
                                    </div>
                                    @endforeach<i class="ci-chevron-right text-body fs-xl p-0 ms-auto"></i>
                                </a>
                            </div>
                            <ul class="list-unstyled fs-sm gap-3 mb-0">
                                <li class="d-flex justify-content-between">
                                    Subtotal ({{ Cart::count() ?? 0 }} products):
                                    <span class="text-dark-emphasis fw-medium">${{ number_format(Cart::priceTotal(), 2) }}</span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    Discount:
                                    <span class="text-danger fw-medium">-${{ number_format(Cart::discount(), 2) }}</span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    VAT (10%):
                                    <span class="text-dark-emphasis fw-medium">${{ number_format(Cart::tax(), 2) }}</span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    Shipping Fee:
                                    <span class="text-dark-emphasis fw-medium">$0.00</span>
                                </li>
                            </ul>
                            <div class="border-top pt-4 mt-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="fs-sm">Total:</span>
                                    <span class="h5 mb-0">${{ Cart::total() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
    <div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="orderPreview" tabindex="-1" style="width:500px">
        </div>
</main>
@endsection

@section('floating-button')
<div class="fixed-bottom z-sticky w-100 py-2 px-3 bg-body border-top shadow d-lg-none">
    <button type="submit" form="checkout-form" class="btn btn-lg btn-primary w-100">Pay ${{ Cart::total() ?? 0 }}</button>
</div>
@endsection