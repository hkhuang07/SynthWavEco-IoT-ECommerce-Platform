@extends('layouts.app')

@section('title', 'Article Type Management')

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
                        <i class="fas fa-layer-group"></i>
                        Article Type Management
                    </h1>
                    <p class="page-subtitle">
                        Manage categories and classifications for your articles
                    </p>
                </div>
                <div class="header-right">
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addArticleTypeModal">
                        <i class="fas fa-plus"></i> Add New Type
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading article types...</p>
        </div>

        <div class="items-grid" id="typesGrid">
            @forelse($article_types as $type)
            <div class="item-card" data-type-id="{{ $type->id }}">
                <div class="item-image-container">
                    <div class="item-image-placeholder">
                        <i class="fas fa-tags"></i>
                    </div>

                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button"
                                class="action-btn edit-btn"
                                title="Edit Type"
                                onclick="openEditTypeModal('{{ $type->id }}', {{ json_encode($type) }})">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button"
                                class="action-btn delete-btn"
                                title="Delete Type"
                                onclick="openDeleteTypeModal('{{ $type->id }}', {{ json_encode($type) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="item-content">
                    <h3 class="item-title" title="{{ $type->name }}">
                        {{ $type->name }}
                    </h3>

                    <div class="item-info">
                        <div class="info-item">
                            <i class="fas fa-file-alt"></i>
                            <span class="info-label">Articles:</span>
                            {{-- Hiển thị số lượng bài viết thuộc loại này --}}
                            <span class="info-value"> {{ $type->articles_count ?? 0 }} Articles</span>
                        </div>
                    </div>
                    <div class="item-info">
                        <div class="info-item">
                            <i class="fas fa-file-alt"></i>
                            <span class="info-label">Slug:</span>
                            <span class="info-value"> {{ $type->slug }}</span>
                        </div>
                    </div>

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-microchip"></i>
                            Type ID #{{ $type->id }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content text-center py-5">
                    <i class="fas fa-layer-group empty-icon fa-4x mb-3"></i>
                    <h3 class="empty-title">No Article Types Found</h3>
                    <p class="empty-text">
                        Start classifying your content by creating your first article type.
                    </p>
                    <button type="button" class="btn btn-primary btn-add-first" data-bs-toggle="modal" data-bs-target="#addArticleTypeModal">
                        <i class="fas fa-plus"></i> Create Your First Type
                    </button>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Các file include phụ thuộc vào đường dẫn thư mục article_types --}}
@include('administrator.article_types.add')
@include('administrator.article_types.update')
@include('administrator.article_types.delete')

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

        // Phím tắt Ctrl + N để mở modal thêm mới
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
                e.preventDefault();
                const addModal = new bootstrap.Modal(document.getElementById('addArticleTypeModal'));
                addModal.show();
            }
        });
    });

    function openEditTypeModal(typeId, typeData) {
        if (typeof openUpdateModal === "function") {
            openUpdateModal(typeId, typeData);
        }
    }

    function openDeleteTypeModal(typeId, typeData) {
        if (typeof openDeleteModal === "function") {
            openDeleteModal(typeId, typeData);
        }
    }
</script>

{{-- Tự động mở Modal khi có lỗi Validation từ server --}}
@if ($errors->add->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new bootstrap.Modal(document.getElementById('addArticleTypeModal')).show();
    });
</script>
@endif

@if ($errors->update->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new bootstrap.Modal(document.getElementById('updateArticleTypeModal')).show();
    });
</script>
@endif
@endsection