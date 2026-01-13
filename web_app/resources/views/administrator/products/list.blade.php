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
                        <i class="fas fa-box"></i>
                        Product Management
                    </h1>
                    <p class="page-subtitle">
                        Manage your IoT agricultural products
                    </p>
                </div>
                <div class="header-right">

                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="fa-light fa-plus"></i>
                        Add New Product
                    </button>
                    <button type="button" class="btn-import" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fa-light fa-file-import"></i>
                        Import Product
                    </button>
                    <a href="{{ route('administrator.products.export') }}" class="btn-export">
                        <i class="fa-light fa-file-export"></i>
                        Export Product
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
            // Tải đầy đủ dữ liệu cho Details và Update/Delete
            $productData = $product->load(['details', 'images', 'category', 'manufacturer']);
            $avatarImage = $product->images->where('is_avatar', true)->first();
            @endphp

            <div class="item-card" data-product-id="{{ $product->id }}">
                <div class="item-image-container">
                    @if($avatarImage && $avatarImage->url && file_exists(storage_path('app/private/' . $avatarImage->url)))
                    <img src="{{ asset('storage/app/private/'. $avatarImage->url) }}"
                        alt="{{ $product->name }}"
                        class="item-image"
                        loading="lazy">
                    @else
                    <div class="item-image-placeholder">
                        <i class="fas fa-microchip"></i>
                    </div>
                    @endif

                    <div class="status-badge {{ $product->stock_quantity > 0 ? '' : 'out-of-stock' }}">
                        <i class="fas {{ $product->stock_quantity > 0 ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                        {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                    </div>

                    <div class="action-overlay">
                        <div class="action-buttons">

                            <button type="button"
                                class="action-btn edit-btn"
                                title="Edit Product"
                                onclick="openUpdateModalWrapper(event, '{{ $product->id }}', {{ json_encode($productData) }})">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button"
                                class="action-btn delete-btn"
                                title="Delete Product"
                                onclick="openDeleteModalWrapper(event, '{{ $product->id }}', {{ json_encode($product->load('images')) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="item-content" onclick="openDetailsModalWrapper(event, {{ json_encode($productData) }})">
                    <h3 class="item-title" title="{{ $product->name }}">
                        {{ $product->name }}
                    </h3>
                    <div class="item-info">
                        <div class="info-item">
                            <i class="fas fa-dollar-sign"></i>
                            <span class="info-label">Price:</span>
                            <span class="info-value price-value">${{ number_format($product->price, 2) }}</span>
                        </div>

                        <div class="info-item">
                            <i class="fas fa-cubes"></i>
                            <span class="info-label">Stock:</span>
                            <span class="info-value">{{ $product->stock_quantity }}</span>
                        </div>

                        @if($product->category)
                        <div class="info-item">
                            <i class="fas fa-tag"></i>
                            <span class="info-label">Category:</span>
                            <span class="info-value">{{ $product->category->name }}</span>
                        </div>
                        @endif

                        @if($product->manufacturer)
                        <div class="info-item">
                            <i class="fas fa-industry"></i>
                            <span class="info-label">Manufacturer:</span>
                            <span class="info-value">{{ $product->manufacturer->name }}</span>
                        </div>
                        @endif
                    </div>

                    @if($product->description)
                    <div class="item-description">
                        {{ Str::limit($product->description, 100) }}
                    </div>
                    @endif

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-seedling"></i>
                            Product #{{ $product->id }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-box empty-icon"></i>
                    <h3 class="empty-title">No Products Found</h3>
                    <p class="empty-text">
                        You haven't added any products yet. Start by creating your first product.
                    </p>
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="fas fa-plus"></i>
                        Create Your First Product
                    </button>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    </div>

@include('administrator.products.add')
@include('administrator.products.update')
@include('administrator.products.delete')
@include('administrator.products.details')

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemCards = document.querySelectorAll('.item-card');

        itemCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
                e.preventDefault();
                const addModal = new bootstrap.Modal(document.getElementById('addProductModal'));
                addModal.show();
            }
        });
    });

    
    // Wrapper cho Update Modal (Gọi hàm openUpdateModalFunction)
    function openUpdateModalWrapper(event, productId, productData) {
        if (event) event.stopPropagation(); 
        openUpdateModalFunction(productId, productData); // Hàm trong update.blade.php
    }

    // Wrapper cho Delete Modal (Gọi hàm openDeleteModalFunction)
    function openDeleteModalWrapper(event, productId, productData) {
        if (event) event.stopPropagation(); 
        openDeleteModalFunction(productId, productData);
    }
    
    // Wrapper cho Details Modal (Gọi hàm openProductDetailsModal)
    function openDetailsModalWrapper(event, productData) {
        if (event) event.stopPropagation(); // Ngăn sự kiện lan truyền lên item-card
        
        openProductDetailsModal(productData); 
    }

    function showLoading() {
        const loadingState = document.getElementById('loadingState');
        const productsGrid = document.getElementById('productsGrid');
        if (loadingState && productsGrid) {
            loadingState.classList.remove('d-none');
            productsGrid.style.opacity = '0.3';
        }
    }

    function hideLoading() {
        const loadingState = document.getElementById('loadingState');
        const productsGrid = document.getElementById('productsGrid');
        if (loadingState && productsGrid) {
            loadingState.classList.add('d-none');
            productsGrid.style.opacity = '1';
        }
    }
</script>

@if ($errors->add->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addModal = new bootstrap.Modal(document.getElementById('addProductModal'));
        addModal.show();
    });
</script>
@endif

@if ($errors->update->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateProductModal = new bootstrap.Modal(document.getElementById('updateProductModal'));
        updateProductModal.show();
    });
</script>
@endif

@if ($errors->import->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const importModal = new bootstrap.Modal(document.getElementById('importModal'));
        importModal.show();
    });
</script>
@endif

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('{{ session('success ') }}');
    });
</script>
@endif
@endsection