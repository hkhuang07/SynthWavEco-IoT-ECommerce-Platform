<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Delete User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="delete-confirmation text-center">
                    <div class="delete-icon-container mb-3">
                        <i class="fas fa-user-times delete-icon"></i>
                    </div>
                    
                    <h4 class="delete-title mb-3">Are you sure?</h4>
                    
                    <div class="delete-message mb-4">
                        <p class="mb-2">
                            Do you really want to delete user 
                            <strong id="deleteUserName" class="text-danger"></strong>?
                        </p>
                        
                        <div class="item-info-preview bg-light p-3 rounded mb-3">
                            <div class="text-start">
                                <p class="mb-1"><i class="fas fa-envelope"></i> Email: <span id="deleteUserEmail"></span></p>
                                <p class="mb-1"><i class="fas fa-user-tag"></i> Role: <span id="deleteUserRole"></span></p>
                                <p class="mb-0"><i class="fas fa-calendar"></i> Created: <span id="deleteUserDate"></span></p>
                            </div>
                        </div>
                        
                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone. Users with existing orders cannot be deleted.
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
function openDeleteModal(userId, userData) {
    document.getElementById('deleteUserName').textContent = userData.name;
    document.getElementById('deleteUserEmail').textContent = userData.email || 'N/A';
    document.getElementById('deleteUserRole').textContent = userData.role ? userData.role.name : 'N/A';
    document.getElementById('deleteUserDate').textContent = userData.created_at ? new Date(userData.created_at).toLocaleDateString() : 'N/A';
    
    const deleteBtn = document.getElementById('deleteConfirmBtn');
    deleteBtn.href = `{{ route('administrator.users.delete', ['id' => '__ID__']) }}`.replace('__ID__', userId);

    const deleteModal = new bootstrap.Modal(document.getElementById('deleteUserModal'));
    deleteModal.show();
}

document.addEventListener('DOMContentLoaded', function() {
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
});
</script>
