@extends('layouts.app')

@section('title', 'Article Status Management')

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
                        <i class="fas fa-toggle-on"></i>
                        Article Status Management
                    </h1>
                    <p class="page-subtitle">
                        Manage status types for your articles and news system
                    </p>
                </div>
                <div class="header-right">
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addArticleStatusModal">
                        <i class="fas fa-plus"></i> Add New Status
                    </button>

                    <!--button type="button" class="btn-import" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fas fa-file-import"></i>
                        Import Status
                    </button>
                    <a href="route('administrator.article_statuses.export') " class="btn-export">
                        <i class="fas fa-file-export"></i>
                        Export Status
                    </a-->
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading article statuses...</p>
        </div>

        <div class="items-grid" id="statusesGrid">
            @forelse($article_statuses as $status)
            <div class="item-card" data-status-id="{{ $status->id }}">
                <div class="item-image-container">
                    <div class="item-image-placeholder">
                        <i class="fas fa-info-circle"></i>
                    </div>

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
                            <i class="fas fa-file-alt"></i>
                            <span class="info-label">Articles:</span>
                            <span class="info-value"> {{ $status->articles_count ?? 0 }} Articles</span>
                        </div>
                    </div>

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-microchip"></i>
                            Status ID #{{ $status->id }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content text-center py-5">
                    <i class="fas fa-tasks empty-icon fa-4x mb-3"></i>
                    <h3 class="empty-title">No Article Statuses Found</h3>
                    <button type="button" class="btn btn-primary btn-add-first" data-bs-toggle="modal" data-bs-target="#addArticleStatusModal">
                        <i class="fas fa-plus"></i> Create Your First Status
                    </button>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!--div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="importModalLabel">
                    <i class="fas fa-file-import"></i>
                    Import from Excel
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="importStatusForm" action="route('administrator.article_statuses.import') " method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label" for="file_excel">
                            <i class="fas fa-file-excel"></i>
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
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="importStatusForm" class="btn btn-primary px-4" id="importSubmitBtn">
                    <span class="btn-text">Import Data</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Importing...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div-->

{{-- Các file include phụ thuộc vào đường dẫn thư mục article_statuses --}}
@include('administrator.article_statuses.add')
@include('administrator.article_statuses.update')
@include('administrator.article_statuses.delete')

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

        // Phím tắt Ctrl + N
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
                e.preventDefault();
                const addModal = new bootstrap.Modal(document.getElementById('addArticleStatusModal'));
                addModal.show();
            }
        });
    });

    function openEditStatusModal(statusId, statusData) {
        if (typeof openUpdateModal === "function") {
            openUpdateModal(statusId, statusData);
        }
    }

    function openDeleteStatusModal(statusId, statusData) {
        if (typeof openDeleteModal === "function") {
            openDeleteModal(statusId, statusData);
        }
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
        new bootstrap.Modal(document.getElementById('addArticleStatusModal')).show();
    });
</script>
@endif

@if ($errors->update->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new bootstrap.Modal(document.getElementById('updateArticleStatusModal')).show();
    });
</script>
@endif
@endsection