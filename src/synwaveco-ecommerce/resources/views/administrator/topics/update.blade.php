<div class="modal fade" id="updateTopicModal" tabindex="-1" aria-labelledby="updateTopicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateTopicModalLabel">
                    <i class="fas fa-edit"></i>
                    Edit Topic
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="updateTopicForm" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- Hidden input để giữ ID của Topic cần cập nhật --}}
                    <input type="hidden" id="updateTopicId" name="topic_id" value="">

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateName">
                            <i class="fas fa-tag"></i>
                            Topic Name <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control item-input @error('name', 'update') is-invalid @enderror"
                            id="updateName"
                            name="name"
                            required />
                        @error('name', 'update')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateDescription">
                            <i class="fas fa-align-left"></i>
                            Description
                        </label>
                        <textarea
                            class="form-control item-input item-textarea @error('description', 'update') is-invalid @enderror"
                            id="updateDescription"
                            name="description"
                            rows="4"></textarea>
                        @error('description', 'update')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateImage">
                            <i class="fas fa-image"></i>
                            Update Image
                        </label>
                        <input
                            type="file"
                            class="form-control item-input @error('image', 'update') is-invalid @enderror"
                            id="updateImage"
                            name="image"
                            accept="image/*" />
                        
                        {{-- Hiển thị ảnh hiện tại --}}
                        <div id="currentImagePreview" class="mt-3" style="display: none;">
                            <label class="form-label text-muted small">Current Thumbnail:</label>
                            <div class="current-logo-container">
                                <img id="currentImage" src="" alt="Current Topic Image" class="img-thumbnail" style="max-width: 150px;">
                            </div>
                            <small class="text-info">Leave empty if you don't want to change the image.</small>
                        </div>
                        
                        @error('image', 'update')
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
                <button type="submit" form="updateTopicForm" class="btn btn-action" id="updateSubmitBtn">
                     <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update Topic</span>
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
        const updateTopicModal = document.getElementById('updateTopicModal');
        const updateTopicForm = document.getElementById('updateTopicForm');
        const updateSubmitBtn = document.getElementById('updateSubmitBtn');
        const btnText = updateSubmitBtn.querySelector('.btn-text');
        const btnLoading = updateSubmitBtn.querySelector('.btn-loading');

        // Reset trạng thái form khi đóng modal
        updateTopicModal.addEventListener('hidden.bs.modal', function() {
            updateTopicForm.reset();
            const invalidInputs = updateTopicForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            document.getElementById('currentImagePreview').style.display = 'none';
            updateSubmitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        // Hiển thị loading khi submit
        updateTopicForm.addEventListener('submit', function() {
            updateSubmitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        // Focus vào ô tên khi mở modal
        updateTopicModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('updateName').focus();
        });
    });

    /**
     * Hàm mở Modal và đổ dữ liệu vào Form
     * Được gọi từ file list.blade.php
     */
    function openUpdateModal(topicId, topicData) {
        const updateForm = document.getElementById('updateTopicForm');
        
        // Cập nhật Action URL cho form
        updateForm.action = `{{ route('administrator.topics.update', ['id' => '__ID__']) }}`.replace('__ID__', topicId);

        // Đổ dữ liệu vào các input
        document.getElementById('updateTopicId').value = topicId;
        document.getElementById('updateName').value = topicData.name || '';
        document.getElementById('updateDescription').value = topicData.description || '';

        // Xử lý hiển thị ảnh cũ
        const currentImagePreview = document.getElementById('currentImagePreview');
        const currentImage = document.getElementById('currentImage');

        if (topicData.image) {
            // Lưu ý: Đường dẫn asset cần khớp với cấu trúc lưu trữ của bạn
            currentImage.src = "{{ asset('storage/app/private') }}/" + topicData.image;
            currentImagePreview.style.display = 'block';
        } else {
            currentImagePreview.style.display = 'none';
        }

        // Kích hoạt Modal
        const modal = new bootstrap.Modal(document.getElementById('updateTopicModal'));
        modal.show();
    }
</script>