<div class="modal fade" id="updateArticleModal" tabindex="-1" aria-labelledby="updateArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateArticleModalLabel">
                    <i class="fas fa-edit"></i> Edit Article
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="updateArticleForm" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="updateArticleId" name="article_id">

                    <div class="form-section mb-4">
                        <h6 class="section-title"><i class="fas fa-info-circle"></i> Basic Information</h6>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" id="updateTitle" class="form-control item-input" name="title" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Slug (URL)</label>
                                    <input type="text" id="updateSlug" class="form-control item-input" name="slug" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Topic</label>
                                    <select class="form-select item-input" id="updateTopicId" name="topicid">
                                        @foreach($topics as $topic)
                                            <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Type</label>
                                    <select class="form-select item-input" id="updateTypeId" name="articletypeid">
                                        @foreach($article_types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select item-input" id="updateStatusId" name="statusid">
                                        @foreach($article_statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section mb-4">
                        <h6 class="section-title"><i class="fas fa-pen-nib"></i> Content Editorial</h6>
                        <div class="form-group mb-3">
                            <label class="form-label">Summary</label>
                            <textarea id="updateSummary" class="form-control item-input" name="summary" rows="2"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Main Content <span class="text-danger">*</span></label>
                            <textarea id="updateContentEditor" class="editor-content" name="content"></textarea>
                        </div>
                    </div>

                    <div class="form-section mb-4">
                        <h6 class="section-title"><i class="fas fa-image"></i> Cover Image</h6>
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <input type="file" class="form-control item-input" name="image" accept="image/*" />
                            </div>
                            <div class="col-md-4">
                                <div id="currentArticleImagePreview" style="display: none;">
                                    <img id="currentArticleImage" src="" class="img-thumbnail" style="max-height: 80px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" id="updateIsEnabled" name="is_enabled" value="1">
                        <label class="form-check-label" for="updateIsEnabled">Enable article visibility</label>
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="updateArticleForm" class="btn btn-action" id="updateArticleSubmitBtn">
                    <span class="btn-text">Save Changes</span>
                    <span class="btn-loading" style="display: none;"><i class="fas fa-spinner fa-spin"></i> Updating...</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    /**
     * Hàm quan trọng: Đổ dữ liệu vào Modal Update
     */
    function openUpdateModal(articleId, articleData) {
        const updateForm = document.getElementById('updateArticleForm');
        updateForm.action = `{{ route('administrator.articles.update', ['id' => '__ID__']) }}`.replace('__ID__', articleId);

        // Fill data
        document.getElementById('updateArticleId').value = articleId;
        document.getElementById('updateTitle').value = articleData.title || '';
        document.getElementById('updateSlug').value = articleData.slug || '';
        document.getElementById('updateSummary').value = articleData.summary || '';
        document.getElementById('updateTopicId').value = articleData.topicid || '';
        document.getElementById('updateTypeId').value = articleData.articletypeid || '';
        document.getElementById('updateStatusId').value = articleData.statusid || '';
        document.getElementById('updateIsEnabled').checked = articleData.is_enabled == 1;

        // Xử lý nội dung CKEditor
        if (window.editors && window.editors['updateContentEditor']) {
            window.editors['updateContentEditor'].setData(articleData.content || '');
        }

        // Xử lý ảnh
        const currentImg = document.getElementById('currentArticleImage');
        const imgPreview = document.getElementById('currentArticleImagePreview');
        if (articleData.image) {
            currentImg.src = "{{ asset('storage/app/private') }}/" + articleData.image;
            imgPreview.style.display = 'block';
        } else {
            imgPreview.style.display = 'none';
        }

        new bootstrap.Modal(document.getElementById('updateArticleModal')).show();
    }
</script>