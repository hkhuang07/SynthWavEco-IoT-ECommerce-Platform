<div class="modal fade" id="updateProductModal" tabindex="-1" aria-labelledby="updateProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateProductModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit Product
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="updateModalMessages" class="mb-3" style="display: none;">
                    <div id="updateErrorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="updateSuccessMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="updateProductForm" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="updateProductId" name="product_id" value="">

                    <!-- Basic Information Section -->
                    <div class="form-section mb-4">
                        <h6 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Basic Information
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="updateName">
                                        <i class="fa-light fa-tag"></i>
                                        Product Name <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control item-input @error('name', 'update') is-invalid @enderror"
                                        id="updateName"
                                        name="name"
                                        placeholder="Enter product name"
                                        maxlength="200"
                                        required />
                                    @error('name', 'update')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="updateCategoryId">
                                        <i class="fa-light fa-folder"></i>
                                        Category <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select item-input" id="updateCategoryId" name="category_id" required>
                                        <option value="">-- Select Category --</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="updateManufacturerId">
                                        <i class="fa-light fa-industry"></i>
                                        Manufacturer <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select item-input" id="updateManufacturerId" name="manufacturer_id" required>
                                        <option value="">-- Select Manufacturer --</option>
                                        @foreach($manufacturers as $manufacturer)
                                        <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="updatePrice">
                                        <i class="fa-light fa-dollar-sign"></i>
                                        Price <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        class="form-control item-input @error('price', 'update') is-invalid @enderror"
                                        id="updatePrice"
                                        name="price"
                                        placeholder="0.00"
                                        required />
                                    @error('price', 'update')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="updateStockQuantity">
                                        <i class="fa-light fa-cubes"></i>
                                        Stock Qty <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="number"
                                        min="0"
                                        class="form-control item-input @error('stock_quantity', 'update') is-invalid @enderror"
                                        id="updateStockQuantity"
                                        name="stock_quantity"
                                        placeholder="0"
                                        required />
                                    @error('stock_quantity', 'update')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="updateDescription">
                                <i class="fa-light fa-align-left"></i>
                                Description
                            </label>
                            <textarea
                                class="form-control item-input item-textarea @error('description', 'update') is-invalid @enderror"
                                id="updateDescription"
                                name="description"
                                rows="3"
                                placeholder="Enter product description"></textarea>
                            @error('description', 'update')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Product Details Section -->
                    <div class="form-section mb-4">
                        <h6 class="section-title">
                            <i class="fas fa-cogs"></i>
                            Technical Specifications
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="updateMemory">
                                        <i class="fa-light fa-memory"></i>
                                        Memory
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control item-input @error('memory', 'update') is-invalid @enderror"
                                        id="updateMemory"
                                        name="memory"
                                        placeholder="e.g., 8GB DDR4"
                                        maxlength="50" />
                                    @error('memory', 'update')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="updateCpu">
                                            <i class="fa-light fa-microchip"></i>
                                            CPU
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control item-input @error('cpu', 'update') is-invalid @enderror"
                                            id="updateCpu"
                                            name="cpu"
                                            placeholder="e.g., ARM Cortex-A72"
                                            maxlength="50" />
                                        @error('cpu', 'update')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="updateGraphic">
                                            <i class="fa-light fa-tv"></i>
                                            Graphics
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control item-input @error('graphic', 'update') is-invalid @enderror"
                                            id="updateGraphic"
                                            name="graphic"
                                            placeholder="e.g., Integrated GPU"
                                            maxlength="50" />
                                        @error('graphic', 'update')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="updatePowerSpecs">
                                            <i class="fa-light fa-bolt"></i>
                                            Power Specs
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control item-input @error('power_specs', 'update') is-invalid @enderror"
                                            id="updatePowerSpecs"
                                            name="power_specs"
                                            placeholder="e.g., 5V/3A USB-C"
                                            maxlength="100" />
                                        @error('power_specs', 'update')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Image Section -->
                        <div class="form-section mb-4">
                            <h6 class="section-title">
                                <i class="fas fa-image"></i>
                                Product Image
                            </h6>
                            <div class="form-group mb-3">
                                <label class="form-label" for="updateImageUrl">
                                    <i class="fa-light fa-link"></i>
                                    Image URL
                                </label>
                                <input
                                    type="file"
                                    class="form-control item-input @error('image', 'update') is-invalid @enderror"
                                    id="updateImageUrl"
                                    name="image"
                                    placeholder="Enter image URL" />
                                @error('image', 'update')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                                <small class="form-text text-muted">Leave empty to keep current image</small>
                            </div>

                            <div id="currentProductImagePreview" class="mt-3" style="display: none;">
                                <label class="form-label">Current Image:</label>
                                <div class="current-logo-container">
                                    <img id="currentProductImage" src="" alt="Current Product Image" class="current-logo-preview">
                                </div>
                            </div>
                        </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="updateProductForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update Product</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fa-light fa-spinner fa-spin"></i>
                        Updating...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    // 💥 ĐỔI TÊN HÀM CHÍNH
    function openUpdateModalFunction(productId, productData) { // Tên mới
        const updateForm = document.getElementById('updateProductForm');
        updateForm.action = `{{ route('administrator.products.update', ['id' => '__ID__']) }}`.replace('__ID__', productId);

        // Basic info
        document.getElementById('updateProductId').value = productId;
        document.getElementById('updateName').value = productData.name || '';
        document.getElementById('updateCategoryId').value = productData.category_id || '';
        document.getElementById('updateManufacturerId').value = productData.manufacturer_id || '';
        document.getElementById('updatePrice').value = productData.price || '0.00';
        document.getElementById('updateStockQuantity').value = productData.stock_quantity || 0;
        document.getElementById('updateDescription').value = productData.description || '';

        // Product details
        if (productData.details) {
            document.getElementById('updateMemory').value = productData.details.memory || '';
            document.getElementById('updateCpu').value = productData.details.cpu || '';
            document.getElementById('updateGraphic').value = productData.details.graphic || '';
            document.getElementById('updatePowerSpecs').value = productData.details.power_specs || '';
        } else {
             // Reset về N/A nếu details là null
             document.getElementById('updateMemory').value = '';
             document.getElementById('updateCpu').value = '';
             document.getElementById('updateGraphic').value = '';
             document.getElementById('updatePowerSpecs').value = '';
        }

        // Product image (Giữ nguyên logic)
        const currentImagePreview = document.getElementById('currentProductImagePreview');
        const currentImage = document.getElementById('currentProductImage');
        let avatarUrl = null;
        if (productData.images && productData.images.length > 0) {
            const avatarImage = productData.images.find(img => img.is_avatar);
            avatarUrl = avatarImage ? avatarImage.url : productData.images[0].url;
        }

        if (avatarUrl) {
            currentImage.src = "{{ asset('storage/app/private') }}/" + avatarUrl;
            currentImagePreview.style.display = 'block';
        } else {
            currentImagePreview.style.display = 'none';
        }

        const updateModal = new bootstrap.Modal(document.getElementById('updateProductModal'));
        updateModal.show();
    }
</script>