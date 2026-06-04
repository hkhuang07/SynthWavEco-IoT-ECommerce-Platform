@extends('layouts.frontend')
@section('title', $title ?? 'Search Results')

@section('content')
<div class="container py-4 py-lg-5">
    
    {{-- Breadcrumb: Home > Search > Keyword --}}
    <nav class="mb-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Search: "{{ $keyword }}"</li>
        </ol>
    </nav>

    @if(isset($product))
    {{-- VÙNG 1: HIỂN THỊ CHI TIẾT SẢN PHẨM KHỚP NHẤT --}}
    <div class="alert alert-info border-0 shadow-sm mb-4">
        <i class="fas fa-check-circle me-2"></i> Best match found for your search.
    </div>

    <div class="row">
        {{-- Product Image Gallery --}}
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="card p-3 shadow-sm border-0">
                @if($avatar)
                    <img src="{{ asset('storage/'.$avatar->url) }}" 
                         alt="{{ $product->name }}" 
                         class="img-fluid rounded" 
                         style="max-height: 500px; object-fit: contain;">
                @else
                    <div class="text-center py-5 bg-light rounded"><i class="fas fa-image fa-3x text-muted"></i></div>
                @endif
                
                <div class="row mt-3 g-2">
                    @foreach($product->images->where('is_avatar', false)->take(3) as $image)
                        <div class="col-4">
                            <img src="{{ asset('storage/'.$image->url) }}" class="img-thumbnail" alt="Gallery">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Product Info --}}
        <div class="col-lg-6">
            <h1 class="h3 mb-3 fw-bold text-primary">{{ $product->name }}</h1>
            
            <div class="d-flex align-items-center mb-3">
                <span class="h2 text-dark me-3">${{ number_format($product->price, 2) }}</span>
                <span class="badge {{ $product->stock_quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                    {{ $product->stock_quantity > 0 ? 'In Stock ('.$product->stock_quantity.')' : 'Out of Stock' }}
                </span>
            </div>

            <p class="text-muted mb-4">{{ Str::limit($product->description, 300) }}</p>

            {{-- Specs --}}
            <h6 class="mb-2 fw-bold text-uppercase small">Technical Specs:</h6>
            @if($product->details)
            <ul class="list-unstyled small text-muted border-start border-4 border-info ps-3">
                <li><i class="fas fa-microchip me-2"></i>CPU: {{ $product->details->cpu ?? 'N/A' }}</li>
                <li><i class="fas fa-memory me-2"></i>Memory: {{ $product->details->memory ?? 'N/A' }}</li>
                <li><i class="fas fa-bolt me-2"></i>Power: {{ $product->details->power_specs ?? 'N/A' }}</li>
                <li><i class="fas fa-industry me-2"></i>Manufacturer: {{ $product->manufacturer->name ?? 'N/A' }}</li>
            </ul>
            @endif

            <div class="mt-4">
                <a href="{{ route('frontend.shoppingcard.add', ['productname_slug' => $product->slug]) }}" class="btn btn-lg btn-primary rounded-pill px-5 shadow">
                    <i class="fas fa-cart-plus me-2"></i> Add to Cart
                </a>
            </div>
        </div>
    </div>
    
    <hr class="my-5">

    {{-- VÙNG 2: CÁC SẢN PHẨM KHÁC CŨNG LIÊN QUAN ĐẾN TỪ KHÓA --}}
    @if($relatedProducts->count() > 0)
    <div class="related-section mt-5">
        <h4 class="mb-4 fw-bold"><i class="fas fa-search-plus me-2 text-warning"></i>Other Related Results</h4>
        <div class="row row-cols-2 row-cols-md-4 row-cols-lg-4 g-4">
            @foreach($relatedProducts as $related)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm hover-top transition">
                    <a href="{{ route('frontend.products.product_category_details', ['categoryname_slug' => $related->category->slug, 'productname_slug' => $related->slug]) }}">
                        @php $relAvatar = $related->avatar ?? $related->images->where('is_avatar', true)->first(); @endphp
                        <img src="{{ asset('storage/'. ($relAvatar->url ?? 'default.png')) }}" 
                             class="card-img-top p-3" alt="{{ $related->name }}" style="height: 180px; object-fit: contain;">
                    </a>
                    <div class="card-body text-center p-3">
                        <h6 class="card-title mb-1 small fw-bold text-dark">{{ Str::limit($related->name, 40) }}</h6>
                        <p class="text-primary fw-bold mb-0">${{ number_format($related->price, 2) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @else
    {{-- TRƯỜNG HỢP KHÔNG TÌM THẤY --}}
    <div class="text-center py-5">
        <i class="fas fa-search-minus fa-4x text-muted mb-4 opacity-25"></i>
        <h2 class="h4 text-muted">We couldn't find any products matching "{{ $keyword }}"</h2>
        <p class="text-muted mb-4">Please try again with different keywords or browse our categories.</p>
        <a href="{{ route('frontend.home') }}" class="btn btn-primary rounded-pill">Return to Home</a>
    </div>
    @endif
</div>

<style>
    .hover-top:hover { transform: translateY(-5px); transition: 0.3s; }
    .transition { transition: all 0.3s ease; }
</style>
@endsection