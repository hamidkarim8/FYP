
<?php $__env->startSection('title'); ?>
    Admin List
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/swiper/swiper.min.css')); ?>" rel="stylesheet" type="text/css" />
    <style>
        .swiper-slide {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .swiper-image {
            max-width: 30%;
            height: auto;
            margin-bottom: 10px;
        }

        .ribbon-two {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 10;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: bold;
            color: #fff;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Dashboards
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Admins
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Admin List</h5>
                </div>
                <div class="card-body">
                    <button class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#addAdminModal">Add
                        Admin</button>
                    <div class="table-responsive">
                        <table id="adminList" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>User ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Registered Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Table rows will be dynamically populated -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Admin Modal -->
    <div class="modal fade" id="viewAdminModal" tabindex="-1" aria-labelledby="viewAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewAdminModalLabel">View Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Admin details will be loaded here dynamically -->
                    <div id="admin-details"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Admin Modal -->
    <div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-labelledby="deleteAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAdminModalLabel">Delete Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="deleteAdminForm">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" id="delete_admin_id" name="admin_id">
                        Are you sure you want to delete this admin?
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Admin Modal -->
    <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAdminModalLabel">Add Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAdminForm" class="needs-validation" novalidate method="POST"
                        action="<?php echo e(route('admin.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="adminEmail" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="adminEmail"
                                placeholder="Enter email address" required>
                            <div class="invalid-feedback">
                                Please enter a valid email.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="adminUsername" class="form-label">Username <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="username" id="adminUsername"
                                placeholder="Enter username" required>
                            <div class="invalid-feedback">
                                Please enter a username.
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="adminPassword" class="form-label">Password <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" id="adminPassword"
                                placeholder="Enter password" required>
                            <div class="invalid-feedback">
                                Please enter a password.
                            </div>
                        </div>
                        <input type="hidden" name="role" value="admin">
                        <div class="mt-4">
                            <button class="btn btn-success w-100" type="submit">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('/assets/libs/swiper/swiper.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/pages/swiper.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            var table = $('#adminList').DataTable({
                processing: true,
                serverSide: true,
                ajax: "<?php echo e(route('admin.getAdmins')); ?>",
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            return data ? new Date(data).toLocaleString('en-GB', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit'
                            }) : '';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                // Handle Ajax errors
                error: function(xhr, errorType, exception) {
                    console.log('Ajax error:', xhr, errorType, exception);
                }
            });

            $('#adminList').on('click', '.view-admin', function(e) {
                e.preventDefault();
                var userId = $(this).data('id');
                axios.get("admin/admins/" + userId)
                    .then(function(response) {
                        var admin = response.data;
                        console.log(admin);
                        if (admin.error) {
                            alert(admin.error);
                        } else {
                            var userDetails = '<div><h4 class="mb-4">Admin Profile</h4>';
                            if (admin.profile) {
                                userDetails += '<p><strong>Full Name:</strong> ' + (admin.profile
                                    .fullname ? admin.profile.fullname : 'Not provided') + '</p>';
                                userDetails += '<p><strong>Address:</strong> ' + (admin.profile
                                        .address ? admin.profile.address : 'Not provided') +
                                    '</p>';
                                if (admin.profile.avatar) {
                                    userDetails += '<p><strong>Avatar:</strong></p>';
                                    userDetails +=
                                        '<div class="swiper pagination-fraction-swiper rounded">' +
                                        '<div class="swiper-wrapper">';
                                    userDetails += '<div class="swiper-slide">' +
                                        '<img src="images/' + admin.profile.avatar + '" alt="' + admin
                                        .profile.fullname +
                                        '" class="img-fluid swiper-image" />' +
                                        '</div>';
                                    userDetails += '</div>' +
                                        '<div class="swiper-button-next bg-white shadow"></div>' +
                                        '<div class="swiper-button-prev bg-white shadow"></div>' +
                                        '<div class="swiper-pagination"></div>' +
                                        '</div>';
                                }
                                userDetails += '<p><strong> Registered Date:</strong> ' + (admin
                                    .created_at ? new Date(
                                        admin.created_at).toLocaleString('en-GB', {
                                        day: '2-digit',
                                        month: '2-digit',
                                        year: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit',
                                        second: '2-digit'
                                    }) : 'Not provided') + '</p>';
                                userDetails += '<p><strong>Email:</strong> ' + (admin.email ? admin
                                    .email : 'Not provided') + '</p>';
                                userDetails += '<p><strong>Phone Number:</strong> ' + (admin.profile
                                        .phone_number ? admin.profile.phone_number : 'Not provided') +
                                    '</p>';
                                if (admin.profile.social_media) {
                                    var socialMedia = JSON.parse(admin.profile.social_media);
                                    if (socialMedia.ig_username) {
                                        userDetails +=
                                            '<p><strong>Instagram:</strong> <a href="https://www.instagram.com/' +
                                            socialMedia.ig_username + '" target="_blank">' + socialMedia
                                            .ig_username + '</a></p>';
                                    }
                                    if (socialMedia.twitter_username) {
                                        userDetails +=
                                            '<p><strong>Twitter:</strong> <a href="https://twitter.com/' +
                                            socialMedia.twitter_username + '" target="_blank">' +
                                            socialMedia.twitter_username + '</a></p>';
                                    }
                                    if (socialMedia.tiktok_username) {
                                        userDetails +=
                                            '<p><strong>TikTok:</strong> <a href="https://www.tiktok.com/' +
                                            socialMedia.tiktok_username + '" target="_blank">' +
                                            socialMedia.tiktok_username + '</a></p>';
                                    }
                                }
                            } else {
                                userDetails += '<p>No profile information available.</p>';
                            }
                            userDetails += '</div>';

                            $('#admin-details').html(userDetails);
                            $('#viewAdminModal').modal('show');
                            $('#viewAdminModal').on('shown.bs.modal', function() {
                                var mySwiper = new Swiper('.pagination-fraction-swiper', {
                                    navigation: {
                                        nextEl: '.swiper-button-next',
                                        prevEl: '.swiper-button-prev',
                                    },
                                    pagination: {
                                        el: '.swiper-pagination',
                                        type: 'fraction',
                                    },
                                });
                            });
                        }
                    })
                    .catch(function(error) {
                        alert('Error fetching admin details: ' + error.message);
                    });
            });

            // Delete Report
            $('#adminList').on('click', '.delete-admin', function(e) {
                e.preventDefault();
                var adminId = $(this).data('id');

                // Set report id in the modal form
                $('#delete_admin_id').val(adminId);

                // Open confirmation modal
                $('#deleteAdminModal').modal('show');
            });

            // Handle form submission for delete confirmation
            $('#deleteAdminForm').submit(function(e) {
                e.preventDefault();

                var adminId = $('#delete_admin_id').val();
                // Perform delete action
                axios.delete("<?php echo e(url('admin/admins')); ?>/" + adminId, {
                        data: {
                            '_token': '<?php echo e(csrf_token()); ?>',
                        }
                    })
                    .then(function(response) {
                        alert(response.data.success);
                        $('#deleteAdminModal').modal('hide');
                        table.ajax.reload();
                    })
                    .catch(function(error) {
                        if (error.response) {
                            if (error.response.status === 403) {
                                alert(error.response.data
                                .error); // Display custom error message from Laravel
                            } else {
                                alert('Error deleting admin: ' + error
                                .message); // Display generic error message
                            }
                        } else if (error.request) {
                            // The request was made but no response was received
                            console.error(error.request);
                            alert('Error deleting admin: No response received');
                        } else {
                            // Something happened in setting up the request that triggered an error
                            console.error('Error deleting admin:', error.message);
                            alert('Error deleting admin: ' + error.message);
                        }
                    });
            });

            // add admin modal
            $('#addAdminModalBtn').click(function() {
                $('#addAdminModal').modal('show');
            });

            // Handle form submission for adding admin
            $('#addAdminForm').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                axios.post("<?php echo e(route('admin.store')); ?>", formData)
                    .then(function(response) {
                        alert(response.data.success);
                        $('#addAdminModal').modal('hide');
                        $('#addAdminForm')[0].reset();
                        table.ajax.reload();
                    })
                    .catch(function(error) {
                        if (error.response) {
                            // Server responded with a status code outside of 2xx range
                            console.error('Error adding admin:', error.response.data);
                            // Display specific error messages from server validation
                            if (error.response.data.errors) {
                                Object.keys(error.response.data.errors).forEach(function(key) {
                                    var inputField = $('#admin' + key.charAt(0).toUpperCase() +
                                        key.slice(1));
                                    inputField.addClass('is-invalid');
                                    inputField.siblings('.invalid-feedback').html(error.response
                                        .data.errors[key][0]);
                                });
                            }
                        } else if (error.request) {
                            // The request was made but no response was received
                            console.error('Error adding admin:', error.request);
                        } else {
                            // Something happened in setting up the request that triggered an Error
                            console.error('Error adding admin:', error.message);
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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\FYP-TESTING\resources\views/admin/admins.blade.php ENDPATH**/ ?>