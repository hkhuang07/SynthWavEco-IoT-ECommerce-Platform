<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addUserModalLabel">
                    <i class="fa-light fa-user-plus"></i>
                    Add New User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addUserForm" action="{{ route('administrator.users.add') }}" method="post">
                    @csrf

                    <!-- Basic Info -->
                    <h6 class="mb-3 text-muted"><i class="fas fa-info-circle"></i> Basic Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="name">
                                    <i class="fa-light fa-user"></i> Full Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control item-input @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" maxlength="128" required />
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="username">
                                    <i class="fa-light fa-at"></i> Username
                                </label>
                                <input type="text" class="form-control item-input @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" maxlength="50" />
                                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="email">
                                    <i class="fa-light fa-envelope"></i> Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control item-input @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required />
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="roles">
                                    <i class="fa-light fa-user-tag"></i> Role <span class="text-danger">*</span>
                                </label>
                                <select class="form-select item-input @error('roles') is-invalid @enderror" id="roles" name="roles" required>
                                    <option value="">-- Select Role --</option>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('roles') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('roles')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="password">
                                    <i class="fa-light fa-lock"></i> Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control item-input @error('password') is-invalid @enderror" id="password" name="password" minlength="8" required />
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="password_confirmation">
                                    <i class="fa-light fa-lock"></i> Confirm Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control item-input" id="password_confirmation" name="password_confirmation" minlength="8" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">
                            <i class="fa-light fa-toggle-on"></i> Active Account
                        </label>
                    </div>

                    <hr class="my-4">

                    <!-- Contact Info -->
                    <h6 class="mb-3 text-muted"><i class="fas fa-address-card"></i> Contact Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="phone">
                                    <i class="fa-light fa-phone"></i> Phone
                                </label>
                                <input type="text" class="form-control item-input @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" maxlength="20" />
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="id_card">
                                    <i class="fa-light fa-id-card"></i> ID Card
                                </label>
                                <input type="text" class="form-control item-input @error('id_card') is-invalid @enderror" id="id_card" name="id_card" value="{{ old('id_card') }}" maxlength="20" />
                                @error('id_card')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="address">
                            <i class="fa-light fa-map-marker-alt"></i> Address
                        </label>
                        <textarea class="form-control item-input @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address') }}</textarea>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <hr class="my-4">

                    <!-- Work Info -->
                    <h6 class="mb-3 text-muted"><i class="fas fa-briefcase"></i> Work Information</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label class="form-label" for="jobs">
                                    <i class="fa-light fa-briefcase"></i> Job Title
                                </label>
                                <input type="text" class="form-control item-input @error('jobs') is-invalid @enderror" id="jobs" name="jobs" value="{{ old('jobs') }}" maxlength="255" />
                                @error('jobs')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label class="form-label" for="company">
                                    <i class="fa-light fa-building"></i> Company
                                </label>
                                <input type="text" class="form-control item-input @error('company') is-invalid @enderror" id="company" name="company" value="{{ old('company') }}" maxlength="255" />
                                @error('company')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label class="form-label" for="school">
                                    <i class="fa-light fa-graduation-cap"></i> School
                                </label>
                                <input type="text" class="form-control item-input @error('school') is-invalid @enderror" id="school" name="school" value="{{ old('school') }}" maxlength="255" />
                                @error('school')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Profile Images -->
                    <h6 class="mb-3 text-muted"><i class="fas fa-image"></i> Profile Images</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="avatar">
                                    <i class="fa-light fa-user-circle"></i> Avatar URL
                                </label>
                                <input
                                    type="file"
                                    class="form-control item-input @error('avatar') is-invalid @enderror"
                                    id="avatar"
                                    name="avatar"
                                    placeholder="Choose avatar URL" />
                                @error('avatar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="background">
                                    <i class="fa-light fa-image"></i> Background URL
                                </label>
                                <input
                                    type="file"
                                    class="form-control item-input @error('background') is-invalid @enderror"
                                    id="background"
                                    name="background"
                                    placeholder="Choose avatar URL" />
                                 @error('background')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i> Cancel
                </button>
                <button type="submit" form="addUserForm" class="btn btn-action" id="submitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Create User</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fa-light fa-spinner fa-spin"></i> Creating...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addUserModal = document.getElementById('addUserModal');
        const addUserForm = document.getElementById('addUserForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        addUserModal.addEventListener('hidden.bs.modal', function() {
            addUserForm.reset();
            const invalidInputs = addUserForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        addUserForm.addEventListener('submit', function(e) {
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        addUserModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('name').focus();
        });
    });
</script>