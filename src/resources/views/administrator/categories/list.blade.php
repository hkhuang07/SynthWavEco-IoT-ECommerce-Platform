@extends('layouts.app')

@section('title', 'Category Management')

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
                        <i class="fas fa-tags"></i>
                        Category Management
                    </h1>
                    <p class="page-subtitle">
                        Manage and organize your product categories
                    </p>
                </div>
                <div class="header-right">
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="fa-light fa-plus"></i>
                        Add New Category
                    </button>
                    <button type="button" class="btn-import" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fa-light fa-file-import"></i>
                        Import Category
                    </button>
                    <a href="{{ route('administrator.categories.export') }}" class="btn-export">
                        <i class="fa-light fa-file-export"></i>
                        Export Category
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading categories...</p>
        </div>
        <div
            class="invalid-feedback"
            id="noCategoriesMessage"
            style="display: none;">
        </div>
        <div class="items-grid" id="categoriesGrid">
            @forelse($categories as $category)
            <div class="item-card" data-category-id="{{ $category->id }}">
                <div class="item-image-container">
                    @if(isset($category->image) && $category->image && file_exists(storage_path('app/private/' . $category->image)))
                    <img src="{{ asset('storage/app/private/'. $category->image) }}"
                        alt="{{ $category->name }}"
                        class="item-image"
                        loading="lazy">
                    @else
                    <div class="item-image-placeholder">
                        <i class="fas fa-leaf"></i>
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
                                title="Edit Category"
                                onclick="openEditCategoryModal('{{ $category->id }}', {{ json_encode($category) }})">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button"
                                class="action-btn delete-btn"
                                title="Delete Category"
                                onclick="openDeleteCategoryModal('{{ $category->id }}', {{ json_encode($category) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="item-content">
                    <h3 class="item-title" title="{{ $category->name }}">
                        {{ $category->name }}
                    </h3>

                    <div class="item-info">
                        @if($category->slug)
                        <div class="info-item">
                            <i class="fas fa-link"></i>
                            <span class="info-label">Slug:</span>
                            <span class="info-value" title="{{ $category->slug }}">
                                {{ Str::limit($category->slug, 20) }}
                            </span>
                        </div>
                        @endif

                        @if($category->parent_id)
                        <div class="info-item">
                            <i class="fas fa-folder-tree"></i>
                            <span class="info-label">Parent:</span>
                            <span class="info-value">{{ $categories->where('id', $category->parent_id)->first()?->name }}</span>
                        </div>
                        @else
                        <div class="info-item">
                            <i class="fas fa-folder-tree"></i>
                            <span class="info-label">Parent:</span>
                            <span class="info-value">origin category</span>
                        </div>
                        @endif
                    </div>

                    <div class="item-description">
                        {{ Str::limit($category->description, 255) }}
                    </div>

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-seedling"></i>
                            Category #{{ $category->id }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-tags empty-icon"></i>
                    <h3 class="empty-title">No Categories Found</h3>
                    <p class="empty-text">
                        You haven't added any categories yet. Start organizing your products by creating your first category.
                    </p>
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="fas fa-plus"></i>
                        Create Your First Category
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
                <form id="importProductForm" action="{{ route('administrator.categories.import') }}" method="post" enctype="multipart/form-data">
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


@include('administrator.categories.add')
@include('administrator.categories.update')
@include('administrator.categories.delete')

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
                const addCategoryModal = new bootstrap.Modal(document.getElementById('addCategoryModal'));
                addCategoryModal.show();
            }
        });
    });

    function openEditCategoryModal(categoryId, categoryData) {
        openUpdateModal(categoryId, categoryData);
    }

    /*function openDeleteCategoryModal(categoryId, categoryData) {
        openDeleteModal(categoryId, categoryData);
    }*/
    /*function openDeleteCategoryModal(categoryId, categoryData) {
        openDeleteCategoryModal(categoryId, categoryData); 
    }*/

    function showLoading() {
        const loadingState = document.getElementById('loadingState');
        const categoriesGrid = document.getElementById('categoriesGrid');
        if (loadingState && categoriesGrid) {
            loadingState.classList.remove('d-none');
            categoriesGrid.style.opacity = '0.3';
        }
    }

    function hideLoading() {
        const loadingState = document.getElementById('loadingState');
        const categoriesGrid = document.getElementById('categoriesGrid');
        if (loadingState && categoriesGrid) {
            loadingState.classList.add('d-none');
            categoriesGrid.style.opacity = '1';
        }
    }
</script>

@if ($errors->add->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addCategoryModal = new bootstrap.Modal(document.getElementById('addCategoryModal'));
        addCategoryModal.show();
    });
</script>
@endif

@if ($errors->update->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateCategoryModal = new bootstrap.Modal(document.getElementById('updateCategoryModal'));
        updateCategoryModal.show();
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