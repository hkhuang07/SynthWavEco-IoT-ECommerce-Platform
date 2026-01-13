<div class="modal fade" id="updateManufacturerModal" tabindex="-1" aria-labelledby="updateManufacturerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateManufacturerModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit Manufacturer
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="updateModalMessages" class="mb-3" style="display: none;">
                    <div id="updateErrorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="updateSuccessMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="updateManufacturerForm" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="updateManufacturerId" name="manufacturer_id" value="">

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateName">
                            <i class="fa-light fa-building"></i>
                            Manufacturer Name <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control item-input @error('name') is-invalid @enderror"
                            id="updateName"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter manufacturer name"
                            maxlength="100"
                            required />
                        @error('name', 'update')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateLogo">
                            <i class="fa-light fa-image"></i>
                            Logo URL
                        </label>
                         @if(!empty($manufacturer->logo))
                        <img class="d-block rounded img-thumbnail" src="{{ asset('storage/app/private/'. $manufacturer->logo) }}" width="100" />
                        <small class="form-text text-muted">Leave empty to keep current logo</small>
                        @endif
                        <input
                            type="file"
                            class="form-control item-input @error('logo') is-invalid @enderror"
                            id="logo"
                            name="logo"
                            placeholder="Enter logo URL" />
                        @error('logo', 'update')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                        <div id="currentLogoPreview" class="mt-3" style="display: none;">
                            <label class="form-label">Current Logo:</label>
                            <div class="current-logo-container">
                                <img id="currentLogo" src="" alt="Current Logo" class="current-logo-preview">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateDescription">
                            <i class="fa-light fa-align-left"></i>
                            Description
                        </label>
                        <textarea
                            class="form-control item-input item-textarea"
                            id="updateDescription"
                            name="description"
                            value="{{ old('description') }}"
                            rows="3"
                            placeholder="Enter manufacturer description"></textarea>
                        <div class="invalid-feedback"       ></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateAddress">
                            <i class="fa-light fa-location-dot"></i>
                            Address
                        </label>
                        <input
                            type="text"
                            class="form-control item-input"
                            id="updateAddress"
                            name="address"
                            placeholder="Enter manufacturer address" />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="updateContactPhone">
                                    <i class="fa-light fa-phone"></i>
                                    Contact Phone
                                </label>
                                <input
                                    type="text"
                                    class="form-control item-input"
                                    id="updateContactPhone"
                                    name="contact_phone"
                                    placeholder="Enter phone number"
                                    maxlength="20" />
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="updateContactEmail">
                                    <i class="fa-light fa-envelope"></i>
                                    Contact Email
                                </label>
                                <input
                                    type="email"
                                    class="form-control item-input"
                                    id="updateContactEmail"
                                    name="contact_email"
                                    placeholder="Enter email address"
                                    maxlength="100" />
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="updateManufacturerForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update Manufacturer</span>
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
        const updateManufacturerModal = document.getElementById('updateManufacturerModal');
        const updateManufacturerForm = document.getElementById('updateManufacturerForm');
        const updateSubmitBtn = document.getElementById('updateSubmitBtn');
        const btnText = updateSubmitBtn.querySelector('.btn-text');
        const btnLoading = updateSubmitBtn.querySelector('.btn-loading');

        updateManufacturerModal.addEventListener('hidden.bs.modal', function() {
            updateManufacturerForm.reset();
            const invalidInputs = updateManufacturerForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            document.getElementById('currentLogoPreview').style.display = 'none';
            updateSubmitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        updateManufacturerForm.addEventListener('submit', function(e) {
            updateSubmitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        updateManufacturerModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('updateName').focus();
        });
    });

    function openUpdateModal(manufacturerId, manufacturerData) {
        const updateForm = document.getElementById('updateManufacturerForm');
        updateForm.action = `{{ route('administrator.manufacturers.update', ['id' => '__ID__']) }}`.replace('__ID__', manufacturerId);

        document.getElementById('updateManufacturerId').value = manufacturerId;
        document.getElementById('updateName').value = manufacturerData.name || '';
        document.getElementById('updateDescription').value = manufacturerData.description || '';
        document.getElementById('updateAddress').value = manufacturerData.address || '';
        document.getElementById('updateContactPhone').value = manufacturerData.contact_phone || '';
        document.getElementById('updateContactEmail').value = manufacturerData.contact_email || '';
        //document.getElementById('logo').value = manufacturerData.logo || '';

        const currentLogoPreview = document.getElementById('currentLogoPreview');
        const currentLogo = document.getElementById('currentLogo');

        if (manufacturerData.logo) {
            currentLogo.src = "{{ asset('storage/app/private') }}/" + manufacturerData.logo;
            currentLogoPreview.style.display = 'block';
        } else {
            currentLogoPreview.style.display = 'none';
        }

        const updateModal = new bootstrap.Modal(document.getElementById('updateManufacturerModal'));
        updateModal.show();
    }
</script>