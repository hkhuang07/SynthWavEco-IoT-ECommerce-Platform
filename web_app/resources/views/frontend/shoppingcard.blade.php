@extends('layouts.frontend')
@section('title', 'Shopping Cart')
@section('content')
<main class="content-wrapper">
    <nav class="container pt-3 my-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home Page</a></li>
            <li class="breadcrumb-item"><a href="{{ route('frontend.products') }}">Products</a></li>
            <li class="breadcrumb-item active">Shopping Cart</li>
        </ol>
    </nav>
    <section class="container mb-3">
        <h1 class="h3 mb-2">Shopping Cart</h1>
        <div class="row">
            <div class="col-lg-8">
                <div class="pe-lg-2 pe-xl-3 me-xl-3">
                    <table class="table position-relative z-2 mb-4">
                        <thead>
                            <tr>
                                <th scope="col" class="fs-sm fw-normal py-3 ps-0"><span class="text-body">Product</span></th>
                                <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-xl-table-cell"><span class="text-body">Price</span></th>
                                <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-md-table-cell"><span class="text-body">Quantity</span></th>
                                <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-md-table-cell"><span class="text-body">Subtotal</span></th>
                                <th scope="col" class="py-0 px-0">
                                    <div class="nav justify-content-end">
                                        <button type="button" class="nav-link d-inline-block text-decoration-underline text-nowrap py-3 px-0">Clear Cart</button>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @foreach(Cart::content() as $value)
                            <tr>
                                <td class="py-3 ps-0">
                                    <div class="d-flex align-items-center">
                                        <a class="flex-shrink-0" href="#">
                                            <img src="{{ asset('storage/app/private/' . $value->options->image ) }}" width="110" alt="{{ $value->name }}" />
                                        </a>
                                        <div class="w-100 min-w-0 ps-2 ps-xl-3">
                                            <h5 class="d-flex animate-underline mb-2">
                                                <a class="d-block fs-sm fw-medium text-truncate animate-target" href="#">{{ $value->name }}</a>
                                            </h5>
                                            <ul class="list-unstyled gap-1 fs-xs mb-0">
                                                <li class="d-xl-none">
                                                    <span class="text-body-secondary">Price:</span>
                                                    <span class="text-dark-emphasis fw-medium">${{ number_format($value->price, 0, ',', '.') }}</span>
                                                </li>
                                            </ul>
                                            <div class="count-input rounded-2 d-md-none mt-3">
                                                <a href="{{ route('frontend.shoppingcard.decrease', ['row_id' => $value->rowId]) }}" class="btn btn-sm btn-icon" data-decrement>
                                                    <i class="ci-minus"></i>
                                                </a>
                                                <input type="number" class="form-control form-control-sm" id="qty" name="qty" min="1" value="{{ $value->qty }}" readonly />
                                                <a href="{{ route('frontend.shoppingcard.increase', ['row_id' => $value->rowId]) }}" class="btn btn-sm btn-icon" data-increment>
                                                    <i class="ci-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="h6 py-3 d-none d-xl-table-cell">${{ number_format($value->price, 0, ',', '.') }}</td>
                                <td class="py-3 d-none d-md-table-cell">
                                    <div class="count-input">
                                        <a href="{{ route('frontend.shoppingcard.decrease', ['row_id' => $value->rowId]) }}" class="btn btn-icon" data-decrement>
                                            <i class="ci-minus"></i>
                                        </a>
                                        <input type="number" class="form-control" id="qty" name="qty" min="1" value="{{ $value->qty }}" readonly />
                                        <a href="{{ route('frontend.shoppingcard.increase', ['row_id' => $value->rowId]) }}" class="btn btn-icon" data-increment>
                                            <i class="ci-plus"></i>
                                        </a>
                                    </div>
                                </td>
                                <td class="h6 py-3 d-none d-md-table-cell">${{ number_format($value->price * $value->qty, 0, ',', '.') }}</td>
                                <td class="text-end py-3 px-0">
                                    <a href="{{ route('frontend.shoppingcard.delete', ['row_id' => $value->rowId]) }}" class="btn-close fs-sm" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-sm" data-bs-title="Remove"></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="nav position-relative z-2 mb-4 mb-lg-0">
                        <a class="nav-link animate-underline px-0" href="{{ route('frontend.home') }}">
                            <i class="ci-chevron-left fs-lg me-1"></i>
                            <span class="animate-target">Continue shopping</span>
                        </a>
                    </div>
                </div>
            </div>
            <aside class="col-lg-4" style="margin-top:-100px">
                <div class="position-sticky top-0" style="padding-top:100px">
                    <div class="bg-body-tertiary rounded-5 p-4 mb-3">
                        <div class="p-sm-2 p-lg-0 p-xl-2">
                            <h5 class="border-bottom pb-4 mb-4">Order Summary</h5>
                            <ul class="list-unstyled fs-sm gap-3 mb-0">
                                <li class="d-flex justify-content-between">
                                    Total Price ({{ Cart::count() ?? 0 }} products):
                                    <span class="text-dark-emphasis fw-medium">${{ Cart::priceTotal() }}</span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    Discount:
                                    <span class="text-danger fw-medium">-${{ Cart::discount() }}</span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    Tax (VAT):
                                    <span class="text-dark-emphasis fw-medium">${{ Cart::tax() }}</span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    Shipping Fee:
                                    <span class="text-dark-emphasis fw-medium">Calculated at checkout</span>
                                </li>
                            </ul>
                            <div class="border-top pt-4 mt-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="fs-sm">Estimated Total:</span>
                                    <span class="h5 mb-0">${{ Cart::total() }}</span>
                                </div>
                                <a class="btn btn-lg btn-primary w-100" href="{{ route('user.place-order') }}">
                                    Proceed to checkout
                                    <i class="ci-chevron-right fs-lg ms-1 me-n1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</main>
@endsection