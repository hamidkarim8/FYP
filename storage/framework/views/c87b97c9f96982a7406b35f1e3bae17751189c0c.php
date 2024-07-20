<script src="<?php echo e(URL::asset('assets/libs/bootstrap/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/libs/simplebar/simplebar.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/libs/node-waves/node-waves.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/libs/feather-icons/feather-icons.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/pages/plugins/lord-icon-2.1.0.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/plugins.min.js')); ?>"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
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
                    } else if ((notification.type === 'App\\Notifications\\FeedbackToReview') || (
                            notification.type === 'App\\Notifications\\FeedbackReply')) {
                        href = `<?php echo e(route('admin.displayFeedbacks')); ?>`;
                    } else if ((notification.type === 'App\\Notifications\\FeedbackReplied')) {
                        href = 'javascript:void(0)';
                    } else {
                        href = `<?php echo e(route('user.itemDetail', ['id' => ':report_id'])); ?>`
                            .replace(':report_id', notification.data.report_id);
                    }

                    return `
                                    <div class="text-reset notification-item d-block dropdown-item position-relative ${isRead}" 
                    data-notification-id="${notification.id}" data-notification-type="${notification.type}"
                        data-feedback-id="${notification.data.feedback_id}"
                                                                style="background-color: ${backgroundColor};">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-soft-info text-info rounded-circle fs-16">
                                                    <i class="bx bx-badge-check"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                            <a href=${href} class="stretched-link notification-link">
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
                attachNotificationLinkListeners();
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

        function attachNotificationLinkListeners() {
            document.addEventListener('click', function(event) {
                const target = event.target;
                if (target.matches('.notification-link, .notification-link *')) {
                    const notificationItem = target.closest('.notification-item');
                    const notificationType = notificationItem.getAttribute('data-notification-type');

                    if (notificationType === 'App\\Notifications\\FeedbackReplied') {
                        event.preventDefault();
                        const feedbackId = notificationItem.getAttribute('data-feedback-id');
                        axios.get(`/admin/feedbacks/${feedbackId}`)
                            .then(response => {
                                const feedback = response.data;

                                const feedbackMessage = feedback.message ? feedback.message :
                                    'No message available';
                                const feedbackReply = feedback.reply ? feedback.reply :
                                    'No reply available';
                                const createdAt = feedback.created_at ? new Date(feedback
                                    .created_at).toLocaleString('en-GB') : 'Date not available';
                                const updatedAt = feedback.updated_at ? new Date(feedback
                                    .updated_at).toLocaleString('en-GB') : 'Date not available';

                                const feedbackContent = `
                            <div class="card mb-3">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">Feedback Message</h6>
                                </div>
                                <div class="card-body">
                                    <p>${feedbackMessage}</p>
                                    <p><strong>Date:</strong> ${createdAt}</p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0">Feedback Reply</h6>
                                </div>
                                <div class="card-body">
                                    <p>${feedbackReply}</p>
                                    <p><strong>Date:</strong> ${updatedAt}</p>
                                </div>
                            </div>`;
                                document.getElementById('feedbackContent').innerHTML =
                                    feedbackContent;
                                const feedbackReplyModal = new bootstrap.Modal(document
                                    .getElementById(
                                        'feedbackReplyModal'));
                                feedbackReplyModal.show();

                                // Attach event listener to remove backdrop when modal is hidden
                                document.getElementById('feedbackReplyModal').addEventListener(
                                    'hidden.bs.modal',
                                    function() {
                                        const backdrop = document.querySelector(
                                            '.modal-backdrop');
                                        if (backdrop) {
                                            backdrop.remove();
                                        }
                                    });
                            })
                            .catch(error => {
                                console.error('Error fetching feedback:', error);
                            });
                    }
                }
            });
        }
    });
</script>
<?php echo $__env->yieldContent('script'); ?>
<?php echo $__env->yieldContent('script-bottom'); ?>
<?php /**PATH C:\xampp\htdocs\FYP\resources\views/layouts/vendor-scripts.blade.php ENDPATH**/ ?>