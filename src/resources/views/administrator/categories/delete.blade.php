<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deleteCategoryModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Delete Category
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
                            Do you really want to delete the category
                            <strong id="deleteCategoryName" class="text-danger"></strong>?
                        </p>

                        <div class="item-info-preview bg-light p-3 rounded mb-3" id="deleteCategoryPreview">
                            <div class="row">
                                <div class="col-4">
                                    <div class="preview-logo" id="deleteImagePreview">
                                        <img id="deleteCategoryImage" src="" alt="Category Image" class="delete-preview-logo">
                                        <div id="deleteNoImage" class="no-logo-placeholder">
                                            <i class="fas fa-leaf"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone and may affect related products.
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
        const deleteCategoryModal = document.getElementById('deleteCategoryModal');
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

        deleteCategoryModal.addEventListener('hidden.bs.modal', function() {
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            deleteConfirmBtn.style.pointerEvents = 'auto';
        });
    });

    /*function openDeleteModal(categoryId, categoryData) {
        document.getElementById('deleteCategoryName').textContent = categoryData.name;

        const deleteBtn = document.getElementById('deleteConfirmBtn');
        deleteBtn.href = `{{ route('administrator.categories.delete', ['id' => '__ID__']) }}`.replace('__ID__', categoryId);
        const namePreview = document.getElementById('deleteCategoryNamePreview');
        const categoryImg = document.getElementById('deleteCategoryImage');
        const noImagePlaceholder = document.getElementById('deleteNoImage');

        if (categoryData.image) {
            categoryImg.src = "{{ asset('storage/app/private') }}/" + categoryData.image;
            categoryImg.style.display = 'block';
            noImagePlaceholder.style.display = 'none';
        } else {
            categoryImg.style.display = 'none';
            noImagePlaceholder.style.display = 'flex';
        }

        const deleteModal = new bootstrap.Modal(document.getElementById('deleteCategoryModal'));
        deleteModal.show();
    }*/

    function openDeleteCategoryModal(categoryId, categoryData) {
        console.log('Opening category delete modal for:', categoryData.name);

        try {
            // Update category name
            const categoryNameEl = document.getElementById('deleteCategoryName');
            if (categoryNameEl) {
                categoryNameEl.textContent = categoryData.name || 'Unknown Category';
            }

            // Update delete button href
            const deleteBtn = document.getElementById('deleteConfirmBtn');
            if (deleteBtn) {
                const deleteUrl = `{{ route('administrator.categories.delete', ['id' => '__ID__']) }}`.replace('__ID__', categoryId);
                deleteBtn.href = deleteUrl;
            }

            // Handle category image
            const categoryImg = document.getElementById('deleteCategoryImage');
            const noImagePlaceholder = document.getElementById('deleteNoImage');

            if (categoryImg && noImagePlaceholder) {
                if (categoryData.image) {
                    categoryImg.src = "{{ asset('storage/app/private') }}/" + categoryData.image;
                    categoryImg.style.display = 'block';
                    noImagePlaceholder.style.display = 'none';
                } else {
                    categoryImg.style.display = 'none';
                    noImagePlaceholder.style.display = 'flex';
                }
            }

            // Show modal
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteCategoryModal'));
            deleteModal.show();

        } catch (error) {
            console.error('Error opening category delete modal:', error);
            alert('Error: ' + error.message);
        }
    }
</script>