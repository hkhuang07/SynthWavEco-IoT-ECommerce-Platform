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
                    
                    {{-- Section 1: Shipping Information --}}
                    <div class="d-flex align-items-start mb-4">
                        <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle fs-sm fw-semibold lh-1 flex-shrink-0" style="width:2rem; height:2rem;">1</div>
                        <div class="w-100 ps-3 ps-md-4">
                            <h1 class="h5 mb-4">Shipping Information</h1>
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control form-control-lg" id="name" value="{{ Auth::user()->name ?? '' }}" readonly />
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <label for="contact_phone" class="form-label">Contact Phone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg @error('contact_phone') is-invalid @enderror" id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}" required />
                                </div>
                                <div class="col-sm-6">
                                    <label for="shipping_address" class="form-label">Shipping Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg @error('shipping_address') is-invalid @enderror" id="shipping_address" name="shipping_address" value="{{ old('shipping_address') }}" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Order Notes (Optional)</label>
                                <textarea class="form-control form-control-lg" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Shipping Method (NEW - Professional Cards) --}}
                    <div class="d-flex align-items-start mb-4 pt-3">
                        <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle fs-sm fw-semibold lh-1 flex-shrink-0" style="width:2rem; height:2rem;">2</div>
                        <div class="w-100 ps-3 ps-md-4">
                            <h2 class="h5 mb-4">Shipping Method</h2>
                            <div class="row g-3">
                                <div class="col-sm-4">
                                    <input type="radio" class="btn-check" name="shipping_type" id="ship-free" value="free" data-rate="0" checked>
                                    <label class="btn btn-outline-secondary d-block w-100 h-100 p-3 text-start shadow-sm" for="ship-free">
                                        <span class="d-block fw-bold mb-1">Free Shipping</span>
                                        <span class="d-block fs-xs text-body-secondary mb-2">3-5 days</span>
                                        <span class="d-block fw-medium text-success">$0.00</span>
                                    </label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="radio" class="btn-check" name="shipping_type" id="ship-fast" value="fast" data-rate="0.1">
                                    <label class="btn btn-outline-secondary d-block w-100 h-100 p-3 text-start shadow-sm" for="ship-fast">
                                        <span class="d-block fw-bold mb-1">Fast Shipping</span>
                                        <span class="d-block fs-xs text-body-secondary mb-2">1-2 days</span>
                                        <span class="d-block fw-medium text-dark">+10% fee</span>
                                    </label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="radio" class="btn-check" name="shipping_type" id="ship-express" value="express" data-rate="0.25">
                                    <label class="btn btn-outline-secondary d-block w-100 h-100 p-3 text-start shadow-sm" for="ship-express">
                                        <span class="d-block fw-bold mb-1">Express Shipping</span>
                                        <span class="d-block fs-xs text-body-secondary mb-2">Within 24h</span>
                                        <span class="d-block fw-medium text-dark">+25% fee</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Section 3: Payment Information --}}
                    <div class="d-flex align-items-start pt-3">
                        <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle fs-sm fw-semibold lh-1 flex-shrink-0" style="width:2rem; height:2rem; margin-top:-.125rem">2</div>
                        <div class="w-100 ps-3 ps-md-4">
                            <h2 class="h5 mb-0">Payment Method</h2>
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
                            
                            <button type="submit" id="btn-total-display" class="btn btn-lg btn-primary w-100 d-none d-lg-flex mt-4">
                                Pay ${{ Cart::total() ?? 0 }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            {{-- Order Summary Sidebar --}}
            <aside class="col-lg-4 offset-xl-1" style="margin-top:-100px">
                <div class="position-sticky top-0" style="padding-top:100px">
                    <div class="bg-body-tertiary rounded-5 p-4 mb-3 shadow-sm border">
                        <div class="p-sm-2 p-lg-0 p-xl-2">
                            <h5 class="mb-4">Order Summary</h5>
                            <ul class="list-unstyled fs-sm gap-3 mb-0">
                                <li class="d-flex justify-content-between">
                                    <span>Subtotal ({{ Cart::count() }} items):</span>
                                    <span class="text-dark-emphasis fw-medium">${{ number_format(Cart::priceTotal(), 2) }}</span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    <span>VAT (10%):</span>
                                    <span class="text-dark-emphasis fw-medium">${{ number_format(Cart::tax(), 2) }}</span>
                                </li>
                                <li class="d-flex justify-content-between border-bottom pb-3">
                                    <span>Shipping Fee:</span>
                                    <span class="text-dark-emphasis fw-medium" id="summary-shipping-fee">$0.00</span>
                                </li>
                            </ul>
                            <div class="pt-3 mt-3">
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="fw-bold fs-base">Total Amount:</span>
                                    <span class="h4 mb-0 fw-bold text-primary" id="summary-total-amount">${{ Cart::total() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lấy số liệu gốc từ Cart 
    const subtotal = parseFloat("{{ str_replace(',', '', Cart::priceTotal()) }}");
    const tax = parseFloat("{{ str_replace(',', '', Cart::tax()) }}");
    
    const shippingRadios = document.querySelectorAll('input[name="shipping_type"]');
    const shippingDisplay = document.getElementById('summary-shipping-fee');
    const totalDisplay = document.getElementById('summary-total-amount');
    const btnTotalDisplay = document.getElementById('btn-total-display');

    function updatePrice() {
        let rate = 0;
        shippingRadios.forEach(radio => {
            if (radio.checked) rate = parseFloat(radio.dataset.rate);
        });

        const shippingFee = subtotal * rate;
        const finalTotal = subtotal + tax + shippingFee;

        // Hiển thị định dạng tiền tệ
        const formatCurrency = (val) => '$' + val.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});

        shippingDisplay.innerText = formatCurrency(shippingFee);
        totalDisplay.innerText = formatCurrency(finalTotal);
        if(btnTotalDisplay) btnTotalDisplay.innerText = formatCurrency(finalTotal);
    }

    shippingRadios.forEach(radio => radio.addEventListener('change', updatePrice));
    updatePrice(); // Chạy lần đầu
});
</script>
@endsection