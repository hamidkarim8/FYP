
<?php $__env->startSection('title'); ?>
    Landing
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/jsvectormap/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="<?php echo e(URL::asset('assets/libs/swiper/swiper.min.css')); ?>" rel="stylesheet" type="text/css" />
    <style>
        .map-container {
            height: 300px;
            max-width: 500px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .map-container {
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-bs-spy="scroll" data-bs-target="#navbar-example">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- Begin page -->
        <div class="layout-wrapper landing">

            <?php echo $__env->make('layouts-user.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!-- end navbar -->

            <section class="section bg-light">
                <div class="bg-overlay bg-overlay-pattern"></div>
                <div class="container mt-4 pt-4">
                    <div class="card mt-n5">
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-xl-4 col-lg-6">
                                    <div class="sticky-side-div">
                                        <div class="card ribbon-box border shadow-none left">
                                            <div class="card-body">
                                                <!-- Swiper -->
                                                <div class="swiper pagination-fraction-swiper rounded">
                                                    <div class="swiper-wrapper">
                                                        <?php $__currentLoopData = $report->item->image_paths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="swiper-slide">
                                                                <div
                                                                    class="ribbon-two <?php echo e($report->item->type === 'lost' ? 'ribbon-two-danger' : 'ribbon-two-secondary'); ?>">
                                                                    <span><?php echo e(ucfirst($report->item->type)); ?></span>
                                                                </div>
                                                                <img src="<?php echo e(asset($image)); ?>"
                                                                    alt="<?php echo e($report->item->title); ?>" class="img-fluid" />
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                    <div class="swiper-button-next bg-white shadow"></div>
                                                    <div class="swiper-button-prev bg-white shadow"></div>
                                                    <div class="swiper-pagination"></div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        <?php if(Auth::check() && Auth::id() != $report->user_id): ?>
                                            <?php
                                                $loggedInUserId = Auth::id();
                                                $pendingRequests = $report
                                                    ->pendingRequests()
                                                    ->where('user_id', $loggedInUserId)
                                                    ->get();
                                                $approvedRequests = $report
                                                    ->approvedRequests()
                                                    ->where('user_id', $loggedInUserId)
                                                    ->get();
                                                $declinedRequests = $report
                                                    ->declinedRequests()
                                                    ->where('user_id', $loggedInUserId)
                                                    ->get();
                                            ?>
                                            
                                            <?php if($approvedRequests->count() > 0): ?>
                                                <span class="badge bg-success text-center w-100">Request Approved</span>
                                            <?php elseif($pendingRequests->count() > 0): ?>
                                                <span class="badge bg-warning text-center w-100">Request Pending</span>
                                            <?php elseif($declinedRequests->count() > 0): ?>
                                                <span class="badge bg-danger text-center w-100">Request Declined</span>
                                            <?php else: ?>
                                                <div class="hstack gap-2">
                                                    <?php if($report->item->type === 'found'): ?>
                                                        <button class="btn btn-primary w-100"
                                                            onclick="requestAction('<?php echo e($report->id); ?>', 'contact')">Request
                                                            to Contact</button>
                                                    <?php else: ?>
                                                        <button class="btn btn-primary w-100"
                                                            onclick="requestAction('<?php echo e($report->id); ?>', 'proof_of_ownership')">Request
                                                            Proof of Ownership</button>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            
                                            <!-- Button to open modal for self-reported item -->
                                            <?php if(Auth::check() && Auth::id() == $report->user_id): ?>
                                                <button class="btn btn-success w-100" data-bs-toggle="modal"
                                                    data-bs-target="#requestsModal">View Requests</button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-8">
                                    <?php if(Auth::check() && Auth::id() == $report->user_id): ?>
                                        <span class="badge badge-soft-info mb-3 fs-12">
                                            <i class="ri-eye-line me-1 align-bottom"></i>Reported by you
                                        </span>
                                    <?php endif; ?>
                                    <div>
                                        <h3><?php echo e($report->item->title); ?> | <?php echo e($report->item->category->name); ?></h3>
                                        <div class="hstack gap-3 flex-wrap mt-4">
                                            <div class="text-muted">Reporter: <?php if(Auth::check() && Auth::id() != $report->user_id && $approvedRequests->isEmpty()): ?>
                                                    <span class="text-danger fw-medium">[Hidden]</span>
                                                <?php else: ?>
                                                    <span class="text-body fw-medium"><?php echo e($report->item->fullname); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="vr"></div>
                                            <div class="text-muted">Date (<?php echo e($report->item->type); ?>): <span
                                                    class="text-body fw-medium"><?php echo e($report->item->date->format('d-m-Y')); ?></span>
                                            </div>
                                            <div class="vr"></div>
                                            <div class="text-muted">Reported on: <span
                                                    class="text-body fw-medium"><?php echo e($report->created_at->format('d-m-Y')); ?></span>
                                            </div>
                                        </div>
                                        <!--end row-->
                                        <div class="mt-4 text-muted">
                                            <h5 class="fs-14">Description:</h5>
                                            <p><?php echo e($report->item->description); ?></p>
                                        </div>
                                        <div class="mt-4 text-muted">
                                            <h5 class="fs-14">Retrieval Info:</h5>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div class="text-muted">Phone Number: <?php if(Auth::check() && Auth::id() != $report->user_id && $approvedRequests->isEmpty()): ?>
                                                        <span class="text-danger fw-medium">[Hidden]</span>
                                                    <?php else: ?>
                                                        <span
                                                            class="text-body fw-medium"><?php echo e($report->item->phone_number); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="vr"></div>
                                                <div class="text-muted">Email: <?php if(Auth::check() && Auth::id() != $report->user_id && $approvedRequests->isEmpty()): ?>
                                                        <span class="text-danger fw-medium">[Hidden]</span>
                                                    <?php else: ?>
                                                        <span class="text-body fw-medium"><?php echo e($report->item->email); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="vr"></div>
                                                <div class="text-muted">
                                                    Social Media:
                                                    <?php if(Auth::check() && Auth::id() != $report->user_id && $approvedRequests->isEmpty()): ?>
                                                        <span class="text-danger fw-medium">[Hidden]</span>
                                                    <?php else: ?>
                                                        <br>
                                                        <span class="text-body fw-medium">
                                                            <?php $__currentLoopData = $report->item->social_media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if($value): ?>
                                                                    <?php
                                                                        $platform = '';
                                                                        if (strpos($key, 'ig_') !== false) {
                                                                            $platform = 'Instagram';
                                                                        } elseif (strpos($key, 'twitter_') !== false) {
                                                                            $platform = 'Twitter';
                                                                        } elseif (strpos($key, 'tiktok_') !== false) {
                                                                            $platform = 'TikTok';
                                                                        }
                                                                    ?>

                                                                    <?php if($platform): ?>
                                                                        <?php echo e($platform); ?>: <?php echo e($value); ?><br>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-content mt-4">
                                            <h5 class="fs-14 mb-3">Location Information:</h5>
                                            <nav>
                                                <ul class="nav nav-tabs nav-tabs-custom nav-success" id="nav-tab"
                                                    role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="nav-speci-tab" data-bs-toggle="tab"
                                                            href="#nav-speci" role="tab" aria-controls="nav-speci"
                                                            aria-selected="true">Map</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="nav-additional-tab" data-bs-toggle="tab"
                                                            href="#nav-additional" role="tab"
                                                            aria-controls="nav-additional"
                                                            aria-selected="false">Description</a>
                                                    </li>
                                                </ul>
                                            </nav>
                                            <div class="tab-content border border-top-0 p-4" id="nav-tabContent">
                                                <div class="tab-pane fade show active" id="nav-speci" role="tabpanel"
                                                    aria-labelledby="nav-speci-tab">
                                                    <div class="embed-responsive embed-responsive-16by9">
                                                        <div id="displayDetailReportMap" class="map-container"></div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="nav-additional" role="tabpanel"
                                                    aria-labelledby="nav-additional-tab">
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row" style="width: 200px;">Description:
                                                                    </th>
                                                                    <td><?php echo e($report->item->location['desc']); ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                    </div>
                    <!--end card-->
                </div>
            </section>

            <!-- Requests Modal -->
            <div class="modal fade" id="requestsModal" tabindex="-1" aria-labelledby="requestsModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="requestsModalLabel">Pending Requests</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="requestsTableBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Start footer -->
            <?php echo $__env->make('layouts-user.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!-- end footer -->

        </div>
        <!-- end layout wrapper -->
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <script src="<?php echo e(URL::asset('/assets/libs/swiper/swiper.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('/assets/js/pages/swiper.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('/assets/js/pages/landing.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('/assets/libs/jsvectormap/jsvectormap.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/js/pages/form-wizard.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/js/pages/apps-nft-explore.init.js')); ?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script>
            function loadRequests(reportId) {
                fetch(`/reports/${reportId}/requests`)
                    .then(response => response.json())
                    .then(data => {
                        const requestsTableBody = document.getElementById('requestsTableBody');
                        requestsTableBody.innerHTML = '';

                        if (data.requests.length === 0) {
                            const noRequestsRow = document.createElement('tr');
                            noRequestsRow.innerHTML = `
                    <td colspan="4" class="text-center text-danger">No requests found.</td>
                `;
                            requestsTableBody.appendChild(noRequestsRow);
                        } else {
                            data.requests.forEach(request => {
                                console.log(request);
                                const row = document.createElement('tr');
                                let phone = request.profile.phone_number ? request.profile.phone_number :
                                    'Not Updated';
                                let fullname = request.profile.fullname ? request.profile.fullname : 'Not Updated';
                                row.innerHTML = `
                        <td>${fullname}</td>
                        <td>${request.user.email}</td>
                        <td>${phone}</td>
                        <td><button class="btn btn-success" onclick="acceptRequest(${request.id})">Accept</button>
                            <button class="btn btn-danger" onclick="declineRequest(${request.id})">Decline</button>
                        </td>
                    `;
                                console.log("request id: " + request.id);
                                console.log("report id: " + reportId);
                                requestsTableBody.appendChild(row);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error loading requests:', error);
                    });
            }


            function acceptRequest(requestId) {
                axios.post('/accept-request/' + requestId, {
                        _token: '<?php echo e(csrf_token()); ?>'
                    })
                    .then(response => {
                        if (response.data.status === 'success') {
                            alert('Request accepted successfully!');
                            // $('#requestsModal').modal('hide');
                            location.reload();
                        }
                    }).catch(error => {
                        console.error('Error accepting request:', error);
                    });
            }

            function declineRequest(requestId) {
                axios.post('/decline-request/' + requestId, {
                        _token: '<?php echo e(csrf_token()); ?>'
                    })
                    .then(response => {
                        if (response.data.status === 'success') {
                            alert('Request declined successfully!');
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error declining request:', error);
                    });
            }

            function requestAction(reportId, type) {
                axios.post('/reports/' + reportId + '/request-action', {
                    type: type
                }).then(response => {
                    if (response.data.status === 'success') {
                        alert('Request sent successfully!');
                        location.reload();
                    } else {
                        alert('Request already exists!');
                    }
                }).catch(error => {
                    console.error('Error requesting action:', error);
                });
            }
            document.addEventListener('DOMContentLoaded', function() {

                //call notification
                fetchNotifications();
                setInterval(fetchNotifications, 60000);

                //load req table
                const reportId = '<?php echo e($report->id); ?>';
                loadRequests(reportId);

                var reportLat = <?php echo json_encode($report->item->location['lat'], 15, 512) ?>;
                var reportLng = <?php echo json_encode($report->item->location['lng'], 15, 512) ?>;
                var reportType = <?php echo json_encode($report->item->type, 15, 512) ?>;
                var reportTitle = <?php echo json_encode($report->item->title, 15, 512) ?>;
                var reportDesc = <?php echo json_encode($report->item->location['desc'], 15, 512) ?>;

                // Initialize the map
                var displayDetailReportMap = L.map('displayDetailReportMap').setView([3.05603, 101.70022], 17);

                // Add a tile layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(displayDetailReportMap);

                // Add a marker
                var markerColor = reportType === 'found' ? 'blue' : 'red';
                var marker = L.circleMarker([reportLat, reportLng], {
                    color: markerColor,
                    radius: 10
                }).addTo(displayDetailReportMap);

                // Add popup to the marker
                marker.bindPopup("<b>" + reportTitle + "</b><br>" + reportDesc).openPopup();

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
            <div class="text-reset notification-item d-block dropdown-item position-relative">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="mt-0 mb-2 lh-base text-center">No notifications</h6>
                    </div>
                </div>
            </div>
        `;
                    } else {
                        notificationHTML = notifications.map(notification => {
                            const isRead = notification.read_at !== null ? 'read' : 'unread';
                            const backgroundColor = notification.read_at !== null ? '#f0f0f0' : '#ffffff';

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
                            <a href="/home#items" class="stretched-link">
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

<?php echo $__env->make('layouts.master-without-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\FYP-TESTING\resources\views\item-detail.blade.php ENDPATH**/ ?>