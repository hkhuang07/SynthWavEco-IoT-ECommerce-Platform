<div class="modal fade" id="updateArticleTypeModal" tabindex="-1" aria-labelledby="updateArticleTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateArticleTypeModalLabel">
                    <i class="fas fa-edit"></i> Edit Article Type
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="updateArticleTypeForm" action="" method="post">
                    @csrf
                    <input type="hidden" id="updateArticleTypeId" name="type_id" value="">

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateName">
                            <i class="fas fa-tag"></i> Type Name
                        </label>
                        <input type="text" class="form-control item-input @error('name', 'update') is-invalid @enderror"
                               id="updateName" name="name" required />
                        @error('name', 'update')
                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="updateArticleTypeForm" class="btn btn-action" id="updateTypeSubmitBtn">
                    <span class="btn-text">Update Type</span>
                    <span class="btn-loading" style="display: none;"><i class="fas fa-spinner fa-spin"></i> Updating...</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateTypeModalEl = document.getElementById('updateArticleTypeModal');
        const updateTypeForm = document.getElementById('updateArticleTypeForm');
        const updateTypeSubmitBtn = document.getElementById('updateTypeSubmitBtn');

        if (updateTypeModalEl && updateTypeForm) {
            updateTypeModalEl.addEventListener('hidden.bs.modal', function() {
                updateTypeForm.reset();
                updateTypeSubmitBtn.disabled = false;
                updateTypeSubmitBtn.querySelector('.btn-text').style.display = 'inline';
                updateTypeSubmitBtn.querySelector('.btn-loading').style.display = 'none';
            });

            updateTypeForm.addEventListener('submit', function() {
                updateTypeSubmitBtn.disabled = true;
                updateTypeSubmitBtn.querySelector('.btn-text').style.display = 'none';
                updateTypeSubmitBtn.querySelector('.btn-loading').style.display = 'inline';
            });
        }
    });

    function openUpdateModal(typeId, typeData) {
        const updateForm = document.getElementById('updateArticleTypeForm');
        updateForm.action = `{{ route('administrator.article_types.update', ['id' => '__ID__']) }}`.replace('__ID__', typeId);
        
        document.getElementById('updateArticleTypeId').value = typeId;
        document.getElementById('updateName').value = typeData.name || '';
        
        const modal = new bootstrap.Modal(document.getElementById('updateArticleTypeModal'));
        modal.show();
    }
</script>