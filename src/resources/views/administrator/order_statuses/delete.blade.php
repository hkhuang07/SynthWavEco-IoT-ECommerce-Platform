<div class="modal fade" id="deleteOrderStatusModal" tabindex="-1" aria-labelledby="deleteOrderStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deleteOrderStatusModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Delete Order Status
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
                            Do you really want to delete the order status 
                            <strong id="deleteStatusName" class="text-danger"></strong>?
                        </p>
                        
                        <div class="item-info-preview bg-light p-3 rounded mb-3">
                            <div class="info-row">
                                <span class="info-label">Orders using this status:</span>
                                <span class="info-value" id="deleteOrderCount">0</span>
                            </div>
                        </div>
                        
                        <div id="deleteWarning" class="alert alert-warning" style="display: none;">
                            <i class="fas fa-exclamation-circle"></i>
                            Warning: This status has orders. You cannot delete it until all orders are reassigned.
                        </div>
                        
                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone and may affect related orders.
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
        const deleteModal = document.getElementById('deleteOrderStatusModal');
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

        deleteModal.addEventListener('hidden.bs.modal', function() {
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            deleteConfirmBtn.style.pointerEvents = 'auto';
        });
    });

    function openDeleteModal(statusId, statusData) {
        document.getElementById('deleteStatusName').textContent = statusData.name;
        
        const deleteBtn = document.getElementById('deleteConfirmBtn');
        deleteBtn.href = `{{ route('administrator.order_statuses.delete', ['id' => '__ID__']) }}`.replace('__ID__', statusId);
        
        // Get order count - need to fetch from data or calculate
        const orderCount = statusData.orders_count || 0;
        document.getElementById('deleteOrderCount').textContent = orderCount;
        
        const warningEl = document.getElementById('deleteWarning');
        if (orderCount > 0) {
            warningEl.style.display = 'block';
        } else {
            warningEl.style.display = 'none';
        }
        
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteOrderStatusModal'));
        deleteModal.show();
    }
</script>
