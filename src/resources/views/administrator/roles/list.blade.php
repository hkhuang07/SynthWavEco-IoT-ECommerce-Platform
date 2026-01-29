@extends('layouts.app')

@section('title', 'Role Management')

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
                        <i class="fas fa-user-shield"></i>
                        Role Management
                    </h1>
                    <p class="page-subtitle">
                        Manage user roles and permissions
                    </p>
                </div>
                <div class="header-right">
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        <i class="fa-light fa-plus"></i>
                        Add New Role
                    </button>
                     </button>
                        <button type="button" class="btn-import" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fa-light fa-file-import"></i>
                        Import Role
                    </button>
                    <a href="{{ route('administrator.roles.export') }}" class="btn-export">
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
            <p class="loading-text">Loading roles...</p>
        </div>

        <div class="items-grid" id="rolesGrid">
            @forelse($roles as $role)
            <div class="item-card" data-role-id="{{ $role->id }}">
                <div class="item-image-container">
                    <div class="item-image-placeholder">
                        <i class="fas fa-shield-alt"></i>
                    </div>

                    <div class="status-badge">
                        <i class="fas fa-users"></i>
                        {{ $role->users_count ?? 0 }} Users
                    </div>

                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button"
                                class="action-btn edit-btn"
                                title="Edit Role"
                                onclick="openEditRoleModal('{{ $role->id }}', {{ ($role) }})">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button"
                                class="action-btn delete-btn"
                                title="Delete Role"
                                onclick="openDeleteRoleModal('{{ $role->id }}', {{ ($role) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="item-content">
                    <h3 class="item-title" title="{{ $role->name }}">
                        {{ $role->name }}
                    </h3>

                    <div class="item-description">
                        {{ Str::limit($role->description, 255) ?: 'No description' }}
                    </div>

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-key"></i>
                            Role #{{ $role->id }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-user-shield empty-icon"></i>
                    <h3 class="empty-title">No Roles Found</h3>
                    <p class="empty-text">
                        You haven't added any roles yet. Start by creating your first role.
                    </p>
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        <i class="fas fa-plus"></i>
                        Create Your First Role
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
                <form id="importProductForm" action="{{ route('administrator.roles.import') }}" method="post" enctype="multipart/form-data">
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


@include('administrator.roles.add')
@include('administrator.roles.update')
@include('administrator.roles.delete')

@endsection

@section('scripts')
<script>
    function openEditRoleModal(roleId, roleData) {
        openUpdateModal(roleId, roleData);
    }

    function openDeleteRoleModal(roleId, roleData) {
        openDeleteModal(roleId, roleData);
    }
</script>

@if ($errors->add->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addRoleModal = new bootstrap.Modal(document.getElementById('addRoleModal'));
        addRoleModal.show();
    });
</script>
@endif
@if ($errors->update->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addRoleModal = new bootstrap.Modal(document.getElementById('updateRoleModal'));
        addRoleModal.show();
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

@endsection