<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addProductModalLabel">
                    <i class="fa-light fa-plus-circle"></i>
                    Add New Product
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="modalMessages" class="mb-3" style="display: none;">
                    <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="successMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="addProductForm" action="{{ route('administrator.products.add') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <!-- Basic Information Section -->
                    <div class="form-section mb-4">
                        <h6 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Basic Information
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="name">
                                        <i class="fa-light fa-tag"></i>
                                        Product Name <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control item-input @error('name') is-invalid @enderror"
                                        id="name"
                                        name="name"
                                        value="{{ old('name') }}"
                                        placeholder="Enter product name"
                                        maxlength="200"
                                        required />
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="category_id">
                                        <i class="fa-light fa-folder"></i>
                                        Category <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select item-input @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                        <option value="">-- Select Category --</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="manufacturer_id">
                                        <i class="fa-light fa-industry"></i>
                                        Manufacturer <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select item-input @error('manufacturer_id') is-invalid @enderror" id="manufacturer_id" name="manufacturer_id" required>
                                        <option value="">-- Select Manufacturer --</option>
                                        @foreach($manufacturers as $manufacturer)
                                        <option value="{{ $manufacturer->id }}" {{ old('manufacturer_id') == $manufacturer->id ? 'selected' : '' }}>{{ $manufacturer->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('manufacturer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="price">
                                        <i class="fa-light fa-dollar-sign"></i>
                                        Price <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        class="form-control item-input @error('price') is-invalid @enderror"
                                        id="price"
                                        name="price"
                                        value="{{ old('price', '0.00') }}"
                                        placeholder="0.00"
                                        required />
                                    @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="stock_quantity">
                                        <i class="fa-light fa-cubes"></i>
                                        Stock Qty <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="number"
                                        min="0"
                                        class="form-control item-input @error('stock_quantity') is-invalid @enderror"
                                        id="stock_quantity"
                                        name="stock_quantity"
                                        value="{{ old('stock_quantity', '0') }}"
                                        placeholder="0"
                                        required />
                                    @error('stock_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="description">
                                <i class="fa-light fa-align-left"></i>
                                Description
                            </label>
                            <textarea
                                class="form-control item-input item-textarea @error('description') is-invalid @enderror"
                                id="description"
                                name="description"
                                rows="3"
                                placeholder="Enter product description">{{ old('description') }}</textarea>
                            @error('description')
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
                                    <label class="form-label" for="memory">
                                        <i class="fa-light fa-memory"></i>
                                        Memory
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control item-input @error('memory') is-invalid @enderror"
                                        id="memory"
                                        name="memory"
                                        value="{{ old('memory') }}"
                                        placeholder="e.g., 8GB DDR4"
                                        maxlength="50" />
                                    @error('memory')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="cpu">
                                        <i class="fa-light fa-microchip"></i>
                                        CPU
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control item-input @error('cpu') is-invalid @enderror"
                                        id="cpu"
                                        name="cpu"
                                        value="{{ old('cpu') }}"
                                        placeholder="e.g., ARM Cortex-A72"
                                        maxlength="50" />
                                    @error('cpu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="graphic">
                                        <i class="fa-light fa-tv"></i>
                                        Graphics
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control item-input @error('graphic') is-invalid @enderror"
                                        id="graphic"
                                        name="graphic"
                                        value="{{ old('graphic') }}"
                                        placeholder="e.g., Integrated GPU"
                                        maxlength="50" />
                                    @error('graphic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="power_specs">
                                        <i class="fa-light fa-bolt"></i>
                                        Power Specs
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control item-input @error('power_specs') is-invalid @enderror"
                                        id="power_specs"
                                        name="power_specs"
                                        value="{{ old('power_specs') }}"
                                        placeholder="e.g., 5V/3A USB-C"
                                        maxlength="100" />
                                    @error('power_specs')
                                    <div class="invalid-feedback">{{ $message }}</div>
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
                            <label class="form-label" for="image">
                                <i class="fa-light fa-link"></i>
                                Image URL
                            </label>
                            <input
                                type="file"
                                class="form-control item-input @error('image') is-invalid @enderror"
                                id="image"
                                name="image"
                                value="{{ old('image') }}"
                                placeholder="Enter image URL" />
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">This will be set as the main product image (avatar)</small>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="addProductForm" class="btn btn-action" id="addSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Add Product</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fa-light fa-spinner fa-spin"></i>
                        Adding...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addModal = document.getElementById('addProductModal');
        const addForm = document.getElementById('addProductForm');
        const submitBtn = document.getElementById('addSubmitBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        addModal.addEventListener('hidden.bs.modal', function() {
            addForm.reset();
            const invalidInputs = addForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        addForm.addEventListener('submit', function(e) {
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        addModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('name').focus();
        });
    });
</script>
