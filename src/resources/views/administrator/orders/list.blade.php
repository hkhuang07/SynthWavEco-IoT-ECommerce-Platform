@extends('layouts.app')

@section('title', 'Order Management')

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
                        <i class="fas fa-shopping-cart"></i>
                        Order Management
                    </h1>
                    <p class="page-subtitle">
                        Manage customer orders and order items
                    </p>
                </div>
                <div class="header-right">
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addOrderModal">
                        <i class="fa-light fa-plus"></i>
                        Add New Order
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading orders...</p>
        </div>

        <div class="items-grid" id="ordersGrid">
            @forelse($orders as $order)
            <div class="item-card" data-order-id="{{ $order->id }}" onclick="openOrderDetailsModal({{ json_encode($order) }})">
                <div class="item-image-container">
                    <div class="item-image-placeholder">
                        <i class="fas fa-receipt"></i>
                    </div>

                    <div class="status-badge {{ $order->status ? 'status-' . Str::slug($order->status->name) : '' }}">
                        <i class="fas fa-circle"></i>
                        {{ $order->status->name ?? 'N/A' }}
                    </div>

                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button"
                                class="action-btn edit-btn"
                                title="Edit Order"
                                onclick="openEditOrderModal('{{ $order->id }}')">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button"
                                class="action-btn delete-btn"
                                title="Delete Order"
                                onclick="openDeleteOrderModal('{{ $order->id }}', {{ json_encode($order) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="item-content">
                    <h3 class="item-title">
                        Order #{{ $order->id }}
                    </h3>

                    <div class="item-info">
                        <div class="info-item">
                            <i class="fas fa-user"></i>
                            <span class="info-label">Customer:</span>
                            <span class="info-value">{{ $order->user->name ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <span class="info-label">Phone:</span>
                            <span class="info-value">{{ $order->contact_phone }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-credit-card"></i>
                            <span class="info-label">Payment:</span>
                            <span class="info-value">{{ $order->payment_method }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-box"></i>
                            <span class="info-label">Items:</span>
                            <span class="info-value">{{ $order->items_count ?? $order->items->count() }}</span>
                        </div>
                    </div>

                    <div class="item-description">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ Str::limit($order->shipping_address, 100) }}
                    </div>

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-calendar"></i>
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="item-price">
                            <strong>${{ number_format($order->total_amount, 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-shopping-cart empty-icon"></i>
                    <h3 class="empty-title">No Orders Found</h3>
                    <p class="empty-text">
                        There are no orders yet. Create a new order to get started.
                    </p>
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addOrderModal">
                        <i class="fas fa-plus"></i>
                        Create Your First Order
                    </button>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@include('administrator.orders.add')
@include('administrator.orders.update')
@include('administrator.orders.delete')
@include('administrator.orders.details') 

@endsection

@section('scripts')
<script>
    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    });

    const ordersData = @json($orders);
    const productsData = @json($products);
    
    function openEditOrderModal(orderId) {
        const order = ordersData.find(o => o.id == orderId);
        if (order) {
            openUpdateModal(orderId, order);
        }
    }

    function openDeleteOrderModal(orderId, orderData) {
        openDeleteModal(orderId, orderData);
    }
</script>

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addOrderModal = new bootstrap.Modal(document.getElementById('addOrderModal'));
        addOrderModal.show();
    });
</script>
@endif
@endsection
