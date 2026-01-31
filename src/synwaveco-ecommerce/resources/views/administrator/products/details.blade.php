<div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="productDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="productDetailModalLabel">
                    <i class="fas fa-box"></i> Product Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 border-end">
                        <div class="text-center mb-4">
                            <img id="detailProductImage" src="" class="img-fluid rounded shadow mb-3" style="max-height: 200px; display: none;">
                            <div id="detailProductNoImage" class="bg-light p-5 rounded"><i class="fas fa-image fa-3x text-muted"></i></div>
                        </div>
                        <div class="product-meta p-3 bg-light rounded">
                            <p><strong>Category:</strong> <span id="detailProductCategory" class="text-primary"></span></p>
                            <p><strong>Manufacturer:</strong> <span id="detailProductManufacturer"></span></p>
                            <p><strong>Price:</strong> <span id="detailProductPrice" class="text-success fw-bold"></span></p>
                            <p><strong>Stock:</strong> <span id="detailProductStock"></span></p>
                            <p><strong>ID:</strong> <span id="detailProductId"></span></p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h2 id="detailProductTitle" class="fw-bold mb-3"></h2>
                        <div class="summary-box border-start border-4 border-primary p-3 bg-light mb-4">
                            <strong>Description:</strong>
                            <p id="detailProductDescription" class="mb-0 text-muted"></p>
                        </div>
                        <div class="product-details-section">
                            <h5 class="mb-3"><i class="fas fa-cogs"></i> Technical Specifications</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Memory:</strong> <span id="detailProductMemory">N/A</span></p>
                                    <p><strong>CPU:</strong> <span id="detailProductCpu">N/A</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Graphics:</strong> <span id="detailProductGraphic">N/A</span></p>
                                    <p><strong>Power:</strong> <span id="detailProductPower">N/A</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    /**
     * Hiển thị Modal Chi tiết Sản phẩm
     * @param {object} productData - Object chứa thông tin sản phẩm đầy đủ
     */
    function openProductDetailsModal(productData) {
        console.log('👁️ [DETAILS_MODAL] Opening Product Details Modal:', productData.name || 'Unknown');
        
        try {
            // 1. Gán thông tin cơ bản
            const title = document.getElementById('detailProductTitle');
            const description = document.getElementById('detailProductDescription');
            const price = document.getElementById('detailProductPrice');
            const stock = document.getElementById('detailProductStock');
            const category = document.getElementById('detailProductCategory');
            const manufacturer = document.getElementById('detailProductManufacturer');
            const productId = document.getElementById('detailProductId');
            
            if (title) title.textContent = productData.name || 'Unknown Product';
            if (description) description.textContent = productData.description || 'No description available.';
            if (price) price.textContent = '$' + parseFloat(productData.price || 0).toFixed(2);
            if (stock) {
                stock.textContent = productData.stock_quantity || 0;
                stock.className = productData.stock_quantity > 0 ? 'text-success' : 'text-danger';
            }
            if (category) category.textContent = productData.category ? productData.category.name : 'N/A';
            if (manufacturer) manufacturer.textContent = productData.manufacturer ? productData.manufacturer.name : 'N/A';
            if (productId) productId.textContent = productData.id || 'N/A';
            
            // 2. Gán thông tin kỹ thuật (nếu có)
            if (productData.details) {
                document.getElementById('detailProductMemory').textContent = productData.details.memory || 'N/A';
                document.getElementById('detailProductCpu').textContent = productData.details.cpu || 'N/A';
                document.getElementById('detailProductGraphic').textContent = productData.details.graphic || 'N/A';
                document.getElementById('detailProductPower').textContent = productData.details.power_specs || 'N/A';
            } else {
                document.getElementById('detailProductMemory').textContent = 'N/A';
                document.getElementById('detailProductCpu').textContent = 'N/A';
                document.getElementById('detailProductGraphic').textContent = 'N/A';
                document.getElementById('detailProductPower').textContent = 'N/A';
            }
            
            // 3. Xử lý ảnh sản phẩm
            const img = document.getElementById('detailProductImage');
            const noImg = document.getElementById('detailProductNoImage');
            let avatarUrl = null;
            
            if (productData.images && Array.isArray(productData.images) && productData.images.length > 0) {
                const avatar = productData.images.find(img => img && img.is_avatar);
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
            
            // 4. Hiển thị Modal
            const modalEl = document.getElementById('productDetailModal');
            if (modalEl) {
                const existingModal = bootstrap.Modal.getInstance(modalEl);
                if (existingModal) {
                    existingModal.dispose();
                }
                
                const modal = new bootstrap.Modal(modalEl, {
                    backdrop: true,
                    keyboard: true,
                    focus: true
                });
                modal.show();
                console.log('✅ [DETAILS_MODAL] Product details modal shown successfully');
            } else {
                console.error('❌ [DETAILS_MODAL] productDetailModal element not found!');
            }
            
        } catch (error) {
            console.error('❌ [DETAILS_MODAL] Error in openProductDetailsModal:', error);
        }
    }

    // Debug khi trang đã tải xong
    document.addEventListener('DOMContentLoaded', function() {
        console.log('👁️ [DETAILS_MODAL] Product details modal script loaded');
    });
</script>   