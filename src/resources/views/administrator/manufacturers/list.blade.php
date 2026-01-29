@extends('layouts.app')

@section('title', 'Manufacturer Management')

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
                        <i class="fas fa-industry"></i>
                        Manufacturer Management
                    </h1>
                    <p class="page-subtitle">
                        Manage your product manufacturers and suppliers
                    </p>
                </div>
                <div class="header-right">
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addManufacturerModal">
                        <i class="fa-light fa-plus"></i>
                        Add New Manufacturer
                    </button>
                    <button type="button" class="btn-import" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fa-light fa-file-import"></i>
                        Import Manufacturer
                    </button>
                    <a href="{{ route('administrator.manufacturers.export') }}" class="btn-export">
                        <i class="fa-light fa-file-export"></i>
                        Export Manufacturer
                    </a>

                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading manufacturers...</p>
        </div>

        <div class="items-grid" id="manufacturersGrid">
            @forelse($manufacturers as $manufacturer)
            <div class="item-card" data-manufacturer-id="{{ $manufacturer->id }}">
                <div class="item-image-container">
                    @if(isset($manufacturer->logo) && $manufacturer->logo && file_exists(storage_path('app/private/' . $manufacturer->logo)))
                    <img src="{{ asset('storage/app/private/'. $manufacturer->logo) }}"
                        alt="{{ $manufacturer->name }}"
                        class="item-image"
                        loading="lazy">
                    @else
                    <div class="item-image-placeholder">
                        <i class="fas fa-industry"></i>
                    </div>
                    @endif

                    <!--div class="status-badge">
                        <i class="fas fa-check-circle"></i>
                        Active
                    </div-->

                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button"
                                class="action-btn edit-btn"
                                title="Edit Manufacturer"
                                onclick="openEditManufacturerModal('{{ $manufacturer->id }}', {{ json_encode($manufacturer) }})">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button"
                                class="action-btn delete-btn"
                                title="Delete Manufacturer"
                                onclick="openDeleteManufacturerModal('{{ $manufacturer->id }}', {{ json_encode($manufacturer) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="item-content">
                    <h3 class="item-title" title="{{ $manufacturer->name }}">
                        {{ $manufacturer->name }}
                    </h3>

                    <div class="item-info">
                        @if($manufacturer->slug)
                        <div class="info-item">
                            <i class="fas fa-link"></i>
                            <span class="info-label">Slug:</span>
                            <span class="info-value" title="{{ $manufacturer->slug }}">
                                {{ Str::limit($manufacturer->slug, 20) }}
                            </span>
                        </div>
                        @endif

                        @if($manufacturer->contact_email)
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <span class="info-label">Email:</span>
                            <span class="info-value" title="{{ $manufacturer->contact_email }}">
                                {{ Str::limit($manufacturer->contact_email, 20) }}
                            </span>
                        </div>
                        @endif

                        @if($manufacturer->contact_phone)
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <span class="info-label">Phone:</span>
                            <span class="info-value">{{ $manufacturer->contact_phone }}</span>
                        </div>
                        @endif

                        @if($manufacturer->address)
                        <div class="info-item">
                            <i class="fas fa-location-dot"></i>
                            <span class="info-label">Address:</span>
                            <span class="info-value" title="{{ $manufacturer->address }}">
                                {{ Str::limit($manufacturer->address, 25) }}
                            </span>
                        </div>
                        @endif

                        @if($manufacturer->description)
                        <div class="item-description">
                            {{ Str::limit($manufacturer->description, 80) }}
                        </div>
                        @endif
                    </div>

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-seedling"></i>
                            Manufacturer #{{ $manufacturer->id }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-industry empty-icon"></i>
                    <h3 class="empty-title">No Manufacturers Found</h3>
                    <p class="empty-text">
                        You haven't added any manufacturers yet. Start building your supplier network by creating your first manufacturer.
                    </p>
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addManufacturerModal">
                        <i class="fas fa-plus"></i>
                        Create Your First Manufacturer
                    </button>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="importModalLabel">
                    <i class="fa-light fa-file-import"></i>
                    Import from Excel
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="importProductForm" action="{{ route('administrator.manufacturers.import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label" for="file_excel">
                            <i class="fa-light fa-file-excel"></i>
                            Choose Excel File <span class="text-danger">*</span>
                        </label>
                        <input
                            type="file"
                            class="form-control item-input @error('file_excel', 'import') is-invalid @enderror"
                            id="file_excel"
                            name="file_excel"
                            accept=".xlsx,.xls,.csv"
                            required />
                        @error('file_excel', 'import')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Accepted formats: .xlsx, .xls, .csv</small>
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="importProductForm" class="btn btn-action" id="importSubmitBtn">
                    <i class="fa-light fa-upload"></i>
                    <span class="btn-text">Import Data</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fa-light fa-spinner fa-spin"></i>
                        Importing...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

@include('administrator.manufacturers.add')
@include('administrator.manufacturers.update')
@include('administrator.manufacturers.delete')

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
                const addManufacturerModal = new bootstrap.Modal(document.getElementById('addManufacturerModal'));
                addManufacturerModal.show();
            }
        });
    });

    function openEditManufacturerModal(manufacturerId, manufacturerData) {
        openUpdateModal(manufacturerId, manufacturerData);
    }

    function openDeleteManufacturerModal(manufacturerId, manufacturerData) {
        openDeleteModal(manufacturerId, manufacturerData);
    }

    function showLoading() {
        const loadingState = document.getElementById('loadingState');
        const manufacturersGrid = document.getElementById('manufacturersGrid');
        if (loadingState && manufacturersGrid) {
            loadingState.classList.remove('d-none');
            manufacturersGrid.style.opacity = '0.3';
        }
    }

    function hideLoading() {
        const loadingState = document.getElementById('loadingState');
        const manufacturersGrid = document.getElementById('manufacturersGrid');
        if (loadingState && manufacturersGrid) {
            loadingState.classList.add('d-none');
            manufacturersGrid.style.opacity = '1';
        }
    }
</script>

@if ($errors->add->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addManufacturerModal = new bootstrap.Modal(document.getElementById('addManufacturerModal'));
        addManufacturerModal.show();
    });
</script>
@endif

@if ($errors->update->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateManufacturerModal = new bootstrap.Modal(document.getElementById('updateManufacturerModal'));
        updateManufacturerModal.show();
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
        console.log('{{ session('
            success ') }}');
    });
</script>
@endif
@endsection