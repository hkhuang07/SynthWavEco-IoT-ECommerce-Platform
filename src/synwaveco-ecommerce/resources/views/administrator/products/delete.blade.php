<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true" style="z-index: 1061;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i> Confirm Delete Product
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body text-center">
                <div class="delete-icon-container mb-3"><i class="fas fa-trash-alt delete-icon"></i></div>
                <h4 class="delete-title mb-3">Are you sure?</h4>
                <div class="delete-message mb-4">
                    <p>Do you want to delete: <strong id="deleteProductName" class="text-danger"></strong>?</p>
                    <div class="item-info-preview bg-light p-3 rounded mb-3">
                        <div class="row align-items-center text-start">
                            <div class="col-4">
                                <img id="deleteProductPreviewImg" src="" class="img-fluid rounded border shadow-sm">
                                <div id="deleteProductNoImgPlaceholder" class="no-logo-placeholder text-center"><i class="fas fa-microchip"></i></div>
                            </div>
                            <div class="col-8">
                                <p class="mb-1"><strong>Price:</strong> $<span id="deleteProductPriceDisplay">0.00</span></p>
                                <p class="mb-0"><strong>Stock:</strong> <span id="deleteProductStockDisplay">0</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel me-3" data-bs-dismiss="modal">Cancel</button>
                {{-- ĐÃ KIỂM TRA ID: deleteProductConfirmBtnAction --}}
                <a href="#" id="deleteProductConfirmBtnAction" class="btn btn-delete">
                    <span class="btn-text">Yes, Delete It</span>
                    <span class="btn-loading" style="display: none;"><i class="fas fa-spinner fa-spin"></i> Deleting...</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function showDeleteProductModal(productId, productData) {
        console.log('📦 Opening Delete Modal for Product:', productData.name);

        try {
            // 1. Gán text (Sử dụng ID duy nhất)
            const deleteProductName = document.getElementById('deleteProductName');
            const deleteProductPriceDisplay = document.getElementById('deleteProductPriceDisplay');
            const deleteProductStockDisplay = document.getElementById('deleteProductStockDisplay');

            if (deleteProductName) deleteProductName.textContent = productData.name || 'Unknown Product';
            if (deleteProductPriceDisplay) deleteProductPriceDisplay.textContent = parseFloat(productData.price || 0).toFixed(2);
            if (deleteProductStockDisplay) deleteProductStockDisplay.textContent = productData.stock_quantity || 0;

            // 2. Gán link Route (Sử dụng window.location.origin để linh hoạt)
            const deleteBtn = document.getElementById('deleteProductConfirmBtnAction');
            if (deleteBtn) {
                const baseUrl = window.location.origin;
                const path = '/synwaveco-ecommerce/administrator/products/delete/' + productId;
                deleteBtn.href = baseUrl + path;
                console.log('🗑️ Delete URL:', deleteBtn.href);
            } else {
                console.error('❌ Error: deleteProductConfirmBtnAction not found!');
            }

            // 3. Xử lý ảnh preview
            const img = document.getElementById('deleteProductPreviewImg');
            const noImg = document.getElementById('deleteProductNoImgPlaceholder');
            let avatarUrl = null;

            if (productData.images && Array.isArray(productData.images) && productData.images.length > 0) {
                const avatar = productData.images.find(i => i && i.is_avatar);
                avatarUrl = avatar && avatar.url ? avatar.url : (productData.images[0] && productData.images[0].url ? productData.images[0].url : null);
            }

            const baseStorageUrl = window.location.origin + '/synwaveco-ecommerce/storage/app/private/';

            if (avatarUrl && img) {
                img.src = baseStorageUrl + avatarUrl;
                img.style.display = 'block';
                img.onerror = function() {
                    this.style.display = 'none';
                    if (noImg) noImg.style.display = 'flex';
                };
                if (noImg) noImg.style.display = 'none';
            } else if (img) {
                img.style.display = 'none';
                if (noImg) noImg.style.display = 'flex';
            }

            // 4. Kích hoạt Modal
            const modalEl = document.getElementById('deleteProductModal');
            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl, {
                    backdrop: true,
                    keyboard: true,
                    focus: true
                });
                modal.show();
                console.log('✅ Delete Modal shown successfully');
            } else {
                console.error('❌ Error: deleteProductModal element not found!');
            }

        } catch (error) {
            console.error("❌ Lỗi JS trong showDeleteProductModal:", error);
            alert('Có lỗi xảy ra khi mở modal xóa. Vui lòng thử lại.');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const confirmBtn = document.getElementById('deleteProductConfirmBtnAction');
        if (confirmBtn) {
            confirmBtn.addEventListener('click', function(e) {
                // Kiểm tra nếu đã trong trạng thái loading thì không làm gì cả
                if (this.style.pointerEvents === 'none') {
                    e.preventDefault();
                    return;
                }

                this.querySelector('.btn-text').style.display = 'none';
                const loadingSpan = this.querySelector('.btn-loading');
                if (loadingSpan) loadingSpan.style.display = 'inline';
                this.style.pointerEvents = 'none';
                this.style.opacity = '0.7';

                console.log('🗑️ Delete button clicked, processing...');
            });
        }

        // Debug: Log khi modal được hiển thị
        const modalEl = document.getElementById('deleteProductModal');
        if (modalEl) {
            modalEl.addEventListener('shown.bs.modal', function() {
                console.log('✅ Bootstrap modal shown event fired');
            });

            modalEl.addEventListener('show.bs.modal', function(e) {
                console.log('🔄 Bootstrap modal show event fired');
            });

            modalEl.addEventListener('hidden.bs.modal', function() {
                console.log('🔒 Bootstrap modal hidden event fired');
            });
        }
    });
</script>