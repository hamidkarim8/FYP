
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.settings'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    

    <div class="position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg profile-setting-img">
            <img src="<?php echo e(URL::asset('assets/images/about-bg.jpg')); ?>" class="profile-wid-img" alt="">
            <div class="overlay-content"></div>
        </div>
    </div>

    

    <div class="row">
        <div class="col-xxl-3">
            <div class="card mt-n5">
                <div class="card-body p-4">
                    <div class="text-center">
                        <form action="<?php echo e(route('updateAvatar', ['id' => Auth::id()])); ?>" method="POST"
                            enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('POST'); ?>
                            <!-- Avatar upload field -->
                            <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                <img src="<?php echo e($profile->avatar ? URL::asset('images/' . $profile->avatar) : URL::asset('images/default-avatar.jpg')); ?>"
                                    class="rounded-circle avatar-xl img-thumbnail user-profile-image shadow"
                                    alt="user-profile-image">
                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                    <input id="profile-img-file-input" name="avatar" type="file"
                                        class="profile-img-file-input">
                                    <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                        <span class="avatar-title rounded-circle bg-light text-body shadow">
                                            <i class="ri-camera-fill"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </form>
                        <h5 class="fs-16 mb-1"><?php echo e(Auth::user()->name); ?></h5>
                        <p class="text-muted mb-0"><?php echo e(Auth::user()->role == 'admin' ? 'Admin' : 'Normal User'); ?></p>
                    </div>
                </div>
            </div>
            <!--end card-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-0">Social Media</h5>
                        </div>
                    </div>
                    <form action="<?php echo e(route('updateSocialMedia', ['id' => Auth::id()])); ?>" method="POST"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('POST'); ?>
                        <?php
                            $socialMedia = json_decode($profile->social_media, true);
                        ?>
                        <div class="mb-3 d-flex">
                            <div class="avatar-xs d-block flex-shrink-0 me-3">
                                <span class="avatar-title rounded-circle fs-16 text-light shadow">
                                    <i class="ri-instagram-fill"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="igUsername" name="ig_username"
                                placeholder="Username" value="<?php echo e($socialMedia['ig_username'] ?? ''); ?>">
                        </div>
                        <div class="mb-3 d-flex">
                            <div class="avatar-xs d-block flex-shrink-0 me-3">
                                <span class="avatar-title rounded-circle fs-16 shadow">
                                    <i class="ri-twitter-fill"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="twitterUsername" name="twitter_username"
                                placeholder="Username" value="<?php echo e($socialMedia['twitter_username'] ?? ''); ?>">
                        </div>
                        <div class="mb-3 d-flex">
                            <div class="avatar-xs d-block flex-shrink-0 me-3">
                                <span class="avatar-title rounded-circle fs-16 shadow">
                                    <i class="bx bxl-tiktok"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="tiktokUsername" name="tiktok_username"
                                placeholder="Username" value="<?php echo e($socialMedia['tiktok_username'] ?? ''); ?>">
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-xxl-9">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i>
                                Personal Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                <i class="far fa-user"></i>
                                Change Password
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#privacy" role="tab">
                                <i class="far fa-envelope"></i>
                                Privacy Policy
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form action="<?php echo e(route('updateProfile', ['id' => Auth::id()])); ?>" method="POST"
                                enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('POST'); ?>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="usernameInput" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="usernameInput"
                                                name="username" placeholder="Enter your username"
                                                value="<?php echo e(Auth::user()->name); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="emailInput" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="emailInput" name="email"
                                                placeholder="Enter your email" value="<?php echo e(Auth::user()->email); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="fullNameInput" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="fullNameInput"
                                                name="full_name" placeholder="Enter your full name"
                                                value="<?php echo e($profile->fullname); ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="phonenumberInput" class="form-label">Phone Number</label>
                                            <input type="number" class="form-control" id="phonenumberInput"
                                                name="phone_number" placeholder="Enter your phone number"
                                                value="<?php echo e($profile->phone_number); ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="cityInput" class="form-label">City</label>
                                            <input type="text" class="form-control" id="cityInput" name="city"
                                                placeholder="City" value="<?php echo e($profile->city); ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="countryInput" class="form-label">Country</label>
                                            <input type="text" class="form-control" id="countryInput" name="country"
                                                placeholder="Country" value="<?php echo e($profile->country); ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="postcodeInput" class="form-label">Postcode</label>
                                            <input type="text" class="form-control" id="postcodeInput"
                                                name="postcode" placeholder="Enter postcode"
                                                value="<?php echo e($profile->postcode); ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-4">
                                        <div class="hstack gap-2 justify-content-end mt-2">
                                            <button type="button" class="btn btn-soft-success">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="changePassword" role="tabpanel">
                            <form action="<?php echo e(route('changePassword', ['id' => Auth::id()])); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('POST'); ?>
                                <div class="row g-2">
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="oldpasswordInput" class="form-label">Old Password*</label>
                                            <input type="password" class="form-control" id="oldpasswordInput"
                                                name="old_password" placeholder="Enter current password" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="newpasswordInput" class="form-label">New Password*</label>
                                            <input type="password" class="form-control" id="newpasswordInput"
                                                name="new_password" placeholder="Enter new password" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="confirmpasswordInput" class="form-label">Confirm Password*</label>
                                            <input type="password" class="form-control" id="confirmpasswordInput"
                                                name="confirm_password" placeholder="Confirm password" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <a href="<?php echo e(route('forgot-password-form')); ?>"
                                                class="link-primary text-decoration-underline">Forgot Password?</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success">Change Password</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="privacy" role="tabpanel">
                            <div class="mb-3">
                                <h5 class="card-title text-decoration-underline mb-3">Permissions:</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="d-flex mt-2">
                                        <div class="flex-grow-1">
                                            <label class="form-check-label fs-14" for="allowNotification">
                                                Allow notifications
                                            </label>
                                            <p class="text-muted">Enable this to receive notifications and updates from the
                                                system.</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="allowNotification" />
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mt-2">
                                        <div class="flex-grow-1">
                                            <label class="form-check-label fs-14" for="allowLocation">
                                                Allow sharing current location
                                            </label>
                                            <p class="text-muted">Enable this to share your current location with the
                                                system.</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="allowLocation" />
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h5 class="card-title text-decoration-underline mb-3">Delete This Account:</h5>
                                <p class="text-muted">Your account will be permanently removed from the system. Please
                                    enter your password to confirm.</p>
                                <div>
                                    <input type="password" class="form-control" id="passwordInput" name="password"
                                        placeholder="Enter your password" value="" style="max-width: 265px;">
                                </div>
                                <div class="hstack gap-2 mt-3">
                                    <a href="javascript:void(0);" class="btn btn-soft-danger">Close & Delete This
                                        Account</a>
                                    <a href="javascript:void(0);" class="btn btn-light">Cancel</a>
                                </div>
                            </div>
                        </div>
                        <!--end tab-pane-->
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('assets/js/pages/profile-setting.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to handle avatar file upload
            $('#profile-img-file-input').change(function() {
                var formData = new FormData();
                formData.append('avatar', $(this)[0].files[0]);

                $.ajax({
                    url: '<?php echo e(route('updateAvatar', ['id' => Auth::id()])); ?>',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Toastify({
                            text: 'Avatar updated successfully.',
                            duration: 3000,
                            backgroundColor: '#28a745',
                            gravity: 'top',
                            position: 'center',
                            close: true
                        }).showToast();
                    },
                    error: function(xhr, status, error) {
                        Toastify({
                            text: 'Failed to update avatar.',
                            duration: 3000,
                            backgroundColor: '#dc3545',
                            gravity: 'top',
                            position: 'center',
                            close: true
                        }).showToast();
                        console.error(xhr.responseText);
                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
                        //call notification
                        fetchNotifications();
            setInterval(fetchNotifications, 60000);

            function fetchNotifications() {
                axios.get('<?php echo e(route('notifications.fetch')); ?>')
                    .then(response => {
                        const notifications = response.data.notifications;
                        updateNotificationUI(notifications);
                    })
                    .catch(error => {
                        console.error('Error fetching notifications:', error);
                    });
            }

            function updateNotificationUI(notifications) {
                const notificationDropdown = document.getElementById('notificationItemsTabContent');
                const notificationBadge = document.querySelector('.topbar-badge');
                const notificationCountBadge2 = document.querySelector('.notification-count2');

                // Count only unread notifications
                let unreadNotificationCount = notifications.filter(notification => notification.read_at === null)
                    .length;
                notificationBadge.textContent = unreadNotificationCount;
                notificationCountBadge2.textContent = notifications.length;

                let notificationHTML;

                if (notifications.length === 0) {
                    notificationHTML = `
<div class="w-25 w-sm-50 pt-3 mx-auto">
                    <img src="<?php echo e(URL::asset('assets/images/svg/bell.svg')); ?>" class="img-fluid"
                        alt="user-pic">
                </div>
                <div class="text-center pb-5 mt-2">
                    <h6 class="fs-18 fw-semibold lh-base">Hey! You have no any notifications </h6>
                </div>
        `;
                } else {
                    notificationHTML = notifications.map(notification => {
                        const isRead = notification.read_at !== null ? 'read' : 'unread';
                        const backgroundColor = notification.read_at !== null ? '#f0f0f0' : '#ffffff';

                        let href;
                        // console.log(notification.type);
                        if ((notification.type === 'App\\Notifications\\SimpleReportSubmitted') || (
                                notification.type === 'App\\Notifications\\DeleteItemDetails') || (
                                notification.type === 'App\\Notifications\\FeedbackSubmitted')) {
                            href = '#hero';
                        } else {
                            href = `<?php echo e(route('user.itemDetail', ['id' => ':report_id'])); ?>`
                                .replace(':report_id', notification.data.report_id);
                        }

                        return `
                <div class="text-reset notification-item d-block dropdown-item position-relative ${isRead}" 
                    data-notification-id="${notification.id}"
                    style="background-color: ${backgroundColor};">
                    <div class="d-flex align-items-center">
                        <div class="avatar-xs me-3">
                            <span class="avatar-title bg-soft-info text-info rounded-circle fs-16">
                                <i class="bx bx-badge-check"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <a href=${href} class="stretched-link">
                                <h6 class="mt-0 mb-2 lh-base">${notification.data.message}</h6>
                            </a>
                            <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                <span><i class="mdi mdi-clock-outline"></i> ${new Date(notification.created_at).toLocaleString('en-GB')}</span>
                            </p>
                        </div>
                        <div class="px-2 fs-15">
                            <div class="form-check notification-check">
                                <input class="form-check-input notification-checkbox" 
                                    type="checkbox" 
                                    value="${notification.id}" 
                                    id="notification-check-${notification.id}" 
                                    ${notification.read_at !== null ? 'checked' : ''}
                                    title="${notification.read_at !== null ? 'Mark as unread' : 'Mark as read'}">
                                <label class="form-check-label" for="notification-check-${notification.id}"></label>
                            </div>
                        </div>
                    </div>
                </div>
            `;
                    }).join('');
                }

                notificationDropdown.innerHTML = notificationHTML;

                if (notifications.length > 0) {
                    attachCheckboxListeners();
                }
            }


            function attachCheckboxListeners() {
                const checkboxes = document.querySelectorAll('.notification-checkbox');

                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const notificationId = this.value;
                        const isChecked = this.checked;

                        if (isChecked) {
                            axios.put(`/notifications/${notificationId}/mark-as-read`)
                                .then(response => {
                                    fetchNotifications();
                                })
                                .catch(error => {
                                    console.error('Error marking notification as read:', error);
                                });
                        } else {
                            axios.put(`/notifications/${notificationId}/mark-as-unread`)
                                .then(response => {
                                    fetchNotifications();
                                })
                                .catch(error => {
                                    console.error('Error marking notification as unread:',
                                        error);
                                });
                        }
                    });
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\FYP-TESTING\resources\views\admin\profile.blade.php ENDPATH**/ ?>