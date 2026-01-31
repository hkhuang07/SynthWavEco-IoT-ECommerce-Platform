<div class="modal fade" id="updateArticleStatusModal" tabindex="-1" aria-labelledby="updateArticleStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateArticleStatusModalLabel">
                    <i class="fas fa-edit"></i>
                    Edit Article Status
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="updateArticleStatusForm" action="" method="post">
                    @csrf
                    <input type="hidden" id="updateArticleStatusId" name="status_id" value="">

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateName">
                            <i class="fas fa-tag"></i>
                            Status Name
                        </label>
                        <input
                            type="text"
                            class="form-control item-input @error('name', 'update') is-invalid @enderror"
                            id="updateName"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter status name"
                            maxlength="50"
                            required />
                        @error('name', 'update')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" form="updateArticleStatusForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fas fa-save"></i>
                    <span class="btn-text">Update Status</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Updating...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateModal = document.getElementById('updateArticleStatusModal');
        const updateForm = document.getElementById('updateArticleStatusForm');
        const updateSubmitBtn = document.getElementById('updateSubmitBtn');
        const btnText = updateSubmitBtn.querySelector('.btn-text');
        const btnLoading = updateSubmitBtn.querySelector('.btn-loading');

        updateModal.addEventListener('hidden.bs.modal', function() {
            updateForm.reset();
            const invalidInputs = updateForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            updateSubmitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        updateForm.addEventListener('submit', function() {
            updateSubmitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        updateModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('updateName').focus();
        });
    });


    function openUpdateModal(statusId, statusData) {
        const updateForm = document.getElementById('updateArticleStatusForm');
        // Cập nhật Route trỏ đến article_statuses.update
        updateForm.action = `{{ route('administrator.article_statuses.update', ['id' => '__ID__']) }}`.replace('__ID__', statusId);
        
        document.getElementById('updateArticleStatusId').value = statusId;
        document.getElementById('updateName').value = statusData.name || '';
        
        const modal = new bootstrap.Modal(document.getElementById('updateArticleStatusModal'));
        modal.show();
    }
</script>