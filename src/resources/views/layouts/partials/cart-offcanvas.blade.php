<div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="shoppingCart" tabindex="-1" style="width:500px">
    <div class="offcanvas-header flex-column align-items-start py-3 pt-lg-4">
        <div class="d-flex align-items-center justify-content-between w-100">
            <h4 class="offcanvas-title" id="shoppingCartLabel">My Shopping Cart ({{ Cart::count() ?? 0 }})</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
    </div>

    @if(Cart::count() > 0)
        <div class="offcanvas-body d-flex flex-column gap-4 pt-2">
            @foreach(Cart::content() as $value)
                <div class="d-flex align-items-center">
                    <a class="flex-sm-shrink-0" href="#" style="width:142px">
                        <div class="ratio bg-body-tertiary rounded overflow-hidden" style="--cz-aspect-ratio:calc(110 / 142 * 100%)">
                            @if(isset($value->options) && isset($value->options['image']))
                                <img src="{{ asset('storage/' . $value->options['image'] ) }}" alt="Product" />
                            @else
                                <div class="bg-dark text-white d-flex align-items-center justify-content-center" style="height:110px;"><i class="fas fa-box"></i></div>
                            @endif
                        </div>
                    </a>
                    <div class="w-100 min-w-0 ps-3">
                        <h5 class="d-flex animate-underline mb-2">
                            <a class="d-block fs-sm fw-medium text-truncate animate-target" href="#">{{ $value->name }}</a>
                        </h5>
                        <div class="d-flex align-items-center justify-content-between gap-1">
                            <div class="h6 mt-1 mb-0">{{ number_format($value->price, 0, ',', '.') }}<small>$</small></div>
                            <a href="{{ route('frontend.shoppingcard.delete', ['row_id' => $value->rowId]) }}" class="btn btn-icon btn-sm flex-shrink-0 fs-sm" data-bs-toggle="tooltip" data-bs-title="Remove from cart">
                                <i class="fas fa-trash fs-base text-danger"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="offcanvas-header flex-column align-items-start border-top pt-3">
            <div class="d-flex align-items-center justify-content-between w-100 mb-3 mb-md-4">
                <span class="text-light-emphasis">Total Price:</span>
                <span class="h6 mb-0 text-info fw-bold">{{ Cart::priceTotal() }}<small>$</small></span>
            </div>
            <a class="btn btn-lg btn-primary w-100 rounded-pill" href="{{ route('frontend.shoppingcard') }}">View My Shopping Cart</a>
        </div>
    @else
        <div class="offcanvas-body text-center d-flex flex-column align-items-center justify-content-center">
            <i class="fas fa-shopping-cart fa-3x text-muted opacity-60 mb-4"></i>
            <h6 class="mb-2">Your cart is currently empty!</h6>
            <p class="fs-sm mb-4 text-muted">Explore our many items and add products to your cart.</p>
            <button type="button" class="btn btn-primary px-4 py-2" data-bs-dismiss="offcanvas">Continue Shopping</button>
        </div>
    @endif
</div>
