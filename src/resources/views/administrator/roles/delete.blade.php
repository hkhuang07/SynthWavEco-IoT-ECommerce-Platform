<div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deleteRoleModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Delete Role
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="delete-confirmation text-center">
                    <div class="delete-icon-container mb-3">
                        <i class="fas fa-trash-alt delete-icon"></i>
                    </div>
                    
                    <h4 class="delete-title mb-3">Are you sure?</h4>
                    
                    <div class="delete-message mb-4">
                        <p class="mb-2">
                            Do you really want to delete the role 
                            <strong id="deleteRoleName" class="text-danger"></strong>?
                        </p>
                        
                        <div class="item-info-preview bg-light p-3 rounded mb-3">
                            <div class="text-center">
                                <div class="preview-icon mb-2">
                                    <i class="fas fa-shield-alt fa-3x text-muted"></i>
                                </div>
                                <p id="deleteRoleDescription" class="text-muted mb-0"></p>
                            </div>
                        </div>
                        
                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone. Users with this role will need to be reassigned.
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel me-3" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-delete">
                    <i class="fas fa-trash-alt"></i>
                    <span>Yes, Delete It</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i>
                        Deleting...
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteRoleModal = document.getElementById('deleteRoleModal');
        const deleteConfirmBtn = document.getElementById('deleteConfirmBtn');
        const btnText = deleteConfirmBtn.querySelector('span:not(.btn-loading)');
        const btnLoading = deleteConfirmBtn.querySelector('.btn-loading');

        deleteConfirmBtn.addEventListener('click', function(e) {
            e.preventDefault();
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
            deleteConfirmBtn.style.pointerEvents = 'none';
            window.location.href = this.href;
        });

        deleteRoleModal.addEventListener('hidden.bs.modal', function() {
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            deleteConfirmBtn.style.pointerEvents = 'auto';
        });
    });

    function openDeleteModal(roleId, roleData) {
        document.getElementById('deleteRoleName').textContent = roleData.name;
        document.getElementById('deleteRoleDescription').textContent = roleData.description || 'No description';
        
        const deleteBtn = document.getElementById('deleteConfirmBtn');
        deleteBtn.href = `{{ route('administrator.roles.delete', ['id' => '__ID__']) }}`.replace('__ID__', roleId);
        
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteRoleModal'));
        deleteModal.show();
    }
</script>
