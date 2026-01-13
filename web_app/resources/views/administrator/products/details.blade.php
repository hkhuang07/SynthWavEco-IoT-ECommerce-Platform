<div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="productDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="productDetailModalLabel">
                    <i class="fas fa-box-open"></i>
                    Product Details: <span id="detailProductName"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5 border-end">
                        <div class="text-center mb-3">
                            <div class="detail-image-container mb-3 mx-auto" style="width: 150px; height: 150px; border: 1px solid #ddd; border-radius: 8px;">
                                <img id="detailProductImage" src="" alt="Product Image" class="img-fluid" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                <div id="detailNoImage" class="item-image-placeholder h-100 w-100 d-none" style="display: flex; align-items: center; justify-content: center;"><i class="fas fa-microchip"></i></div>
                            </div>
                        </div>
                        <p><strong>Product ID:</strong> <span id="detailProductId"></span></p>
                        <p><strong>Price:</strong> <span class="text-success fs-5">$<span id="detailProductPrice"></span></span></p>
                        <p><strong>Stock Quantity:</strong> <span id="detailProductStock"></span></p>
                        <p><strong>Category:</strong> <span id="detailCategory"></span></p>
                        <p><strong>Manufacturer:</strong> <span id="detailManufacturer"></span></p>
                    </div>

                    <div class="col-md-7">
                        <h6 class="section-title mb-3"><i class="fas fa-cogs"></i> Technical Specifications</h6>
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <tr><td><strong>CPU:</strong></td><td><span id="detailCpu">N/A</span></td></tr>
                                <tr><td><strong>Memory:</strong></td><td><span id="detailMemory">N/A</span></td></tr>
                                <tr><td><strong>Graphics:</strong></td><td><span id="detailGraphic">N/A</span></td></tr>
                                <tr><td><strong>Power Specs:</strong></td><td><span id="detailPowerSpecs">N/A</span></td></tr>
                            </tbody>
                        </table>
                        
                        <h6 class="section-title mt-4 mb-3"><i class="fas fa-align-left"></i> Description</h6>
                        <div id="detailProductDescription" class="text-muted small"></div>
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
    function openProductDetailsModal(productData) {
        console.log('🔄 Opening product details modal:', productData.name);
        const modalElement = document.getElementById('productDetailModal');
        if (!modalElement) {
            console.error("Product detail modal element not found.");
            return;
        }

        // 1. Cập nhật thông tin cơ bản
        document.getElementById('detailProductName').textContent = productData.name || 'N/A';
        document.getElementById('detailProductId').textContent = productData.id;
        document.getElementById('detailProductPrice').textContent = parseFloat(productData.price).toFixed(2);
        document.getElementById('detailProductStock').textContent = productData.stock_quantity;
        document.getElementById('detailCategory').textContent = productData.category ? productData.category.name : 'N/A';
        document.getElementById('detailManufacturer').textContent = productData.manufacturer ? productData.manufacturer.name : 'N/A';
        document.getElementById('detailProductDescription').innerHTML = productData.description || 'No description available.';

        // 2. Cập nhật thông tin kỹ thuật (details)
        if (productData.details) {
            document.getElementById('detailCpu').textContent = productData.details.cpu || 'N/A';
            document.getElementById('detailMemory').textContent = productData.details.memory || 'N/A';
            document.getElementById('detailGraphic').textContent = productData.details.graphic || 'N/A';
            document.getElementById('detailPowerSpecs').textContent = productData.details.power_specs || 'N/A';
        } else {
             // Reset về N/A nếu details là null
            document.getElementById('detailCpu').textContent = 'N/A';
            document.getElementById('detailMemory').textContent = 'N/A';
            document.getElementById('detailGraphic').textContent = 'N/A';
            document.getElementById('detailPowerSpecs').textContent = 'N/A';
        }
        
        // 3. Xử lý hình ảnh (Avatar)
        const productImg = document.getElementById('detailProductImage');
        const noImagePlaceholder = document.getElementById('detailNoImage');
        let avatarUrl = null;

        if (productData.images && productData.images.length > 0) {
            const avatarImage = productData.images.find(img => img.is_avatar);
            avatarUrl = avatarImage ? avatarImage.url : productData.images[0].url;
        }

        if (avatarUrl) {
            productImg.src = `{{ asset('storage/app/private') }}/${avatarUrl}`;
            productImg.style.display = 'block';
            noImagePlaceholder.classList.add('d-none');
        } else {
            productImg.style.display = 'none';
            noImagePlaceholder.classList.remove('d-none');
            noImagePlaceholder.style.display = 'flex';
        }
        
        // 4. Hiển thị Modal
        const productDetailModal = new bootstrap.Modal(modalElement);
        productDetailModal.show();
    }
</script>