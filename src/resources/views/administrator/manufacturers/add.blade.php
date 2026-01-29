<div class="modal fade" id="addManufacturerModal" tabindex="-1" aria-labelledby="addManufacturerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addManufacturerModalLabel">
                    <i class="fa-light fa-plus-circle"></i>
                    Add New Manufacturer
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="modalMessages" class="mb-3" style="display: none;">
                    <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="successMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="addManufacturerForm" action="{{ route('administrator.manufacturers.add') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-4">
                        <label class="form-label" for="name">
                            <i class="fa-light fa-building"></i>
                            Manufacturer Name 
                        </label>
                        <input
                            type="text"
                            class="form-control item-input @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter manufacturer name"
                            maxlength="100"
                            required />
                        @error('name')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="logo">
                            <i class="fa-light fa-image"></i>
                            Logo URL
                        </label>
                        <input
                            type="file"
                            class="form-control item-input @error('logo') is-invalid @enderror"
                            id="logo"
                            name="logo"
                            value="{{ old('logo') }}"
                            placeholder="Enter logo URL" />
                        @error('logo')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="description">
                            <i class="fa-light fa-align-left"></i>
                            Description
                        </label>
                        <textarea
                            class="form-control item-input item-textarea @error('description') is-invalid @enderror"
                            id="description"
                            name="description"
                            rows="3"
                            placeholder="Enter manufacturer description">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="address">
                            <i class="fa-light fa-location-dot"></i>
                            Address
                        </label>
                        <input
                            type="text"
                            class="form-control item-input @error('address') is-invalid @enderror"
                            id="address"
                            name="address"
                            value="{{ old('address') }}"
                            placeholder="Enter manufacturer address" />
                        @error('address')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="contact_phone">
                                    <i class="fa-light fa-phone"></i>
                                    Contact Phone
                                </label>
                                <input
                                    type="text"
                                    class="form-control item-input @error('contact_phone') is-invalid @enderror"
                                    id="contact_phone"
                                    name="contact_phone"
                                    value="{{ old('contact_phone') }}"
                                    placeholder="Enter phone number"
                                    maxlength="20" />
                                @error('contact_phone')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="contact_email">
                                    <i class="fa-light fa-envelope"></i>
                                    Contact Email
                                </label>
                                <input
                                    type="email"
                                    class="form-control item-input @error('contact_email') is-invalid @enderror"
                                    id="contact_email"
                                    name="contact_email"
                                    value="{{ old('contact_email') }}"
                                    placeholder="Enter email address"
                                    maxlength="100" />
                                @error('contact_email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
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
                <button type="submit" form="addManufacturerForm" class="btn btn-action" id="submitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Add Manufacturer</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fa-light fa-spinner fa-spin"></i>
                        Adding...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addManufacturerModal = document.getElementById('addManufacturerModal');
        const addManufacturerForm = document.getElementById('addManufacturerForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        addManufacturerModal.addEventListener('hidden.bs.modal', function() {
            addManufacturerForm.reset();
            const invalidInputs = addManufacturerForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        addManufacturerForm.addEventListener('submit', function(e) {
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        addManufacturerModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('name').focus();
        });
    });
</script>
