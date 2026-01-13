<div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-labelledby="deleteOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deleteOrderModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Delete Order
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
                            Do you really want to delete 
                            <strong id="deleteOrderName" class="text-danger"></strong>?
                        </p>
                        
                        <div class="item-info-preview bg-light p-3 rounded mb-3">
                            <div class="text-start">
                                <p class="mb-1"><i class="fas fa-user"></i> Customer: <span id="deleteCustomerName"></span></p>
                                <p class="mb-1"><i class="fas fa-dollar-sign"></i> Total: <span id="deleteOrderTotal"></span></p>
                                <p class="mb-1"><i class="fas fa-calendar"></i> Date: <span id="deleteOrderDate"></span></p>
                                <p class="mb-0"><i class="fas fa-box"></i> Items: <span id="deleteOrderItems"></span></p>
                            </div>
                        </div>
                        
                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone. All order items will also be deleted.
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
    function openDeleteModal(orderId, orderData) {
        document.getElementById('deleteOrderName').textContent = 'Order #' + orderId;
        document.getElementById('deleteCustomerName').textContent = orderData.user ? orderData.user.name : 'N/A';
        document.getElementById('deleteOrderTotal').textContent = '$' + parseFloat(orderData.total_amount || 0).toFixed(2);
        document.getElementById('deleteOrderDate').textContent = orderData.created_at ? new Date(orderData.created_at).toLocaleDateString() : 'N/A';
        document.getElementById('deleteOrderItems').textContent = orderData.items ? orderData.items.length : (orderData.items_count || 0);
        
        const deleteBtn = document.getElementById('deleteConfirmBtn');
        //deleteBtn.href = `{{ url('orders/delete') }}/${orderId}`;
        deleteBtn.href = `{{ route('administrator.orders.delete', ['id' => '__ID__']) }}`.replace('__ID__', orderId);
        
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteOrderModal'));
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
