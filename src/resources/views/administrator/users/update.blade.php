<div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateUserModalLabel">
                    <i class="fa-light fa-user-edit"></i>
                    Edit User #<span id="updateUserId"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="updateUserForm" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Basic Info -->
                    <h6 class="mb-3 text-muted"><i class="fas fa-info-circle"></i> Basic Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_name">
                                    <i class="fa-light fa-user"></i> Full Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control item-input" id="update_name" name="name" maxlength="128" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_username">
                                    <i class="fa-light fa-at"></i> Username
                                </label>
                                <input type="text" class="form-control item-input" id="update_username" name="username" maxlength="50" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_email">
                                    <i class="fa-light fa-envelope"></i> Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control item-input" id="update_email" name="email" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_roles">
                                    <i class="fa-light fa-user-tag"></i> Role <span class="text-danger">*</span>
                                </label>
                                <select class="form-select item-input" id="update_roles" name="roles" required>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_password_new">
                                    <i class="fa-light fa-lock"></i> New Password
                                </label>
                                <input type="password" class="form-control item-input" id="update_password_new" name="password_new" minlength="8" placeholder="Leave blank to keep current" />
                                <small class="form-text text-muted">Leave empty to keep current password</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_password_new_confirmation">
                                    <i class="fa-light fa-lock"></i> Confirm New Password
                                </label>
                                <input type="password" class="form-control item-input" id="update_password_new_confirmation" name="password_new_confirmation" minlength="8" />
                            </div>
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="update_is_active" name="is_active" value="1">
                        <label class="form-check-label" for="update_is_active">
                            <i class="fa-light fa-toggle-on"></i> Active Account
                        </label>
                    </div>

                    <hr class="my-4">

                    <!-- Contact Info -->
                    <h6 class="mb-3 text-muted"><i class="fas fa-address-card"></i> Contact Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_phone">
                                    <i class="fa-light fa-phone"></i> Phone
                                </label>
                                <input type="text" class="form-control item-input" id="update_phone" name="phone" maxlength="20" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_id_card">
                                    <i class="fa-light fa-id-card"></i> ID Card
                                </label>
                                <input type="text" class="form-control item-input" id="update_id_card" name="id_card" maxlength="20" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="update_address">
                            <i class="fa-light fa-map-marker-alt"></i> Address
                        </label>
                        <textarea class="form-control item-input" id="update_address" name="address" rows="2"></textarea>
                    </div>

                    <hr class="my-4">

                    <!-- Work Info -->
                    <h6 class="mb-3 text-muted"><i class="fas fa-briefcase"></i> Work Information</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_jobs">
                                    <i class="fa-light fa-briefcase"></i> Job Title
                                </label>
                                <input type="text" class="form-control item-input" id="update_jobs" name="jobs" maxlength="255" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_company">
                                    <i class="fa-light fa-building"></i> Company
                                </label>
                                <input type="text" class="form-control item-input" id="update_company" name="company" maxlength="255" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_school">
                                    <i class="fa-light fa-graduation-cap"></i> School
                                </label>
                                <input type="text" class="form-control item-input" id="update_school" name="school" maxlength="255" />
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Profile Images -->
                    <h6 class="mb-3 text-muted"><i class="fas fa-image"></i> Profile Images</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_avatar">
                                    <i class="fa-light fa-user-circle"></i> Avatar URL
                                </label>
                                <input type="file" class="form-control item-input" id="update_avatar" name="avatar" placeholder="https://..." />
                                <div id="currentAvatarPreview" class="mt-2" style="display: none;">
                                    <img id="currentAvatar" src="" alt="Avatar" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_background">
                                    <i class="fa-light fa-image"></i> Background URL
                                </label>
                                <input type="file" class="form-control item-input" id="update_background" name="background" placeholder="https://..." />
                                <div id="currentBackgroundPreview" class="mt-2" style="display: none;">
                                    <img id="currentBackground" src="" alt="Background" class="thumbai" style="width: 50px; height: 50px; object-fit: cover;">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i> Cancel
                </button>
                <button type="submit" form="updateUserForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update User</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fa-light fa-spinner fa-spin"></i> Updating...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateUserModal = document.getElementById('updateUserModal');
        const updateUserForm = document.getElementById('updateUserForm');
        const updateSubmitBtn = document.getElementById('updateSubmitBtn');
        const btnText = updateSubmitBtn.querySelector('.btn-text');
        const btnLoading = updateSubmitBtn.querySelector('.btn-loading');

        updateUserModal.addEventListener('hidden.bs.modal', function() {
            updateUserForm.reset();
            const invalidInputs = updateUserForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            document.getElementById('currentAvatarPreview').style.display = 'none';
            document.getElementById('currentBackgroundPreview').style.display = 'none';
            updateSubmitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        updateUserForm.addEventListener('submit', function(e) {
            updateSubmitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        updateUserModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('update_name').focus();
        });
    });

    function openUpdateModal(userId, userData) {
        const updateForm = document.getElementById('updateUserForm');
        updateForm.action = `{{ route('administrator.users.update', ['id' => '__ID__']) }}`.replace('__ID__', userId);

        document.getElementById('updateUserId').textContent = userId;
        document.getElementById('update_name').value = userData.name || '';
        document.getElementById('update_username').value = userData.username || '';
        document.getElementById('update_email').value = userData.email || '';
        document.getElementById('update_roles').value = userData.roles || '';
        document.getElementById('update_is_active').checked = userData.is_active;
        document.getElementById('update_phone').value = userData.phone || '';
        document.getElementById('update_id_card').value = userData.id_card || '';
        document.getElementById('update_address').value = userData.address || '';
        document.getElementById('update_jobs').value = userData.jobs || '';
        document.getElementById('update_company').value = userData.company || '';
        document.getElementById('update_school').value = userData.school || '';
        //document.getElementById('update_avatar').value = userData.avatar || '';
        //document.getElementById('update_background').value = userData.background || '';

        // Show avatar preview
        const avatarPreview = document.getElementById('currentAvatarPreview');
        const avatarImg = document.getElementById('currentAvatar');
        const backgroundPreview = document.getElementById('currentBackgroundPreview');
        const backgroundImg = document.getElementById('currentBackground');
        if (userData.avatar) {
            avatarImg.src = `{{ asset('storage/app/private') }}/${userData.avatar}`;
            avatarPreview.style.display = 'block';
        } else {
            avatarPreview.style.display = 'none';
        }
        if (userData.background) {
            avatarImg.src = `{{ asset('storage/app/private') }}/${userData.background}`;
            avatarPreview.style.display = 'block';
        } else {
            avatarPreview.style.display = 'none';
        }
        const updateModal = new bootstrap.Modal(document.getElementById('updateUserModal'));
        updateModal.show();
    }
</script>