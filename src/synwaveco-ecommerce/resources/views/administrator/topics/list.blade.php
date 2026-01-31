@extends('layouts.app')

@section('title', 'Topic Management')

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
                        <i class="fas fa-folder"></i>
                        Topic Management
                    </h1>
                    <p class="page-subtitle">
                        Organize your articles and IoT projects by topics
                    </p>
                </div>
                <div class="header-right">
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addTopicModal">
                        <i class="fas fa-plus-circle"></i>
                        Add New Topic
                    </button>
                    <!--button type="button" class="btn-import" data-bs-toggle="modal" data-bs-target="#importTopicModal">
                        <i class="fas fa-file-import"></i>
                        Import Topic
                    </button>
                    <a href=" route('administrator.topics.export') " class="btn-export">
                        <i class="fas fa-file-export"></i>
                        Export Topic
                    </a-->
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading topics...</p>
        </div>

        <div class="items-grid" id="topicsGrid">
            @forelse($topics as $topic)
            <div class="item-card" data-topic-id="{{ $topic->id }}">
                <div class="item-image-container">
                    @if($topic->image && Storage::exists($topic->image))
                    <img src="{{ asset('storage/app/private/'. $topic->image) }}"
                        alt="{{ $topic->name }}"
                        class="item-image"
                        loading="lazy">
                    @else
                    <div class="item-image-placeholder">
                        <i class="fas fa-microchip"></i>
                    </div>
                    @endif

                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button"
                                class="action-btn edit-btn"
                                title="Edit Topic"
                                onclick="openEditTopicModal('{{ $topic->id }}', {{ json_encode($topic) }})">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button"
                                class="action-btn delete-btn"
                                title="Delete Topic"
                                onclick="openDeleteTopicModal('{{ $topic->id }}', {{ json_encode($topic) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="item-content">
                    <h3 class="item-title" title="{{ $topic->name }}">
                        {{ $topic->name }}
                    </h3>

                    <div class="item-info">
                        <div class="info-item">
                            <i class="fas fa-link"></i>
                            <span class="info-label">Slug:</span>
                            <span class="info-value" title="{{ $topic->slug }}">
                                {{ Str::limit($topic->slug, 25) }}
                            </span>
                        </div>
                    </div>

                    <div class="item-description">
                        {{ Str::limit($topic->description, 150) ?? 'No description provided.' }}
                    </div>

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-calendar-alt"></i>
                            Topic ID #{{ $topic->id }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content text-center py-5">
                    <i class="fas fa-folder-open empty-icon fa-4x mb-3" style="color: #ccc;"></i>
                    <h3 class="empty-title">No Topics Found</h3>
                    <p class="empty-text mb-4">
                        Start organizing your ecosystem by creating your first topic.
                    </p>
                    <button type="button" class="btn btn-primary btn-add-first" data-bs-toggle="modal" data-bs-target="#addTopicModal">
                        <i class="fas fa-plus"></i>
                        Create Your First Topic
                    </button>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@include('administrator.topics.add')
@include('administrator.topics.update')
@include('administrator.topics.delete')

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
                const addTopicModal = new bootstrap.Modal(document.getElementById('addTopicModal'));
                addTopicModal.show();
            }
        });
    });

    function openEditTopicModal(topicId, topicData) {
        // Hàm openUpdateModal cần được định nghĩa trong file administrator.topics.update
        if (typeof openUpdateModal === "function") {
            openUpdateModal(topicId, topicData);
        }
    }

    function openDeleteTopicModal(topicId, topicData) {
        // Hàm openDeleteModal cần được định nghĩa trong file administrator.topics.delete
        if (typeof openDeleteModal === "function") {
            openDeleteModal(topicId, topicData);
        }
    }
</script>

{{-- Tự động mở Modal khi có lỗi Validation --}}
@if ($errors->add->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new bootstrap.Modal(document.getElementById('addTopicModal')).show();
    });
</script>
@endif

@if ($errors->update->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new bootstrap.Modal(document.getElementById('updateTopicModal')).show();
    });
</script>
@endif
@endsection