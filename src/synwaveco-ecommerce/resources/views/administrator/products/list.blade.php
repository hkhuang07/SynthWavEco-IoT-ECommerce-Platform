@extends('layouts.app')

@section('title', 'Product Management')

@section('styles')
<link rel="stylesheet" href="{{ asset('public/css/list.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/form.css') }}">
<link rel="stylesheet" href="{{ asset('public/vendor/font-awesome/css/all.min.css') }}" />
@endsection

@section('content')
<div class="item-management-container">
    <div class="item-header">
        <div class="container mx-auto px-4">
            <div class="header-content">
                <div class="header-left">
                    <h1 class="page-title">
                        <i class="fas fa-box"></i> Product Management
                    </h1>
                    <p class="page-subtitle">Manage your IoT agricultural products</p>
                </div>
                <div class="header-right">
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="fas fa-plus"></i> Add New Product
                    </button>
                    <button type="button" class="btn-import" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fas fa-file-import"></i> Import Product
                    </button>
                    <a href="{{ route('administrator.products.export') }}" class="btn-export">
                        <i class="fas fa-file-export"></i> Export Product
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading products...</p>
        </div>

        <div class="mb-4 d-flex justify-content-end">
            {{ $products->links('vendor.pagination.greentech') }}
        </div>

        <div class="items-grid" id="productsGrid">
            @forelse($products as $product)
            @php
                $productData = $product->load(['details', 'images', 'category', 'manufacturer']);
                $avatarImage = $product->images->where('is_avatar', true)->first();
            @endphp

            <div class="item-card" data-product-id="{{ $product->id }}">
                <div class="item-image-container">
                    @if($avatarImage && $avatarImage->url)
                        <img src="{{ asset('storage/app/private/'. $avatarImage->url) }}"
                             alt="{{ $product->name }}" class="item-image" loading="lazy">
                    @else
                        <div class="item-image-placeholder"><i class="fas fa-microchip"></i></div>
                    @endif

                    <div class="status-badge {{ $product->stock_quantity > 0 ? '' : 'out-of-stock' }}">
                        <i class="fas {{ $product->stock_quantity > 0 ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                        {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                    </div>

                    <div class="action-overlay">
                        <div class="action-buttons">
                            {{-- Gọi Wrapper Update --}}
                            <button type="button" class="action-btn edit-btn" title="Edit Product"
                                onclick="openUpdateProductModalWrapper(event, '{{ $product->id }}', {{ json_encode($productData) }})">
                                <i class="fas fa-edit"></i> <span>Edit</span>
                            </button>
                            {{-- Gọi Wrapper Delete --}}
                            <button type="button" class="action-btn delete-btn" title="Delete Product"
                                onclick="openDeleteProductModalWrapper(event, '{{ $product->id }}', {{ json_encode($productData) }})">
                                <i class="fas fa-trash-alt"></i> <span>Delete</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="item-content" onclick="openProductDetailsModalWrapper(event, {{ json_encode($productData) }})">
                    <h3 class="item-title" title="{{ $product->name }}">{{ $product->name }}</h3>
                    <div class="item-info">
                        <div class="info-item">
                            <i class="fas fa-dollar-sign"></i> <span class="info-label">Price:</span>
                            <span class="info-value price-value">${{ number_format($product->price, 2) }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-cubes"></i> <span class="info-label">Stock:</span>
                            <span class="info-value">{{ $product->stock_quantity }}</span>
                        </div>
                    </div>
                    <div class="item-footer">
                        <div class="created-date"><i class="fas fa-seedling"></i> Product #{{ $product->id }}</div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state text-center py-5">
                <i class="fas fa-box fa-4x text-muted mb-3"></i>
                <h3>No Products Found</h3>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">Create Product</button>
            </div>
            @endforelse
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $products->links('vendor.pagination.greentech') }}
        </div>

    </div>
</div>

{{-- Các Modal nằm ngoài container --}}
@include('administrator.products.add')
@include('administrator.products.update')
@include('administrator.products.delete')
@include('administrator.products.details')

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hiệu ứng Hover card
        document.querySelectorAll('.item-card').forEach(card => {
            card.addEventListener('mouseenter', function() { this.style.transform = 'translateY(-8px) scale(1.02)'; });
            card.addEventListener('mouseleave', function() { this.style.transform = 'translateY(0) scale(1)'; });
        });

        // Phím tắt thêm mới (Ctrl + N)
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
                e.preventDefault();
                new bootstrap.Modal(document.getElementById('addProductModal')).show();
            }
        });
        
        // Log kiểm tra sự tồn tại của các hàm
        console.log('📋 Kiểm tra các hàm Modal:', {
            updateProduct: typeof openUpdateModalFunction === 'function', // ĐÃ SỬA TÊN HÀM
            deleteProduct: typeof showDeleteProductModal === 'function',
            detailsProduct: typeof openProductDetailsModal === 'function'
        });
    });

    /**
     * Đồng bộ hóa gọi Modal Update
     */
    function openUpdateProductModalWrapper(event, productId, productData) {
        if (event) event.stopPropagation();
        
        // SỬA: Đổi openUpdateProductModalFunction thành openUpdateModalFunction
        if (typeof openUpdateModalFunction === "function") {
            console.log('🔄 Đang mở modal cập nhật cho sản phẩm:', productId);
            openUpdateModalFunction(productId, productData);
        } else {
            console.error('❌ Lỗi: Hàm openUpdateModalFunction chưa được khai báo trong update.blade.php!');
            alert('Lỗi hệ thống: Không thể mở form cập nhật.');
        }
    }

    /**
     * Đồng bộ hóa gọi Modal Delete
     */
    function openDeleteProductModalWrapper(event, productId, productData) {
        if (event) event.stopPropagation();
        if (typeof showDeleteProductModal === "function") {
            showDeleteProductModal(productId, productData);
        } else {
            console.error('❌ Lỗi: Hàm showDeleteProductModal chưa được khai báo!');
        }
    }

    /**
     * Đồng bộ họa gọi Modal Details
     */
    function openProductDetailsModalWrapper(event, productData) {
        if (event) event.stopPropagation();
        if (typeof openProductDetailsModal === "function") {
            openProductDetailsModal(productData);
        }
    }
</script>

{{-- Tự động mở modal khi có lỗi validation --}}
@if ($errors->update->any())
<script>
    document.addEventListener('DOMContentLoaded', () => { 
        new bootstrap.Modal(document.getElementById('updateProductModal')).show(); 
    });
</script>
@endif

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => { 
        console.log('✅ Thành công:', "{{ session('success') }}"); 
    });
</script>
@endif
@endsection