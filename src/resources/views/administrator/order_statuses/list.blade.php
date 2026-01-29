@extends('layouts.app')

@section('title', 'Order Status Management')

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
                        <i class="fas fa-tasks"></i>
                        Order Status Management
                    </h1>
                    <p class="page-subtitle">
                        Manage order status types for your e-commerce system
                    </p>
                </div>
                <div class="header-right">
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addOrderStatusModal">
                        <i class="fa-light fa-plus"></i>
                        Add New Status
                    </button>
                      </button>
                        <button type="button" class="btn-import" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fa-light fa-file-import"></i>
                        Import Role
                    </button>
                    <a href="{{ route('administrator.order_statuses.export') }}" class="btn-export">
                        <i class="fa-light fa-file-export"></i>
                        Export Role
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading order statuses...</p>
        </div>

        <div class="items-grid" id="statusesGrid">
            @forelse($statuses as $status)
            <div class="item-card" data-status-id="{{ $status->id }}">
                <div class="item-image-container">
                    <div class="item-image-placeholder">
                        <i class="fas fa-flag"></i>
                    </div>

                    <!--div class="status-badge">
                        <i class="fas fa-check-circle"></i>
                        Active
                    </div-->

                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button"
                                class="action-btn edit-btn"
                                title="Edit Status"
                                onclick="openEditStatusModal('{{ $status->id }}', {{ json_encode($status) }})">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button"
                                class="action-btn delete-btn"
                                title="Delete Status"
                                onclick="openDeleteStatusModal('{{ $status->id }}', {{ json_encode($status) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="item-content">
                    <h3 class="item-title" title="{{ $status->name }}">
                        {{ $status->name }}
                    </h3>

                    <div class="item-info">
                        <div class="info-item">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="info-label">Orders:</span>
                            <span class="info-value">{{ $status->orders()->count() }}</span>
                        </div>
                    </div>

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-seedling"></i>
                            Status #{{ $status->id }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-tasks empty-icon"></i>
                    <h3 class="empty-title">No Order Statuses Found</h3>
                    <p class="empty-text">
                        You haven't added any order statuses yet. Start by creating your first status.
                    </p>
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addOrderStatusModal">
                        <i class="fas fa-plus"></i>
                        Create Your First Status
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
                <form id="importProductForm" action="{{ route('administrator.order_statuses.import') }}" method="post" enctype="multipart/form-data">
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


@include('administrator.order_statuses.add')
@include('administrator.order_statuses.update')
@include('administrator.order_statuses.delete')

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
                const addModal = new bootstrap.Modal(document.getElementById('addOrderStatusModal'));
                addModal.show();
            }
        });
    });

    function openEditStatusModal(statusId, statusData) {
        openUpdateModal(statusId, statusData);
    }

    function openDeleteStatusModal(statusId, statusData) {
        openDeleteModal(statusId, statusData);
    }

    function showLoading() {
        const loadingState = document.getElementById('loadingState');
        const statusesGrid = document.getElementById('statusesGrid');
        if (loadingState && statusesGrid) {
            loadingState.classList.remove('d-none');
            statusesGrid.style.opacity = '0.3';
        }
    }

    function hideLoading() {
        const loadingState = document.getElementById('loadingState');
        const statusesGrid = document.getElementById('statusesGrid');
        if (loadingState && statusesGrid) {
            loadingState.classList.add('d-none');
            statusesGrid.style.opacity = '1';
        }
    }
</script>

@if ($errors->add->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addModal = new bootstrap.Modal(document.getElementById('addOrderStatusModal'));
        addModal.show();
    });
</script>
@endif

@if ($errors->update->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateModal = new bootstrap.Modal(document.getElementById('updateOrderStatusModal'));
        updateModal.show();
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
        console.log('{{ session('success') }}');
    });
</script>
@endif
@endsection
