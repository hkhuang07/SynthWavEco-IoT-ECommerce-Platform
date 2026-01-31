<div class="modal fade" id="deleteArticleTypeModal" tabindex="-1" aria-labelledby="deleteArticleTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deleteArticleTypeModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i> Confirm Delete Article Type
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="delete-confirmation text-center">
                    <div class="delete-icon-container mb-3"><i class="fas fa-trash-alt delete-icon"></i></div>
                    <h4 class="delete-title mb-3">Are you sure?</h4>
                    <div class="delete-message mb-4">
                        <p class="mb-2">Delete the article type: <strong id="deleteArticleTypeName" class="text-danger"></strong>?</p>
                        
                        <div class="item-info-preview bg-light p-3 rounded mb-3">
                            <div class="info-row">
                                <span class="info-label">Articles using this type:</span>
                                <span class="info-value" id="deleteArticleTypeCount">0</span>
                            </div>
                        </div>
                        
                        <div id="deleteArticleTypeWarning" class="alert alert-warning" style="display: none;">
                            <i class="fas fa-exclamation-circle"></i> Warning: This type has linked articles.
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel me-3" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="deleteTypeConfirmBtn" class="btn btn-delete">
                    <span class="btn-text">Yes, Delete It</span>
                    <span class="btn-loading" style="display: none;"><i class="fas fa-spinner fa-spin"></i> Deleting...</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteTypeConfirmBtn = document.getElementById('deleteTypeConfirmBtn');
        if (deleteTypeConfirmBtn) {
            deleteTypeConfirmBtn.addEventListener('click', function(e) {
                e.preventDefault();
                this.querySelector('.btn-text').style.display = 'none';
                this.querySelector('.btn-loading').style.display = 'inline';
                this.style.pointerEvents = 'none';
                window.location.href = this.href;
            });
        }
    });

    function openDeleteModal(typeId, typeData) {
        document.getElementById('deleteArticleTypeName').textContent = typeData.name;
        const deleteBtn = document.getElementById('deleteTypeConfirmBtn');
        deleteBtn.href = `{{ route('administrator.article_types.delete', ['id' => '__ID__']) }}`.replace('__ID__', typeId);
        
        const count = typeData.articles_count || 0;
        document.getElementById('deleteArticleTypeCount').textContent = count;
        if (count > 0) document.getElementById('deleteArticleTypeWarning').style.display = 'block';
        else document.getElementById('deleteArticleTypeWarning').style.display = 'none';
        
        const modal = new bootstrap.Modal(document.getElementById('deleteArticleTypeModal'));
        modal.show();
    }
</script>