<div class="modal fade" id="addTopicModal" tabindex="-1" aria-labelledby="addTopicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addTopicModalLabel">
                    <i class="fas fa-plus-circle"></i>
                    Add New Topic
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                {{-- Form gửi dữ liệu đến route administrator.topics.add --}}
                <form id="addTopicForm" action="{{ route('administrator.topics.add') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-4">
                        <label class="form-label" for="name">
                            <i class="fas fa-tag"></i>
                            Topic Name <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control item-input @error('name', 'add') is-invalid @enderror"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="e.g., IoT Solutions, Agriculture Tech"
                            required />
                        @error('name', 'add')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="description">
                            <i class="fas fa-align-left"></i>
                            Description
                        </label>
                        <textarea
                            class="form-control item-input item-textarea @error('description', 'add') is-invalid @enderror"
                            id="description"
                            name="description"
                            rows="4"
                            placeholder="Summarize what this topic covers...">{{ old('description') }}</textarea>
                        @error('description', 'add')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="image">
                            <i class="fas fa-image"></i>
                            Topic Thumbnail
                        </label>
                        <input
                            type="file"
                            class="form-control item-input @error('image', 'add') is-invalid @enderror"
                            id="image"
                            name="image"
                            accept="image/*" />
                        <small class="text-muted">Recommended size: 800x600px (Max 2MB)</small>
                        @error('image', 'add')
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

                <button type="submit" form="addTopicForm" class="btn btn-action" id="submitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Add Topic</span>
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
        const addTopicModal = document.getElementById('addTopicModal');
        const addTopicForm = document.getElementById('addTopicForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        // Reset form khi đóng modal
        addTopicModal.addEventListener('hidden.bs.modal', function() {
            addTopicForm.reset();
            const invalidInputs = addTopicForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        // Hiển thị hiệu ứng loading khi submit
        addTopicForm.addEventListener('submit', function() {
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        // Auto-focus vào ô nhập tên khi mở modal
        addTopicModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('name').focus();
        });
    });
</script>