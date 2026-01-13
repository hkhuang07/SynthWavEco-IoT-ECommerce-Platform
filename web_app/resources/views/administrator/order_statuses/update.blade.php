<div class="modal fade" id="updateOrderStatusModal" tabindex="-1" aria-labelledby="updateOrderStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateOrderStatusModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit Order Status
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="updateModalMessages" class="mb-3" style="display: none;">
                    <div id="updateErrorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="updateSuccessMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="updateOrderStatusForm" action="" method="post">
                    @csrf
                    <input type="hidden" id="updateStatusId" name="status_id" value="">

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateName">
                            <i class="fa-light fa-tag"></i>
                            Status Name
                        </label>
                        <input
                            type="text"
                            class="form-control item-input @error('name') is-invalid @enderror"
                            id="updateName"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter status name"
                            maxlength="50"
                            required />
                        @error('name','update')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                        <small class="form-text text-muted">Maximum 50 characters. Must be unique.</small>
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="updateOrderStatusForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update Status</span>
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
        const updateModal = document.getElementById('updateOrderStatusModal');
        const updateForm = document.getElementById('updateOrderStatusForm');
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

        updateForm.addEventListener('submit', function(e) {
            updateSubmitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        updateModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('updateName').focus();
        });
    });

    function openUpdateModal(statusId, statusData) {
        const updateForm = document.getElementById('updateOrderStatusForm');
        updateForm.action = `{{ route('administrator.order_statuses.update', ['id' => '__ID__']) }}`.replace('__ID__', statusId);
        
        document.getElementById('updateStatusId').value = statusId;
        document.getElementById('updateName').value = statusData.name || '';
        
        const updateModal = new bootstrap.Modal(document.getElementById('updateOrderStatusModal'));
        updateModal.show();
    }
</script>
