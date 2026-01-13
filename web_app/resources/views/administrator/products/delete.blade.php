<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Delete Product
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
                            Do you really want to delete the product 
                            <strong id="deleteProductName" class="text-danger"></strong>?
                        </p>
                        
                        <div class="item-info-preview bg-light p-3 rounded mb-3" id="deleteProductPreview">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <div class="preview-logo" id="deleteImagePreview">
                                        <img id="deleteProductImage" src="" alt="Product Image" class="delete-preview-logo">
                                        <div id="deleteNoImage" class="no-logo-placeholder">
                                            <i class="fas fa-microchip"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8 text-start">
                                    <p class="mb-1"><strong>Price:</strong> $<span id="deleteProductPrice"></span></p>
                                    <p class="mb-0"><strong>Stock:</strong> <span id="deleteProductStock"></span></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-circle"></i>
                            This will also delete all product images, details, and related data.
                        </div>
                        
                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone.
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel me-3" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <a href="#" id="deleteProductConfirmBtn" class="btn btn-delete">
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
    // 💥 ĐỔI TÊN HÀM CHÍNH openDeleteModalFunction
    function openDeleteModalFunction(productId, productData) { // Tên mới
        document.getElementById('deleteProductName').textContent = productData.name;
        document.getElementById('deleteProductPrice').textContent = parseFloat(productData.price).toFixed(2);
        document.getElementById('deleteProductStock').textContent = productData.stock_quantity;
        
        const deleteBtn = document.getElementById('deleteProductConfirmBtn');
        deleteBtn.href = `{{ route('administrator.products.delete', ['id' => '__ID__']) }}`.replace('__ID__', productId);
        const productImg = document.getElementById('deleteProductImage');
        const noImagePlaceholder = document.getElementById('deleteNoImage');
        
        // Find avatar image
        let avatarUrl = null;
        if (productData.images && productData.images.length > 0) {
            const avatarImage = productData.images.find(img => img.is_avatar);
            if (avatarImage) {
                avatarUrl = avatarImage.url;
            } else {
                avatarUrl = productData.images[0].url;
            }
        }
        
        if (avatarUrl) {
            productImg.src = "{{ asset('storage/app/private') }}/" + avatarUrl;
            productImg.style.display = 'block';
            noImagePlaceholder.style.display = 'none';
        } else {
            productImg.style.display = 'none';
            noImagePlaceholder.style.display = 'flex';
        }
        
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteProductModal'));
        deleteModal.show();
    }

    // 💥 KHÔI PHỤC LOGIC DOMContentLoaded CHO NÚT XÓA (đảm bảo nút hoạt động)
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteProductModal');
        const deleteConfirmBtn = document.getElementById('deleteProductConfirmBtn');
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
</script>