@extends('layouts.app')

@section('title', 'Article Management')

@section('styles')
<link rel="stylesheet" href="{{ asset('public/css/list.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/form.css') }}">
<link rel="stylesheet" href="{{ asset('public/vendor/font-awesome/css/all.min.css') }}" />
<style>
    /* Tùy chỉnh độ cao cho CKEditor để phù hợp với nội dung bài viết */
    .ck-editor__editable {
        min-height: 300px;
    }

    .info-badge-group {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-top: 5px;
    }

    .badge-info-item {
        font-size: 0.75rem;
        padding: 2px 8px;
        border-radius: 4px;
        background: #e9ecef;
        color: #495057;
    }
</style>
@endsection

@section('content')
<div class="item-management-container">
    <div class="item-header">
        <div class="container mx-auto px-4">
            <div class="header-content">
                <div class="header-left">
                    <h1 class="page-title">
                        <i class="fas fa-file-alt"></i>
                        Article Management
                    </h1>
                    <p class="page-subtitle">
                        Create and manage technical content, news, and IoT tutorials
                    </p>
                </div>
                <div class="header-right">
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addArticleModal">
                        <i class="fas fa-plus"></i>
                        Add New Article
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading articles...</p>
        </div>

        <div class="items-grid" id="articlesGrid">
            @forelse($articles as $article)
            <div class="item-card" data-article-id="{{ $article->id }}">
                <div class="item-image-container">
                    @if($article->image && Storage::exists($article->image))
                    <img src="{{ asset('storage/app/private/' . $article->image) }}"
                        alt="{{ $article->title }}"
                        class="item-image"
                        loading="lazy">
                    @else
                    <div class="item-image-placeholder">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    @endif

                    <div class="status-badge {{ $article->is_enabled ? 'bg-success' : 'bg-secondary' }}">
                        <i class="fas {{ $article->is_enabled ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                        {{ $article->is_enabled ? 'Enabled' : 'Disabled' }}
                    </div>

                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button" class="action-btn edit-btn" title="Edit Article"
                                onclick="openUpdateArticleModal('{{ $article->id }}', {{ json_encode($article) }})">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button" class="action-btn delete-btn" title="Delete Article"
                                onclick="openDeleteArticleModal('{{ $article->id }}', {{ json_encode($article) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="item-content">
                    <h3 class="item-title" title="{{ $article->title }}">
                        {{ Str::limit($article->title, 60) }}
                    </h3>

                    <div class="item-info">
                        <div class="info-item">
                            <i class="fas fa-folder"></i>
                            <span class="info-label">Topic:</span>
                            <span class="info-value">{{ $article->topic->name ?? 'Uncategorized' }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-tag"></i>
                            <span class="info-label">Type:</span>
                            <span class="info-value">{{ $article->articletype->name ?? 'General' }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-info-circle"></i>
                            <span class="info-label">Status:</span>
                            <span class="info-value text-primary font-weight-bold">{{ $article->ArticleStatus->name }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-chart-line"></i>
                            <span class="info-label">Views:</span>
                            <span class="info-value">{{ number_format($article->views) }}</span>
                        </div>
                    </div>

                    <div class="item-description">
                        {{ Str::limit($article->summary, 120) }}
                    </div>

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-user-edit"></i>
                            By: {{ $article->user->name ?? 'Admin' }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-tags empty-icon"></i>
                    <h3 class="empty-title">No Articles Found</h3>
                    <p class="empty-text">
                        Start sharing your IoT knowledge by creating your first article.</p>
                    </p>
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addArticleModal">
                        <i class="fas fa-plus"></i>
                        Create First Article
                    </button>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Include Modals --}}
@include('administrator.articles.add')
@include('administrator.articles.update')
@include('administrator.articles.delete')

@endsection
@section('scripts')
<script src="{{ asset('public/vendor/ckeditor5/ckeditor.js') }}"></script>

<script>
    // Biến toàn cục để quản lý các thực thể Editor
    window.editors = {};

    document.addEventListener('DOMContentLoaded', function() {
        // 1. Khởi tạo CKEditor cho tất cả các textarea có class .editor-content
        const editorElements = document.querySelectorAll('.editor-content');

        editorElements.forEach(editorEl => {
            ClassicEditor
                .create(editorEl, {
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'link', '|',
                        'bulletedList', 'numberedList', 'blockQuote', '|',
                        'insertTable', 'undo', 'redo'
                    ],
                    // Thêm cấu hình nếu cần (ví dụ: placeholder)
                    placeholder: 'Type your content here...'
                })
                .then(editor => {
                    // Lưu instance vào object window.editors với key là ID của element
                    window.editors[editorEl.id] = editor;

                    // Đảm bảo Editor co giãn tốt trong Modal
                    editor.editing.view.change(writer => {
                        writer.setStyle('min-height', '300px', editor.editing.view.document.getRoot());
                    });
                })
                .catch(error => {
                    console.error('CKEditor Error on ID ' + editorEl.id + ':', error);
                });
        });

        // 2. Xử lý phím tắt Ctrl + N để mở nhanh Modal Add
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
                e.preventDefault();
                const addModal = new bootstrap.Modal(document.getElementById('addArticleModal'));
                addModal.show();
            }
        });
    });

    function openUpdateArticleModal(id, data) {
        // Kiểm tra xem hàm openUpdateModal trong file update.blade.php có tồn tại không
        if (typeof openUpdateModal === "function") {
            openUpdateModal(id, data);
        } else {
            console.error("Function openUpdateModal is not defined in update.blade.php");
        }
    }

    function openDeleteArticleModal(id, data) {
        if (typeof openDeleteModal === "function") {
            openDeleteModal(id, data);
        } else {
            console.error("Function openDeleteModal is not defined in delete.blade.php");
        }
    }
</script>

{{-- Tự động mở Modal khi có lỗi Validation từ Server-side --}}
@if ($errors->add->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('addArticleModal'));
        myModal.show();
    });
</script>
@endif

@if ($errors->update->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('updateArticleModal'));
        myModal.show();
    });
</script>
@endif
@endsection