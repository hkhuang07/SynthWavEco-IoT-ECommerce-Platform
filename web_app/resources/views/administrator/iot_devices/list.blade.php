@extends('layouts.app')

@section('title', 'IoT Device Management')

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
                        <i class="fas fa-microchip"></i>
                        IoT Device Management
                    </h1>
                    <p class="page-subtitle">
                        Manage IoT devices, metrics and alert thresholds
                    </p>
                </div>
                <div class="header-right">
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addDeviceModal">
                        <i class="fa-light fa-plus"></i>
                        Add New Device
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading devices...</p>
        </div>

        <div class="items-grid" id="devicesGrid">
            @forelse($devices as $device)
            <div class="item-card" data-device-id="{{ $device->id }}">
                <div class="item-image-container">
                    <div class="item-image-placeholder">
                        <i class="fas fa-microchip"></i>
                    </div>

                    <div class="status-badge {{ $device->is_active ? 'status-active' : 'status-inactive' }}">
                        <i class="fas fa-circle"></i>
                        {{ $device->is_active ? 'Active' : 'Inactive' }}
                    </div>

                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button"
                                class="action-btn edit-btn"
                                title="Edit Device"
                                onclick="openEditDeviceModal('{{ $device->id }}')">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button"
                                class="action-btn delete-btn"
                                title="Delete Device"
                                onclick="openDeleteDeviceModal('{{ $device->id }}', {{ json_encode($device) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="item-content">
                    <h3 class="item-title">{{ $device->device_id }}</h3>

                    <div class="item-info">
                        <div class="info-item">
                            <i class="fas fa-box"></i>
                            <span class="info-label">Product:</span>
                            <span class="info-value">{{ $device->product->name ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-microchip"></i>
                            <span class="info-label">Device:</span>
                            <span class="info-value">{{ $device->device_id ?? 'N/A' }}</span>
                        </div>
                        @if($device->location)
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span class="info-label">Location:</span>
                            <span class="info-value">{{ Str::limit($device->location, 30) }}</span>
                        </div>
                        @endif
                        <div class="info-item">
                            <i class="fas fa-chart-line"></i>
                            <span class="info-label">Metrics:</span>
                            <span class="info-value">{{ $device->metrics_count ?? $device->metrics->count() }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-bell"></i>
                            <span class="info-label">Thresholds:</span>
                            <span class="info-value">{{ $device->thresholds->count() }}</span>
                        </div>
                    </div>

                    @if($device->last_seen)
                    <div class="item-description">
                        <i class="fas fa-clock"></i>
                        Last seen: {{ $device->last_seen->diffForHumans() }}
                    </div>
                    @endif

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-calendar"></i>
                            {{ $device->created_at->format('d/m/Y') }}
                        </div>
                        <div class="item-id">
                            Device: #{{ $device->id }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-microchip empty-icon"></i>
                    <h3 class="empty-title">No IoT Devices Found</h3>
                    <p class="empty-text">
                        There are no IoT devices yet. Add a new device to get started.
                    </p>
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addDeviceModal">
                        <i class="fas fa-plus"></i>
                        Add Your First Device
                    </button>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@include('administrator.iot_devices.add')
@include('administrator.iot_devices.update')
@include('administrator.iot_devices.delete')

@endsection

@section('scripts')
<script>
    const devicesData = @json($devices);
    const productsData = @json($products);
    
    function openEditDeviceModal(deviceId) {
        const device = devicesData.find(d => d.id == deviceId);
        if (device) {
            openUpdateModal(deviceId, device);
        }
    }

    function openDeleteDeviceModal(deviceId, deviceData) {
        openDeleteModal(deviceId, deviceData);
    }
</script>

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addDeviceModal = new bootstrap.Modal(document.getElementById('addDeviceModal'));
        addDeviceModal.show();
    });
</script>
@endif
@endsection
