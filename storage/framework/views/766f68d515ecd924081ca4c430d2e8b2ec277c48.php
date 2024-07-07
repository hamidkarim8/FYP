
<?php $__env->startSection('title'); ?>
    Feedback List
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Dashboards
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Feedbacks
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Feedback List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="feedbackList" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Reporter Name</th>
                                    <th>Message</th>
                                    <th>Reply</th>
                                    <th>Type</th>
                                    <th>Stars</th>
                                    <th>Display</th>
                                    <th>Feedback Date</th>
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

    <!-- View Feedback Modal -->
    <div class="modal fade" id="viewFeedbackModal" tabindex="-1" aria-labelledby="viewFeedbackModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewFeedbackModalLabel">View Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Feedback details will be loaded here dynamically -->
                    <div id="feedback-details"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Feedback Modal -->
    <div class="modal fade" id="deleteFeedbackModal" tabindex="-1" aria-labelledby="deleteFeedbackModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteFeedbackModalLabel">Delete Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="deleteFeedbackForm">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" id="delete_feedback_id" name="feedback_id">
                        Are you sure you want to delete this feedback?
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reply Feedback Modal -->
    <div class="modal fade" id="replyFeedbackModal" tabindex="-1" aria-labelledby="replyFeedbackModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyFeedbackModalLabel">Reply to Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="replyFeedbackForm" class="needs-validation" novalidate method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="feedback_id" id="feedbackId">
                        <div class="mb-3">
                            <label for="reply" class="form-label">Reply <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="reply" id="reply" placeholder="Enter your reply" required></textarea>
                            <div class="invalid-feedback">
                                Please enter a reply.
                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-success w-100" type="submit">Send Reply</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            var table = $('#feedbackList').DataTable({
                processing: true,
                serverSide: true,
                ajax: "<?php echo e(route('admin.getFeedbacks')); ?>",
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'user.profile.fullname',
                        name: 'user.profile.fullname',
                    },
                    {
                        data: 'message',
                        name: 'message',
                    },
                    {
                        data: 'reply',
                        name: 'reply',
                        render: function(data, type, row) {
                            var badgeClass = data == null ? 'badge bg-danger' :
                                '';
                            var statusText = data == null ? 'No Reply' : data;
                            return '<span class="' + badgeClass + '">' + statusText + '</span>';
                        }
                    },
                    {
                        data: 'type',
                        name: 'type',
                        render: function(data, type, row) {
                            return data.toUpperCase();
                        }
                    },
                    {
                        data: 'stars',
                        name: 'stars',
                        render: function(data, type, row) {
                            return data ? '<span style="color: gold;">' + '★'.repeat(data) +
                                '</span>' : 'Not provided';
                        }
                    },
                    {
                        data: 'isDisplay',
                        name: 'isDisplay',
                        render: function(data, type, row) {
                            return data == 1 ? 'Yes' : 'No';
                        }
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

            $('#feedbackList').on('click', '.view-feedback', function(e) {
                e.preventDefault();
                var feedbackId = $(this).data('id');
                axios.get("admin/feedbacks/" + feedbackId)
                    .then(function(response) {
                        var feedback = response.data;
                        console.log(feedback);
                        if (feedback.error) {
                            alert(feedback.error);
                        } else {
                            var feedbackDetails = '<div><h4 class="mb-4">Feedback Details</h4>';
                            if (feedback) {
                                feedbackDetails += '<p><strong>Reporter`s ID:</strong> ' + (feedback
                                .user.id ? feedback.user.id : 'Not provided') + '</p>';
                            feedbackDetails += '<p><strong>Reporter`s Username:</strong> ' + (
                                        feedback.user.name ? feedback.user.name : 'Not provided') +
                                    '</p>';
                                feedbackDetails += '<p><strong>Reporter`s Name:</strong> ' + (feedback
                                    .user.profile
                                    .fullname ? feedback.user.profile.fullname : 'Not provided') +
                                '</p>';
                            feedbackDetails += '<p><strong>Feedback Message:</strong> ' + (feedback
                                .message ? feedback
                                .message : 'Not provided') + '</p>';
                            feedbackDetails += '<p><strong>Feedback Type:</strong> ' + (feedback
                                .type ? feedback
                                .type.toUpperCase() : 'Not provided') + '</p>';
                            feedbackDetails += '<p><strong>Stars Rating:</strong> ' +
                                (feedback.stars ? '<span style="color: gold;">' + '★'.repeat(
                                    feedback.stars) + '</span>' : 'Not provided') +
                                '</p>';
                            feedbackDetails += '<p><strong>Reply from Admin:</strong> ' + (feedback
                                    .reply ?
                                    feedback.reply :
                                    '<span style="color: red;">Have not replied by admin </span>') +
                                '</p>';
                            feedbackDetails += '<p><strong> Feedback Date:</strong> ' + (feedback
                                .created_at ? new Date(
                                    feedback.created_at).toLocaleString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit'
                                }) : 'Not provided') + '</p>';
                            feedbackDetails +=
                                '<p><strong>Is this feedback displayed in user website?:</strong> ' +
                                (feedback.isDisplay == true ?
                                    'Yes' : 'No') +
                                '</p>';
                        } else {
                            feedbackDetails += '<p>No profile information available.</p>';
                        }
                        feedbackDetails += '</div>';

                        $('#feedback-details').html(feedbackDetails);
                        $('#viewFeedbackModal').modal('show');
                    }
                })
                .catch(function(error) {
                    alert('Error fetching feedback details: ' + error.message);
                });
        });

        // Delete Report
        $('#feedbackList').on('click', '.delete-feedback', function(e) {
            e.preventDefault();
            var feedbackId = $(this).data('id');

            // Set report id in the modal form
            $('#delete_feedback_id').val(feedbackId);

            // Open confirmation modal
            $('#deleteFeedbackModal').modal('show');
        });

        // Handle form submission for delete confirmation
        $('#deleteFeedbackForm').submit(function(e) {
            e.preventDefault();

            var feedbackId = $('#delete_feedback_id').val();
            // Perform delete action
            axios.delete("<?php echo e(url('admin/feedbacks')); ?>/" + feedbackId, {
                    data: {
                        '_token': '<?php echo e(csrf_token()); ?>',
                    }
                })
                .then(function(response) {
                    alert(response.data.success);
                    $('#deleteFeedbackModal').modal('hide');
                    table.ajax.reload();
                })
                .catch(function(error) {
                    if (error.response) {
                        if (error.response.status === 403) {
                            alert(error.response.data
                                .error);
                        } else {
                            alert('Error deleting feedback: ' + error
                                .message); // Display generic error message
                        }
                    } else if (error.request) {
                        // The request was made but no response was received
                        console.error(error.request);
                        alert('Error deleting feedback: No response received');
                    } else {
                        // Something happened in setting up the request that triggered an error
                        console.error('Error deleting feedback:', error.message);
                        alert('Error deleting feedback: ' + error.message);
                    }
                });
        });
        // Show reply feedback modal
        $('#feedbackList').on('click', '.reply-feedback', function(e) {
            e.preventDefault();
            var feedbackId = $(this).data('id');

            // Set feedback id in the modal form
            $('#feedbackId').val(feedbackId);

            // Open confirmation modal
            $('#replyFeedbackModal').modal('show');
        });

        // Handle form submission for replying to feedback
        $('#replyFeedbackForm').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            axios.post("<?php echo e(route('admin.replyFeedback')); ?>", formData)
                .then(function(response) {
                    alert(response.data.success);
                    $('#replyFeedbackModal').modal('hide');
                    $('#replyFeedbackForm')[0].reset();
                    table.ajax.reload();
                })
                .catch(function(error) {
                    if (error.response) {
                        console.error('Error replying to feedback:', error.response.data);
                        // Display specific error messages from server validation
                        if (error.response.data.errors) {
                            Object.keys(error.response.data.errors).forEach(function(key) {
                                var inputField = $('#replyFeedbackForm').find(
                                    `[name="${key}"]`);
                                inputField.addClass('is-invalid');
                                inputField.siblings('.invalid-feedback').html(error.response
                                    .data.errors[key][0]);
                            });
                        }
                    } else if (error.request) {
                        console.error('Error replying to feedback:', error.request);
                    } else {
                        console.error('Error replying to feedback:', error.message);
                    }
                });
        });

        // Handle display toggle
        $('#feedbackList').on('click', '.toggle-display', function(e) {
            e.preventDefault();
            var feedbackId = $(this).data('id');
            var isDisplay = $(this).data('display');

            axios.post("<?php echo e(route('admin.toggleDisplay')); ?>", {
                    _token: '<?php echo e(csrf_token()); ?>',
                    feedback_id: feedbackId,
                    isDisplay: !isDisplay
                })
                .then(function(response) {
                    alert(response.data.success);
                    table.ajax.reload();
                })
                .catch(function(error) {
                    console.error('Error toggling display:', error);
                    alert('Error toggling display.');
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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\FYP-TESTING\resources\views/admin/feedbacks.blade.php ENDPATH**/ ?>