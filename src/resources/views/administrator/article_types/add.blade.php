<div class="modal fade" id="addArticleTypeModal" tabindex="-1" aria-labelledby="addArticleTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addArticleTypeModalLabel">
                    <i class="fas fa-plus-circle"></i> Add New Article Type
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addArticleTypeForm" action="{{ route('administrator.article_types.add') }}" method="post">
                    @csrf
                    <div class="form-group mb-4">
                        <label class="form-label" for="name">
                            <i class="fas fa-tag"></i> Type Name
                        </label>
                        <input type="text" class="form-control item-input @error('name', 'add') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" 
                               placeholder="e.g., News, Research, Tutorial..." required />
                        @error('name', 'add')
                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="addArticleTypeForm" class="btn btn-action" id="addTypeSubmitBtn">
                    <span class="btn-text">Add Type</span>
                    <span class="btn-loading" style="display: none;"><i class="fas fa-spinner fa-spin"></i> Adding...</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addTypeModalEl = document.getElementById('addArticleTypeModal');
        const addTypeForm = document.getElementById('addArticleTypeForm');
        const addTypeSubmitBtn = document.getElementById('addTypeSubmitBtn');

        if (addTypeModalEl && addTypeForm) {
            addTypeModalEl.addEventListener('hidden.bs.modal', function() {
                addTypeForm.reset();
                const invalidInputs = addTypeForm.querySelectorAll('.is-invalid');
                invalidInputs.forEach(input => input.classList.remove('is-invalid'));
                addTypeSubmitBtn.disabled = false;
                addTypeSubmitBtn.querySelector('.btn-text').style.display = 'inline';
                addTypeSubmitBtn.querySelector('.btn-loading').style.display = 'none';
            });

            addTypeForm.addEventListener('submit', function() {
                addTypeSubmitBtn.disabled = true;
                addTypeSubmitBtn.querySelector('.btn-text').style.display = 'none';
                addTypeSubmitBtn.querySelector('.btn-loading').style.display = 'inline';
            });
        }
    });
</script>