<div class="modal fade" id="deleteArticleStatusModal" tabindex="-1" aria-labelledby="deleteArticleStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deleteArticleStatusModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Delete Article Status
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
                            Do you really want to delete the article status 
                            <strong id="deleteArticleStatusName" class="text-danger"></strong>?
                        </p>
                        
                        <div class="item-info-preview bg-light p-3 rounded mb-3">
                            <div class="info-row">
                                <span class="info-label">Articles using this status:</span>
                                <span class="info-value" id="deleteArticleCount">0</span>
                            </div>
                        </div>
                        
                        <div id="deleteArticleWarning" class="alert alert-warning" style="display: none;">
                            <i class="fas fa-exclamation-circle"></i>
                            Warning: This status is linked to existing articles. You should reassign them before deleting.
                        </div>
                        
                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone and may affect article visibility in the system.
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel me-3" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <a href="#" id="deleteArticleConfirmBtn" class="btn btn-delete">
                    <i class="fas fa-trash-alt"></i>
                    <span class="btn-text">Yes, Delete It</span>
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
        const deleteModal = document.getElementById('deleteArticleStatusModal');
        const deleteConfirmBtn = document.getElementById('deleteArticleConfirmBtn');
        const btnText = deleteConfirmBtn.querySelector('.btn-text');
        const btnLoading = deleteConfirmBtn.querySelector('.btn-loading');

        deleteConfirmBtn.addEventListener('click', function(e) {
            e.preventDefault();
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
            deleteConfirmBtn.style.pointerEvents = 'none';
            window.location.href = this.href;
        });

        deleteModal.addEventListener('hidden.bs.modal', function() {
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            deleteConfirmBtn.style.pointerEvents = 'auto';
        });
    });

    /**
     * Hàm mở Modal xóa Article Status
     */
    function openDeleteModal(statusId, statusData) {
        document.getElementById('deleteArticleStatusName').textContent = statusData.name;
        
        const deleteBtn = document.getElementById('deleteArticleConfirmBtn');
        // Cập nhật Route trỏ đến article_statuses.delete
        deleteBtn.href = `{{ route('administrator.article_statuses.delete', ['id' => '__ID__']) }}`.replace('__ID__', statusId);
        
        // Lấy số lượng bài viết đang sử dụng status này
        // Giả định bạn truyền count qua Eager Loading hoặc thuộc tính articles_count
        const articleCount = statusData.articles_count || 0;
        document.getElementById('deleteArticleCount').textContent = articleCount;
        
        const warningEl = document.getElementById('deleteArticleWarning');
        if (articleCount > 0) {
            warningEl.style.display = 'block';
        } else {
            warningEl.style.display = 'none';
        }
        
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteArticleStatusModal'));
        deleteModal.show();
    }
</script>