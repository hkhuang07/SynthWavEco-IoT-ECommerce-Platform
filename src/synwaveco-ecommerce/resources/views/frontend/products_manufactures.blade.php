@extends('layouts.frontend')
@section('title', $title ?? 'Products') 

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-3">
            <h5 class="mb-3">Manufacturers</h5>
            
            <div class="d-flex flex-wrap gap-2 mb-4">
                
                <a href="{{ route('frontend.products_manufactures') }}" 
                   class="btn btn-sm {{ !isset($manufacturer) ? 'btn-primary' : 'btn-outline-secondary' }}">
                    All Products
                </a>

                @foreach($manufacturers as $man)
                    @php
                        $isActive = (isset($manufacturer) && $manufacturer->id == $man->id);
                    @endphp
                    
                    <a href="{{ route('frontend.products.manufacturers', ['manufacturer_slug' => $man->slug]) }}" 
                       class="btn btn-sm {{ $isActive ? 'btn-primary' : 'btn-outline-secondary' }}">
                        {{ $man->name }}
                    </a>
                @endforeach
            </div>
            
        </div>
        
        {{-- Product Grid --}}
        <div class="col-lg-9">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse($products as $product)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        {{-- Thêm đường dẫn tới chi tiết sản phẩm vào hình ảnh --}}
                        <a href="{{ route('frontend.products.product_manufacturer_details', ['manufacturer_slug' => $product->manufacturer->slug, 'productname_slug' => $product->slug]) }}">
                            <img src="{{ asset('storage/app/private/'. ($product->avatar->url ?? 'default.png')) }}" class="card-img-top" alt="{{ $product->name }}">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">${{ number_format($product->price, 2) }}</p>
                            <a href="{{ route('frontend.products.product_manufacturer_details', ['manufacturer_slug' => $product->manufacturer->slug, 'productname_slug' => $product->slug]) }}" class="btn btn-primary btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col">
                    <p>No products found in this category.</p>
                </div>
                @endforelse
            </div>
        </div>
        
    </div>
</div>
@endsection