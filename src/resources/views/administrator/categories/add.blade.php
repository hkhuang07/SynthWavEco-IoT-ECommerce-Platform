<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">
                    <i class="fa-light fa-plus-circle"></i>
                    Add New Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="modalMessages" class="mb-3" style="display: none;">
                    <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="successMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="addCategoryForm" action="{{ route('administrator.categories.add') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-4">
                        <label class="form-label" for="name">
                            <i class="fa-light fa-tag"></i>
                            Category Name
                        </label>
                        <input
                            type="text"
                            class="form-control item-input @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter category name"
                            required />
                        @error('name')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="parent_id">
                            <i class="fa-light fa-folder-tree"></i>
                            Category Parent
                        </label>
                        <select class="form-select item-input @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                            <option value="">-- Select Parent Category --</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('parent_id')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="description">
                            <i class="fa-light fa-align-left"></i>
                            Description
                        </label>
                        <textarea
                            class="form-control item-input item-textarea @error('description') is-invalid @enderror"
                            id="description"
                            name="description"
                            rows="3"
                            placeholder="Enter manufacturer description">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="image">
                            <i class="fa-light fa-image"></i>
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
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="addCategoryForm" class="btn btn-action" id="submitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Add Category</span>
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
        const addCategoryModal = document.getElementById('addCategoryModal');
        const addCategoryForm = document.getElementById('addCategoryForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        addCategoryModal.addEventListener('hidden.bs.modal', function() {
            addCategoryForm.reset();
            const invalidInputs = addCategoryForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        addCategoryForm.addEventListener('submit', function(e) {
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        addCategoryModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('name').focus();
        });
    });
</script>