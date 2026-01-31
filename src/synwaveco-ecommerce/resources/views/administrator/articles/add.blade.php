<div class="modal fade" id="addArticleModal" tabindex="-1" aria-labelledby="addArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addArticleModalLabel">
                    <i class="fas fa-plus-circle"></i> Add New Article
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addArticleForm" action="{{ route('administrator.articles.add') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-section mb-4">
                        <h6 class="section-title"><i class="fas fa-info-circle"></i> Basic Information</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label"><i class="fas fa-heading"></i> Article Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control item-input @error('title', 'add') is-invalid @enderror" 
                                           name="title" value="{{ old('title') }}" placeholder="Enter catchy title..." required />
                                    @error('title', 'add') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><i class="fas fa-folder"></i> Topic <span class="text-danger">*</span></label>
                                    <select class="form-select item-input" name="topicid" required>
                                        <option value="">-- Select Topic --</option>
                                        @foreach($topics as $topic)
                                            <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><i class="fas fa-tag"></i> Article Type <span class="text-danger">*</span></label>
                                    <select class="form-select item-input" name="articletypeid" required>
                                        <option value="">-- Select Type --</option>
                                        @foreach($article_types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><i class="fas fa-check-circle"></i> Status <span class="text-danger">*</span></label>
                                    <select class="form-select item-input" name="statusid" required>
                                        <option value="">-- Select Status --</option>
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
                            <label class="form-label">Summary / Excerpt</label>
                            <textarea class="form-control item-input" name="summary" rows="2" placeholder="Brief introduction..."></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Main Content <span class="text-danger">*</span></label>
                            <textarea id="addContentEditor" class="editor-content" name="content"></textarea>
                        </div>
                    </div>

                    <div class="form-section">
                        <h6 class="section-title"><i class="fas fa-image"></i> Media</h6>
                        <div class="form-group">
                            <label class="form-label">Cover Image</label>
                            <input type="file" class="form-control item-input" name="image" accept="image/*" />
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="addArticleForm" class="btn btn-action" id="addArticleSubmitBtn">
                    <span class="btn-text">Publish Article</span>
                    <span class="btn-loading" style="display: none;"><i class="fas fa-spinner fa-spin"></i> Processing...</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addModalEl = document.getElementById('addArticleModal');
        const addForm = document.getElementById('addArticleForm');
        const addSubmitBtn = document.getElementById('addArticleSubmitBtn');

        addModalEl.addEventListener('hidden.bs.modal', function() {
            addForm.reset();
            // Reset CKEditor content if needed
            if (window.editors && window.editors['addContentEditor']) {
                window.editors['addContentEditor'].setData('');
            }
        });

        addForm.addEventListener('submit', function() {
            addSubmitBtn.disabled = true;
            addSubmitBtn.querySelector('.btn-text').style.display = 'none';
            addSubmitBtn.querySelector('.btn-loading').style.display = 'inline';
        });
    });
</script>