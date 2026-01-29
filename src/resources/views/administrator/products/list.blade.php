@extends('layouts.app')

@section('title', 'Product Management')

@section('styles')
<link rel="stylesheet" href="{{ asset('public/css/list.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/form.css') }}">
<link rel="stylesheet" href="{{ asset('public/vendor/font-awesome/css/all.min.css') }}" />
@endsection

@section('content')
{{-- 1. Vùng chứa danh sách (Tuyệt đối không để Modal trong này) --}}
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
                            <button type="button" class="action-btn edit-btn" title="Edit Product"
                                onclick="openUpdateProductModalWrapper(event, '{{ $product->id }}', {{ json_encode($productData) }})">
                                <i class="fas fa-edit"></i> <span>Edit</span>
                            </button>
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
    </div>
</div>

{{-- 2. ĐƯA TẤT CẢ MODAL RA NGOÀI CONTAINER ĐỂ TRÁNH LỖI Z-INDEX (Dìm backdrop) --}}
@include('administrator.products.add')
@include('administrator.products.update')
@include('administrator.products.delete')
@include('administrator.products.details')

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('📦 Product list page loaded successfully');
        
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
        
        console.log('📋 Available modal functions:', {
            addProduct: typeof showAddProductModal === 'function',
            updateProduct: typeof openUpdateProductModalFunction === 'function',
            deleteProduct: typeof showDeleteProductModal === 'function',
            detailsProduct: typeof openProductDetailsModal === 'function'
        });
    });

    /**
     * Đồng bộ hóa gọi Modal Update (Product Module)
     */
    function openUpdateProductModalWrapper(event, productId, productData) {
        if (event) event.stopPropagation();
        console.log('🔄 Opening update modal for product:', productId);
        
        if (typeof openUpdateProductModalFunction === "function") {
            openUpdateProductModalFunction(productId, productData);
        } else {
            console.error('❌ Critical Error: openUpdateProductModalFunction is not defined!');
            alert('Lỗi: Hàm mở modal cập nhật chưa được tải. Vui lòng tải lại trang.');
        }
    }

    /**
     * Đồng bộ hóa gọi Modal Delete (Product Module)
     */
    function openDeleteProductModalWrapper(event, productId, productData) {
        if (event) event.stopPropagation();
        console.log('🗑️ Opening delete modal for product:', productId, productData.name);
        
        if (typeof showDeleteProductModal === "function") {
            showDeleteProductModal(productId, productData);
        } else {
            console.error('❌ Critical Error: showDeleteProductModal is not defined in delete.blade.php!');
            alert('Lỗi: Hàm mở modal xóa chưa được tải. Vui lòng tải lại trang.');
        }
    }

    /**
     * Đồng bộ họa gọi Modal Details (Product Module)
     */
    function openProductDetailsModalWrapper(event, productData) {
        if (event) event.stopPropagation();
        console.log('👁️ Opening details modal for product:', productData.name);
        
        if (typeof openProductDetailsModal === "function") {
            openProductDetailsModal(productData);
        } else {
            console.warn('⚠️ Warning: openProductDetailsModal is not defined');
        }
    }
</script>

{{-- Sửa lỗi validation auto-open --}}
@if ($errors->add->any())
<script>document.addEventListener('DOMContentLoaded', () => { 
    console.log('📝 Opening add modal due to validation errors');
    new bootstrap.Modal(document.getElementById('addProductModal')).show(); 
});</script>
@endif

@if ($errors->update->any())
<script>document.addEventListener('DOMContentLoaded', () => { 
    console.log('📝 Opening update modal due to validation errors');
    new bootstrap.Modal(document.getElementById('updateProductModal')).show(); 
});</script>
@endif

{{-- Fix lỗi session('success') --}}
@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => { 
        console.log('✅ Success:', "{{ session('success') }}"); 
    });
</script>
@endif
@endsection