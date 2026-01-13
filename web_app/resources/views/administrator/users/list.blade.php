@extends('layouts.app')

@section('title', 'User Management')

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
                        <i class="fas fa-users"></i>
                        User Management
                    </h1>
                    <p class="page-subtitle">
                        Manage users and their roles
                    </p>
                </div>
                <div class="header-right">
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fa-light fa-plus"></i>
                        Add New User
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading users...</p>
        </div>

        <div class="items-grid" id="usersGrid">
            @forelse($users as $user)
            <div class="item-card" data-user-id="{{ $user->id }}">
                <div class="item-image-container">
                    @if($user->avatar) 
                    <img src="{{ asset('storage/app/private/'. $user->avatar) }}"
                        alt="{{ $user->avatar }}"
                        class="item-image"
                        loading="lazy">
                    @else
                    <div class="item-image-placeholder">
                        <i class="fas fa-user"></i>
                    </div>
                    @endif


                    <div class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                        <i class="fas fa-circle"></i>
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </div>

                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button"
                                class="action-btn edit-btn"
                                title="Edit User"
                                onclick="openEditUserModal('{{ $user->id }}')">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button"
                                class="action-btn delete-btn"
                                title="Delete User"
                                onclick="openDeleteUserModal('{{ $user->id }}')">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span> 
                            </button>
                        </div>
                    </div>
                </div>

                <div class="item-content">
                    <h3 class="item-title">{{ $user->name }}</h3>

                    <div class="item-info">
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <span class="info-label">Email:</span>
                            <span class="info-value">{{ Str::limit($user->email, 25) }}</span>
                        </div>
                        @if($user->username)
                        <div class="info-item">
                            <i class="fas fa-at"></i>
                            <span class="info-label">Username:</span>
                            <span class="info-value">{{ $user->username }}</span>
                        </div>
                        @endif
                        @if($user->phone)
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <span class="info-label">Phone:</span>
                            <span class="info-value">{{ $user->phone }}</span>
                        </div>
                        @endif
                        <div class="info-item">
                            <i class="fas fa-user-tag"></i>
                            <span class="info-label">Role:</span>

                            <span class="info-value">{{ $user->role->name ?? 'N/A' }}</span>
                        </div>
                    </div>

                    @if($user->jobs || $user->company)
                    <div class="item-description">
                        <i class="fas fa-briefcase"></i>
                        {{ $user->jobs }} {{ $user->company ? '@ ' . $user->company : '' }}
                    </div>
                    @endif

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-calendar"></i>
                            {{ $user->created_at->format('d/m/Y') }}
                        </div>
                        <div class="item-id">
                            ID: {{ $user->id }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-users empty-icon"></i>
                    <h3 class="empty-title">No Users Found</h3>
                    <p class="empty-text">
                        There are no users yet. Create a new user to get started.
                    </p>
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-plus"></i>
                        Create Your First User
                    </button>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@include('administrator.users.add')
@include('administrator.users.update')
@include('administrator.users.delete')

@endsection

@section('scripts')
<script>
    const usersData = @json($users);
    const rolesData = @json($roles);

    function openEditUserModal(userId) {
        const user = usersData.find(u => u.id == userId);
        if (user) {
            openUpdateModal(userId, user);
        }
    }

    function openDeleteUserModal(userId, userData) {
        openDeleteModal(userId, userData);
    }
</script>

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));
        addUserModal.show();
    });
</script>
@endif
@endsection