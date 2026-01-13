<div class="modal fade" id="deleteManufacturerModal" tabindex="-1" aria-labelledby="deleteManufacturerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deleteManufacturerModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Delete Manufacturer
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
                            Do you really want to delete the manufacturer 
                            <strong id="deleteManufacturerName" class="text-danger"></strong>?
                        </p>
                        
                        <div class="item-info-preview bg-light p-3 rounded mb-3" id="deleteManufacturerPreview">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <div class="preview-logo" id="deleteLogoPreview">
                                        <img id="deleteManufacturerLogo" src="" alt="Manufacturer Logo" class="delete-preview-logo">
                                        <div id="deleteNoLogo" class="no-logo-placeholder">
                                            <i class="fas fa-industry"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="preview-details text-start">
                                        <div class="preview-item" id="previewEmail" style="display: none;">
                                            <small><i class="fas fa-envelope me-1"></i></small>
                                            <span id="deleteEmail"></span>
                                        </div>
                                        <div class="preview-item" id="previewPhone" style="display: none;">
                                            <small><i class="fas fa-phone me-1"></i></small>
                                            <span id="deletePhone"></span>
                                        </div>
                                        <div class="preview-item" id="previewAddress" style="display: none;">
                                            <small><i class="fas fa-location-dot me-1"></i></small>
                                            <span id="deleteAddress"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone and may affect related products.
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel me-3" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-delete">
                    <i class="fas fa-trash-alt"></i>
                    <span>Yes, Delete It</span>
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
        const deleteManufacturerModal = document.getElementById('deleteManufacturerModal');
        const deleteConfirmBtn = document.getElementById('deleteConfirmBtn');
        const btnText = deleteConfirmBtn.querySelector('span:not(.btn-loading)');
        const btnLoading = deleteConfirmBtn.querySelector('.btn-loading');

        deleteConfirmBtn.addEventListener('click', function(e) {
            e.preventDefault();
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
            deleteConfirmBtn.style.pointerEvents = 'none';
            window.location.href = this.href;
        });

        deleteManufacturerModal.addEventListener('hidden.bs.modal', function() {
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            deleteConfirmBtn.style.pointerEvents = 'auto';
        });
    });

    function openDeleteModal(manufacturerId, manufacturerData) {
        document.getElementById('deleteManufacturerName').textContent = manufacturerData.name;
        
        const deleteBtn = document.getElementById('deleteConfirmBtn');
        deleteBtn.href = `{{ route('administrator.manufacturers.delete', ['id' => '__ID__']) }}`.replace('__ID__', manufacturerId);
        
        // Handle logo preview
        const logoImg = document.getElementById('deleteManufacturerLogo');
        const noLogoPlaceholder = document.getElementById('deleteNoLogo');
        
        if (manufacturerData.logo) {
            logoImg.src = manufacturerData.logo;
            logoImg.style.display = 'block';
            noLogoPlaceholder.style.display = 'none';
        } else {
            logoImg.style.display = 'none';
            noLogoPlaceholder.style.display = 'flex';
        }
        
        // Handle contact info preview
        const previewEmail = document.getElementById('previewEmail');
        const previewPhone = document.getElementById('previewPhone');
        const previewAddress = document.getElementById('previewAddress');
        
        if (manufacturerData.contact_email) {
            document.getElementById('deleteEmail').textContent = manufacturerData.contact_email;
            previewEmail.style.display = 'block';
        } else {
            previewEmail.style.display = 'none';
        }
        
        if (manufacturerData.contact_phone) {
            document.getElementById('deletePhone').textContent = manufacturerData.contact_phone;
            previewPhone.style.display = 'block';
        } else {
            previewPhone.style.display = 'none';
        }
        
        if (manufacturerData.address) {
            document.getElementById('deleteAddress').textContent = manufacturerData.address;
            previewAddress.style.display = 'block';
        } else {
            previewAddress.style.display = 'none';
        }
        
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteManufacturerModal'));
        deleteModal.show();
    }
</script>
