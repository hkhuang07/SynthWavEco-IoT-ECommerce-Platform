<div class="modal fade" id="updateRoleModal" tabindex="-1" aria-labelledby="updateRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateRoleModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit Role
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="updateRoleForm" action="" method="post">
                    @csrf
                    <input type="hidden" id="update_role_id" name="role_id" value="">

                    <div class="form-group mb-4">
                        <label class="form-label" for="update_name">
                            <i class="fa-light fa-shield-alt"></i>
                            Role Name
                        </label>
                        <input
                            type="text"
                            class="form-control item-input @error('name', 'update') is-invalid @enderror"
                            id="update_name"
                            name="name"
                            placeholder="Enter role name"
                            maxlength="50"
                            required />
                        @error('name', 'update')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="update_description">
                            <i class="fa-light fa-align-left"></i>
                            Description
                        </label>
                        <textarea
                            class="form-control item-input item-textarea @error('description', 'update') is-invalid @enderror"
                            id="update_description"
                            name="description"
                            rows="3"
                            placeholder="Enter role description"></textarea>
                        @error('description', 'update')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="updateRoleForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update Role</span>
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
        const updateRoleModal = document.getElementById('updateRoleModal');
        const updateRoleForm = document.getElementById('updateRoleForm');
        const updateSubmitBtn = document.getElementById('updateSubmitBtn');
        const btnText = updateSubmitBtn.querySelector('.btn-text');
        const btnLoading = updateSubmitBtn.querySelector('.btn-loading');

        updateRoleModal.addEventListener('hidden.bs.modal', function() {
            updateRoleForm.reset();
            const invalidInputs = updateRoleForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            updateSubmitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        updateRoleForm.addEventListener('submit', function(e) {
            updateSubmitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        updateRoleModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('update_name').focus();
        });
    });

    function openUpdateModal(roleId, roleData) {
        const updateForm = document.getElementById('updateRoleForm');
        updateForm.action = `{{ route('administrator.roles.update', ['id' => '__ID__']) }}`.replace('__ID__', roleId);
        
        document.getElementById('update_role_id').value = roleId;
        document.getElementById('update_name').value = roleData.name || '';
        document.getElementById('update_description').value = roleData.description || '';
        
        const updateModal = new bootstrap.Modal(document.getElementById('updateRoleModal'));
        updateModal.show();
    }
</script>
