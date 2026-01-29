<div class="modal fade" id="updateCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateCategoryModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="updateModalMessages" class="mb-3" style="display: none;">
                    <div id="updateErrorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="updateSuccessMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="updateCategoryForm" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="updateCategoryId" name="category_id" value="">

                    <div class="form-group mb-4">
                        <label class="form-label" for="name">
                            <i class="fa-light fa-tag"></i>
                            Category Name
                        </label>
                        <input
                            type="text"
                            class="form-control item-input @error('name') is-invalid @enderror"
                            id="updateName"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter category name"
                            required />
                        @error('name', 'update')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateParentId">
                            <i class="fa-light fa-folder-tree"></i>
                            Category Parent
                        </label>
                        <select class="form-select item-input" id="updateParentId" name="parent_id">
                            <option value="">-- Select Parent Category --</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateDescription">
                            <i class="fa-light fa-align-left"></i>
                            Description
                        </label>
                        <textarea
                            class="form-control item-input item-textarea"
                            id="updateDescription"
                            name="description"
                            rows="3"
                            placeholder="Enter manufacturer description"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="image">
                            <i class="fa-light fa-image"></i>
                            Image URL
                        </label>
                        @if(!empty($categories->image))
                        <img class="d-block rounded img-thumbnail" src="{{ asset('storage/app/private/'. $categories->image) }}" width="100" />
                        <small class="form-text text-muted">Leave empty to keep current image</small>
                        @endif
                        <input
                            type="file"
                            class="form-control item-input @error('image') is-invalid @enderror"
                            id="image"
                            name="image"
                            placeholder="Enter image URL" />
                        @error('image', 'update')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                        <div id="currentImagePreview" class="mt-3" style="display: none;">
                            <label class="form-label">Current Image:</label>
                            <div class="current-logo-container">
                                <img id="currentImage" src="" alt="Current Image" class="current-logo-preview">
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
                <button type="submit" form="updateCategoryForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update Category</span>
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
    document.addEventListener('DOMContentLoaded', function() {
        const updateCategoryModal = document.getElementById('updateCategoryModal');
        const updateCategoryForm = document.getElementById('updateCategoryForm');
        const updateSubmitBtn = document.getElementById('updateSubmitBtn');
        const btnText = updateSubmitBtn.querySelector('.btn-text');
        const btnLoading = updateSubmitBtn.querySelector('.btn-loading');

        updateCategoryModal.addEventListener('hidden.bs.modal', function() {
            updateCategoryForm.reset();
            const invalidInputs = updateCategoryForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            document.getElementById('currentImagePreview').style.display = 'none';
            updateSubmitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        updateCategoryForm.addEventListener('submit', function(e) {
            updateSubmitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        updateCategoryModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('updateName').focus();
        });
    });

    function openUpdateModal(categoryId, categoryData) {
        const updateForm = document.getElementById('updateCategoryForm');
        updateForm.action = `{{ route('administrator.categories.update', ['id' => '__ID__']) }}`.replace('__ID__', categoryId);

        document.getElementById('updateCategoryId').value = categoryId;
        document.getElementById('updateName').value = categoryData.name || '';
        document.getElementById('updateParentId').value = categoryData.parent_id || '';
        document.getElementById('updateDescription').value = categoryData.description || '';
        //document.getElementById('image').value = categoryData.image || '';

        const currentImagePreview = document.getElementById('currentImagePreview');
        const currentImage = document.getElementById('currentImage');

        if (categoryData.image) {
            currentImage.src = "{{ asset('storage/app/private') }}/" + categoryData.image;
            currentImagePreview.style.display = 'block';
        } else {
            currentImagePreview.style.display = 'none';
        }

        const updateModal = new bootstrap.Modal(document.getElementById('updateCategoryModal'));
        updateModal.show();
    }
</script>