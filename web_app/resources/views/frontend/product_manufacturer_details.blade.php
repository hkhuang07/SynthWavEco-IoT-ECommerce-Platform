@extends('layouts.frontend')
@section('title', $title ?? 'Product Details')

@section('content')
<div class="container py-4 py-lg-5">
    
    {{-- Breadcrumb --}}
    <nav class="mb-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('frontend.products.manufacturer', ['categoryname_slug' => $category->slug]) }}">
                    {{ $category->name }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        {{-- Product Image Gallery (Col-lg-6) --}}
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="card p-3 shadow-sm">
                @if($avatar)
                    <img src="{{ asset('storage/app/private/'.$avatar->url) }}" 
                         alt="{{ $product->name }}" 
                         class="img-fluid rounded" 
                         style="max-height: 500px; object-fit: contain;">
                @else
                    <div class="text-center py-5 bg-light rounded">No Image Available</div>
                @endif
                
                {{-- Thêm Gallery ảnh nhỏ nếu có nhiều ảnh --}}
                <div class="row mt-3 g-2">
                    @foreach($product->images->where('is_avatar', false)->take(3) as $image)
                        <div class="col-4">
                            <img src="{{ asset('storage/app/private/'.$image->url) }}" 
                                 class="img-thumbnail" 
                                 alt="Gallery Image">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Product Details and Purchase Options (Col-lg-6) --}}
        <div class="col-lg-6">
            <h1 class="h3 mb-3">{{ $product->name }}</h1>
            
            <div class="d-flex align-items-center mb-3">
                <span class="h2 text-primary me-3">${{ number_format($product->price, 2) }}</span>
                <span class="badge {{ $product->stock_quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                    {{ $product->stock_quantity > 0 ? 'In Stock ('.$product->stock_quantity.')' : 'Out of Stock' }}
                </span>
            </div>

            <p class="text-muted mb-4">{{ Str::limit($product->description, 200) }}</p>

            {{-- Technical Details --}}
            <h6 class="mb-2">Technical Specs:</h6>
            @if($product->details)
            <ul class="list-unstyled small text-muted">
                <li><i class="ci-cpu me-2"></i>CPU: {{ $product->details->cpu ?? 'N/A' }}</li>
                <li><i class="ci-memory me-2"></i>Memory: {{ $product->details->memory ?? 'N/A' }}</li>
                <li><i class="ci-power me-2"></i>Power: {{ $product->details->power_specs ?? 'N/A' }}</li>
                <li><i class="ci-industry me-2"></i>Manufacturer: {{ $product->manufacturer->name ?? 'N/A' }}</li>
            </ul>
            @endif

            {{-- Add to Cart Form --}}
            <form action="{{ route('frontend.shoppingcard.add', ['productname_slug' => $product->slug]) }}" method="GET" class="mt-4">
                <div class="d-flex align-items-center mb-3">
                    <label for="quantity" class="form-label me-3 mb-0">Quantity:</label>
                    <input type="number" 
                           id="quantity" 
                           name="qty" 
                           class="form-control" 
                           value="1" 
                           min="1" 
                           max="{{ $product->stock_quantity > 0 ? $product->stock_quantity : 1 }}"
                           style="width: 80px;">
                </div>

                <button type="submit" 
                        class="btn btn-lg btn-primary" 
                        @if($product->stock_quantity == 0) disabled @endif>
                    <i class="ci-shopping-bag me-2"></i> Add to Cart
                </button>
            </form>
        </div>
    </div>
    
    <hr class="my-5">

    {{-- Full Description Tab (Optional) --}}
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Full Description</h4>
            <div class="text-muted">
                {{ $product->description }}
            </div>
        </div>
    </div>

    {{-- Related Products Section --}}
    @if($relatedProducts->count() > 0)
    <h4 class="mt-5 mb-4">Related Products</h4>
    <div class="row row-cols-2 row-cols-md-4 g-4">
        @foreach($relatedProducts as $related)
        <div class="col">
            <div class="card h-100 shadow-sm">
                <a href="{{ route('frontend.products.details', ['categoryname_slug' => $related->category->slug, 'productname_slug' => $related->slug]) }}">
                    <img src="{{ asset('storage/app/private/'. ($related->avatar->url ?? 'default.png')) }}" class="card-img-top" alt="{{ $related->name }}">
                </a>
                <div class="card-body text-center">
                    <h6 class="card-title mb-1">{{ $related->name }}</h6>
                    <p class="text-primary fw-bold">${{ number_format($related->price, 2) }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection