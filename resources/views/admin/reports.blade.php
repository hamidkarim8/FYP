@extends('layouts.master')
@section('title')
    Report List
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}" rel="stylesheet" type="text/css" />
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
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dashboards
        @endslot
        @slot('title')
            Reports
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Report List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="reportList" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Report ID</th>
                                    <th>Report Type</th>
                                    <th>Found/Lost Date</th>
                                    <th>Report Date</th>
                                    <th>Status</th>
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

    <!-- View Report Modal -->
    <div class="modal fade" id="viewReportModal" tabindex="-1" aria-labelledby="viewReportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewReportModalLabel">View Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Report details will be loaded here dynamically -->
                    <div id="report-details"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Report Modal -->
    <div class="modal fade" id="deleteReportModal" tabindex="-1" aria-labelledby="deleteReportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteReportModalLabel">Delete Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="deleteReportForm">
                        @csrf
                        <input type="hidden" id="delete_report_id" name="report_id">
                        <div class="mb-3">
                            <label for="deleted_type" class="form-label">Reason for Deletion</label>
                            <select class="form-select" id="deleted_type" name="deleted_type" required>
                                <option value="" selected>-- Select Reason --</option>
                                <option value="duplicate">Duplicate</option>
                                <option value="irrelevant">Irrelevant</option>
                                <option value="malicious">Malicious</option>
                                <option value="fraudulent">Fraudulent</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Enter remarks"></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('/assets/libs/swiper/swiper.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/swiper.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#reportList').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.getReports') }}",
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'item.date',
                        name: 'item.date',
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
                        data: 'isResolved',
                        name: 'isResolved',
                        render: function(data, type, row) {
                            var badgeClass = data == 'resolved' ? 'badge bg-success' :
                                'badge bg-danger';
                            var statusText = data == 'resolved' ? 'Resolved' : 'Unresolved';
                            return '<span class="' + badgeClass + '">' + statusText + '</span>';
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

            $('#reportList').on('click', '.view-report', function(e) {
                e.preventDefault();
                var reportId = $(this).data('id');
                axios.get("admin/reports/" + reportId)
                    .then(function(response) {
                        var report = response.data;
                        if (report.error) {
                            alert(report.error);
                        } else {
                            var itemDetails = '<div><h4 class="mb-4">Item Details</h4>';
                            var userDetails = '<div><h4 class="mt-4 mb-4">User Profile</h4>';

                            if (report.type === 'detailed') {
                                itemDetails += '<p><strong>Title:</strong> ' + report.item.title +
                                    '</p>';
                                itemDetails += '<p><strong>Type:</strong> <span class="badge ' + (report
                                        .item.type === 'lost' ? 'bg-danger' : 'bg-secondary') + '">' +
                                    report.item.type.toUpperCase() + '</span></p>';
                                itemDetails += '<p><strong>Category:</strong> ' + report.item.category
                                    .name + '</p>';

                                itemDetails += '<p><strong>Image:</strong></p>';
                                if (report.item.image_paths) {
                                    var images = JSON.parse(report.item.image_paths);
                                    if (Array.isArray(images) && images.length > 0) {
                                        itemDetails +=
                                            '<div class="swiper pagination-fraction-swiper rounded">' +
                                            '<div class="swiper-wrapper">';
                                        images.forEach(function(imagePath) {
                                            itemDetails += '<div class="swiper-slide">' +
                                                '<img src="' + imagePath + '" alt="' + report
                                                .item.title +
                                                '" class="img-fluid swiper-image" />' +
                                                '</div>';
                                        });
                                        itemDetails += '</div>' +
                                            '<div class="swiper-button-next bg-white shadow"></div>' +
                                            '<div class="swiper-button-prev bg-white shadow"></div>' +
                                            '<div class="swiper-pagination"></div>' +
                                            '</div>';
                                    }
                                }

                                itemDetails += '<p><strong>Description:</strong> ' + (report.item
                                        .description ? report.item.description : 'Not provided') +
                                    '</p>';
                                itemDetails += '<p><strong>' + (report.item.type === 'lost' ? "Lost" :
                                    "Found") + ' Date:</strong> ' + (report.item.date ? new Date(
                                    report.item.date).toLocaleString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit'
                                }) : 'Not provided') + '</p>';
                                itemDetails += '<p><strong>Report Date:</strong> ' + (report.item
                                    .created_at ? new Date(report.item.created_at).toLocaleString(
                                        'en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric',
                                            hour: '2-digit',
                                            minute: '2-digit',
                                            second: '2-digit'
                                        }) : 'Not provided') + '</p>';
                                itemDetails += '<p><strong>Location Description:</strong> ' + (report
                                    .item.location.desc ? report.item.location.desc : 'Not provided'
                                ) + '</p>';

                                userDetails += '<p><strong>Name:</strong> ' + (report.user.profile
                                    .fullname ? report.user.profile.fullname : 'Anonymous Reporter'
                                ) + '</p>';
                                userDetails += '<p><strong>Email:</strong> ' + (report.user.email ?
                                    report.user.email : 'Not provided') + '</p>';
                                userDetails += '<p><strong>Phone Number:</strong> ' + (report.user
                                    .profile.phone_number ? report.user.profile.phone_number :
                                    'Not provided') + '</p>';

                                if (report.user.profile.social_media) {
                                    var socialMedia = JSON.parse(report.user.profile.social_media);
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
                                itemDetails += '<p><strong>Type:</strong> <span class="badge ' + (report
                                        .item.type === 'lost' ? 'bg-danger' : 'bg-secondary') + '">' +
                                    report.item.type.toUpperCase() + '</span></p>';
                                itemDetails += '<p><strong>Location Description:</strong> ' + (report
                                    .item.location.desc ? report.item.location.desc : 'Not provided'
                                ) + '</p>';
                                itemDetails += '<p><strong>' + (report.item.type === 'lost' ? "Lost" :
                                    "Found") + ' Date:</strong> ' + (report.item.date ? new Date(
                                    report.item.date).toLocaleString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit'
                                }) : 'Not provided') + '</p>';

                                userDetails += '<p><strong>Name:</strong> Anonymous Reporter</p>';
                            }

                            itemDetails += '</div>';
                            userDetails += '</div>';

                            $('#report-details').html(itemDetails + '<hr>' + userDetails);
                            $('#viewReportModal').modal('show');
                            $('#viewReportModal').on('shown.bs.modal', function() {
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
                        alert('Error fetching report details: ' + error.message);
                    });
            });

            // Delete Report
            $('#reportList').on('click', '.delete-report', function(e) {
                e.preventDefault();
                var reportId = $(this).data('id');

                // Set report id in the modal form
                $('#delete_report_id').val(reportId);

                // Open confirmation modal
                $('#deleteReportModal').modal('show');
            });

            // Handle form submission for delete confirmation
            $('#deleteReportForm').submit(function(e) {
                e.preventDefault();

                var reportId = $('#delete_report_id').val();

                // Perform delete action
                axios.delete("{{ url('admin/reports') }}/" + reportId, {
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'deleted_type': $('#deleted_type').val(),
                            'remarks': $('#remarks').val()
                        }
                    })
                    .then(function(response) {
                        alert(response.data.success);
                        $('#deleteReportModal').modal('hide'); // Close modal after successful deletion
                        table.ajax.reload(); // Reload table after deletion
                    })
                    .catch(function(error) {
                        alert('Error deleting report: ' + error.message);
                    });
            });

        });
        document.addEventListener('DOMContentLoaded', function() {
                        //call notification
                        fetchNotifications();
            setInterval(fetchNotifications, 60000);

            function fetchNotifications() {
                axios.get('{{ route('notifications.fetch') }}')
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
                    <img src="{{ URL::asset('assets/images/svg/bell.svg') }}" class="img-fluid"
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
                            href = `{{ route('user.itemDetail', ['id' => ':report_id']) }}`
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
@endsection
