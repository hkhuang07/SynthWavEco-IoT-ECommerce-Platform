<div class="modal fade" id="deleteTopicModal" tabindex="-1" aria-labelledby="deleteTopicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deleteTopicModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Delete Topic
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
                            Do you really want to delete the topic
                            <strong id="deleteTopicName" class="text-danger"></strong>?
                        </p>

                        <div class="item-info-preview bg-light p-3 rounded mb-3" id="deleteTopicPreview" style="display: none;">
                            <div class="row justify-content-center">
                                <div class="col-8">
                                    <div class="preview-logo mx-auto">
                                        <img id="deleteTopicImage" src="" alt="Topic Image" class="img-fluid rounded shadow-sm border" style="max-height: 150px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone and may affect related <strong>Articles</strong>.
                        </small>
                    </div>
                </div>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-secondary px-4 me-2" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cancel
                </button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-danger px-4">
                    <i class="fas fa-trash-alt me-1"></i>
                    <span class="btn-text">Yes, Delete It</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin me-1"></i> Deleting...
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteTopicModal = document.getElementById('deleteTopicModal');
        const deleteConfirmBtn = document.getElementById('deleteConfirmBtn');
        const btnText = deleteConfirmBtn.querySelector('.btn-text');
        const btnLoading = deleteConfirmBtn.querySelector('.btn-loading');

        deleteConfirmBtn.addEventListener('click', function(e) {
            e.preventDefault();
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
            deleteConfirmBtn.style.pointerEvents = 'none';
            window.location.href = this.href;
        });

        deleteTopicModal.addEventListener('hidden.bs.modal', function() {
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            deleteConfirmBtn.style.pointerEvents = 'auto';
        });
    });

    function openDeleteModal(topicId, topicData) {
        try {
            // 1. Cập nhật tên
            document.getElementById('deleteTopicName').textContent = topicData.name || 'this topic';

            // 2. Cập nhật Link Delete
            const deleteBtn = document.getElementById('deleteConfirmBtn');
            deleteBtn.href = `{{ route('administrator.topics.delete', ['id' => '__ID__']) }}`.replace('__ID__', topicId);

            // 3. Xử lý hiển thị Review Ảnh
            const topicImg = document.getElementById('deleteTopicImage');
            const previewContainer = document.getElementById('deleteTopicPreview');

            if (topicData.image) {
                topicImg.src = "{{ asset('storage/app/private') }}/" + topicData.image;
                previewContainer.style.display = 'block'; 
            } else {
                previewContainer.style.display = 'none'; 
            }

            // 4. Mở Modal
            const modal = new bootstrap.Modal(document.getElementById('deleteTopicModal'));
            modal.show();

        } catch (error) {
            console.error('Error opening Topic delete modal:', error);
        }
    }
</script>