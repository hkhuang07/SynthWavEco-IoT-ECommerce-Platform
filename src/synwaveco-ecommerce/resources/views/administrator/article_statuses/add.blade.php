<div class="modal fade" id="addArticleStatusModal" tabindex="-1" aria-labelledby="addArticleStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addArticleStatusModalLabel">
                    <i class="fas fa-plus-circle"></i> Add New Article Status
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addArticleStatusForm" action="{{ route('administrator.article_statuses.add') }}" method="post">
                    @csrf
                    <div class="form-group mb-4">
                        <label class="form-label" for="name">
                            <i class="fas fa-tag"></i> Status Name
                        </label>
                        <input type="text" class="form-control item-input @error('name', 'add') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" 
                               placeholder="e.g., Draft, Published..." required />
                        @error('name', 'add')
                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="addArticleStatusForm" class="btn btn-action" id="addStatusSubmitBtn">
                    <span class="btn-text">Add Status</span>
                    <span class="btn-loading" style="display: none;"><i class="fas fa-spinner fa-spin"></i> Adding...</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addStatusModalEl = document.getElementById('addArticleStatusModal');
        const addStatusForm = document.getElementById('addArticleStatusForm');
        const addStatusSubmitBtn = document.getElementById('addStatusSubmitBtn');

        if (addStatusModalEl && addStatusForm) {
            addStatusModalEl.addEventListener('hidden.bs.modal', function() {
                addStatusForm.reset();
                const invalidInputs = addStatusForm.querySelectorAll('.is-invalid');
                invalidInputs.forEach(input => input.classList.remove('is-invalid'));
                addStatusSubmitBtn.disabled = false;
                addStatusSubmitBtn.querySelector('.btn-text').style.display = 'inline';
                addStatusSubmitBtn.querySelector('.btn-loading').style.display = 'none';
            });

            addStatusForm.addEventListener('submit', function() {
                addStatusSubmitBtn.disabled = true;
                addStatusSubmitBtn.querySelector('.btn-text').style.display = 'none';
                addStatusSubmitBtn.querySelector('.btn-loading').style.display = 'inline';
            });

            addStatusModalEl.addEventListener('shown.bs.modal', function() {
                const nameInput = document.getElementById('name');
                if (nameInput) nameInput.focus();
            });
        }
    });
</script>