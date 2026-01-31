<div class="modal fade" id="deleteArticleModal" tabindex="-1" aria-labelledby="deleteArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deleteArticleModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i> Confirm Delete Article
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="delete-confirmation text-center">
                    <div class="delete-icon-container mb-3"><i class="fas fa-trash-alt delete-icon"></i></div>
                    <h4 class="delete-title mb-3">Are you sure?</h4>
                    <div class="delete-message mb-4">
                        <p class="mb-2">Delete article: <strong id="deleteArticleTitle" class="text-danger"></strong>?</p>
                        
                        <div class="item-info-preview bg-light p-3 rounded mb-3">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <div class="preview-logo">
                                        <img id="deleteArticleImage" src="" class="img-fluid rounded shadow-sm">
                                        <div id="deleteArticleNoImage" class="no-logo-placeholder"><i class="fas fa-file-alt"></i></div>
                                    </div>
                                </div>
                                <div class="col-8 text-start small">
                                    <p class="mb-1"><strong>Topic:</strong> <span id="deleteArticleTopic"></span></p>
                                    <p class="mb-0"><strong>Type:</strong> <span id="deleteArticleType"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel me-3" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="deleteArticleConfirmBtn" class="btn btn-delete">
                    <span class="btn-text">Yes, Delete It</span>
                    <span class="btn-loading" style="display: none;"><i class="fas fa-spinner fa-spin"></i> Deleting...</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // ĐỔI TÊN HÀM ĐỂ KHỚP VỚI LIST.BLADE.PHP
    function openDeleteModal(articleId, articleData) {
        document.getElementById('deleteArticleTitle').textContent = articleData.title;
        // Truy xuất theo tên quan hệ trong Model (Lưu ý: Laravel convert sang snake_case hoặc camelCase tùy cấu hình)
        document.getElementById('deleteArticleTopic').textContent = articleData.topic ? articleData.topic.name : 'N/A';
        document.getElementById('deleteArticleType').textContent = articleData.articletype ? articleData.articletype.name : 'General';
        
        const deleteBtn = document.getElementById('deleteArticleConfirmBtn');
        deleteBtn.href = `{{ route('administrator.articles.delete', ['id' => '__ID__']) }}`.replace('__ID__', articleId);
        
        const img = document.getElementById('deleteArticleImage');
        const noImg = document.getElementById('deleteArticleNoImage');
        if (articleData.image) {
            img.src = "{{ asset('storage/app/private') }}/" + articleData.image;
            img.style.display = 'block';
            noImg.style.display = 'none';
        } else {
            img.style.display = 'none';
            noImg.style.display = 'flex';
        }
        
        new bootstrap.Modal(document.getElementById('deleteArticleModal')).show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const confirmBtn = document.getElementById('deleteArticleConfirmBtn');
        confirmBtn.addEventListener('click', function() {
            this.querySelector('.btn-text').style.display = 'none';
            this.querySelector('.btn-loading').style.display = 'inline';
            this.style.pointerEvents = 'none';
        });
    });
</script>