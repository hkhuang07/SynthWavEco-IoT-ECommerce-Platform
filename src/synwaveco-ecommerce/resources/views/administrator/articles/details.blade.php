<div class="modal fade" id="articleDetailModal" tabindex="-1" aria-labelledby="articleDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="articleDetailModalLabel">
                    <i class="fas fa-book-open"></i> Article Preview
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 border-end">
                        <div class="text-center mb-4">
                            <img id="detailArticleImage" src="" class="img-fluid rounded shadow mb-3" style="max-height: 200px;">
                            <div id="detailNoImage" class="bg-light p-5 rounded d-none"><i class="fas fa-image fa-3x text-muted"></i></div>
                        </div>
                        <div class="article-meta p-3 bg-light rounded">
                            <p><strong>Topic:</strong> <span id="detailTopic" class="text-primary"></span></p>
                            <p><strong>Type:</strong> <span id="detailType"></span></p>
                            <p><strong>Status:</strong> <span id="detailStatus" class="badge bg-info"></span></p>
                            <p><strong>Views:</strong> <span id="detailViews"></span></p>
                            <p><strong>Author:</strong> <span id="detailAuthor"></span></p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h2 id="detailTitle" class="fw-bold mb-3"></h2>
                        <div class="summary-box border-start border-4 border-primary p-3 bg-light mb-4">
                            <strong>Summary:</strong>
                            <p id="detailSummary" class="mb-0 fst-italic text-muted"></p>
                        </div>
                        <div id="detailContent" class="article-content-render border rounded p-4 bg-white" style="min-height: 400px; overflow-y: auto;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openProductDetailsModal(articleData) {
        document.getElementById('detailTitle').textContent = articleData.title;
        document.getElementById('detailTopic').textContent = articleData.topic ? articleData.topic.name : 'N/A';
        document.getElementById('detailType').textContent = articleData.articletype ? articleData.articletype.name : 'N/A';
        document.getElementById('detailStatus').textContent = articleData.status ? articleData.status.name : 'Draft';
        document.getElementById('detailViews').textContent = (articleData.views || 0).toLocaleString();
        document.getElementById('detailAuthor').textContent = articleData.user ? articleData.user.name : 'Admin';
        document.getElementById('detailSummary').textContent = articleData.summary || 'No summary.';

        // RENDER HTML TỪ CKEDITOR
        document.getElementById('detailContent').innerHTML = articleData.content || '<p class="text-muted">No content available.</p>';

        const img = document.getElementById('detailArticleImage');
        const noImg = document.getElementById('detailNoImage');
        if (articleData.image) {
            img.src = "{{ asset('storage/app/public') }}/" + articleData.image;
            img.classList.remove('d-none');
            noImg.classList.add('d-none');
        } else {
            img.classList.add('d-none');
            noImg.classList.remove('d-none');
        }

        new bootstrap.Modal(document.getElementById('articleDetailModal')).show();
    }
</script>