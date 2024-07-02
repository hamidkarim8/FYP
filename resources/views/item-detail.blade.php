@extends('layouts.master-without-nav')
@section('title')
    Landing
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}" rel="stylesheet" type="text/css" />
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
@endsection
@section('body')

    <body data-bs-spy="scroll" data-bs-target="#navbar-example">
    @endsection
    @section('content')
        <!-- Begin page -->
        <div class="layout-wrapper landing">

            @include('layouts-user.navbar')
            <!-- end navbar -->

            <section class="section bg-light">
                <div class="bg-overlay bg-overlay-pattern"></div>
                <div class="container mt-4 pt-4">
                    <div
                        class="card {{ $report->isResolved === 'resolved' ? 'ribbon-box right border shadow-none overflow-hidden' : '' }}  mt-n5">
                        <div class="card-body p-4">
                            @if ($report->isResolved == 'resolved')
                                <div class="ribbon ribbon-success ribbon-shape trending-ribbon">
                                    <i class=" ri-check-line text-white align-bottom float-start me-1"></i>
                                    <span class="trending-ribbon-text">Resolved</span>
                                </div>
                            @endif
                            <div class="row g-4">
                                <div class="col-xl-4 col-lg-6">
                                    <div class="sticky-side-div">
                                        <div class="card ribbon-box border shadow-none left">
                                            <div class="card-body">
                                                <!-- Swiper -->
                                                <div class="swiper pagination-fraction-swiper rounded">
                                                    <div class="swiper-wrapper">
                                                        @foreach ($report->item->image_paths as $image)
                                                            <div class="swiper-slide">
                                                                <div
                                                                    class="ribbon-two {{ $report->item->type === 'lost' ? 'ribbon-two-danger' : 'ribbon-two-secondary' }}">
                                                                    <span>{{ ucfirst($report->item->type) }}</span>
                                                                </div>
                                                                <img src="{{ asset($image) }}"
                                                                    alt="{{ $report->item->title }}" class="img-fluid" />
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="swiper-button-next bg-white shadow"></div>
                                                    <div class="swiper-button-prev bg-white shadow"></div>
                                                    <div class="swiper-pagination"></div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- {{optional($report->checkRequests)->user_id}}
                                        {{Auth::id()}}
                                        {{$report->pendingRequests}} --}}
                                        {{-- {{$report->requests}}
                                        {{optional($report->checkRequests)->status == 'pending'}} --}}
                                        @if (Auth::check() && Auth::id() != $report->user_id)
                                            @php
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
                                            @endphp
                                            {{-- approved:{{$approvedRequests}}
                                            pending:{{$pendingRequests}}
                                            check: {{$approvedRequests->isNotEmpty()}}
                                            check2: {{Auth::check() && Auth::id() != $report->user_id && $approvedRequests->isEmpty()}} --}}
                                            @if ($approvedRequests->count() > 0)
                                                <span class="badge bg-success text-center w-100">Request Approved</span>
                                            @elseif ($pendingRequests->count() > 0)
                                                <span class="badge bg-warning text-center w-100">Request Pending</span>
                                            @elseif ($declinedRequests->count() > 0)
                                                <span class="badge bg-danger text-center w-100">Request Declined</span>
                                            @else
                                                <div class="hstack gap-2">
                                                    @if ($report->item->type === 'found')
                                                        <button class="btn btn-primary w-100"
                                                            onclick="requestAction('{{ $report->id }}', 'contact')">Request
                                                            to Contact</button>
                                                    @else
                                                        <button class="btn btn-primary w-100"
                                                            onclick="requestAction('{{ $report->id }}', 'proof_of_ownership')">Request
                                                            Proof of Ownership</button>
                                                    @endif
                                                </div>
                                            @endif
                                        @else
                                            {{-- self report --}}
                                            <!-- Button to open modal for self-reported item -->
                                            @if (Auth::check() && Auth::id() == $report->user_id)
                                                <button class="btn btn-success w-100" data-bs-toggle="modal"
                                                    data-bs-target="#requestsModal">View Requests</button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-8">
                                    @if (Auth::check() && Auth::id() == $report->user_id)
                                        <span class="badge badge-soft-info mb-3 fs-12">
                                            <i class="ri-eye-line me-1 align-bottom"></i>Reported by you
                                        </span>
                                        @if ($report->isResolved != 'resolved')
                                            <div class="dropdown float-end">
                                                <button class="btn btn-ghost-primary btn-icon dropdown" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle fs-16"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item edit-item-btn" href="#showModal"
                                                            data-bs-toggle="modal"><i
                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                            Edit</a></li>
                                                    <li><a class="dropdown-item remove-item-btn" data-bs-toggle="modal"
                                                            href="#deleteRecordModal"><i
                                                                class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                            Delete</a></li>
                                                    <li><a class="dropdown-item resolved-item-btn" data-bs-toggle="modal"
                                                            href="#resolvedItemModal"><i
                                                                class="ri-checkbox-circle-fill align-bottom me-2 text-muted"></i>
                                                            Mark as Resolved</a></li>
                                                </ul>
                                            </div>
                                        @endif
                                    @endif
                                    <div>
                                        <h3>{{ $report->item->title }} | {{ $report->item->category->name }}</h3>
                                        <div class="hstack gap-3 flex-wrap mt-4">
                                            <div class="text-muted">Reporter: @if (Auth::check() && Auth::id() != $report->user_id && $approvedRequests->isEmpty())
                                                    <span class="text-danger fw-medium">[Hidden]</span>
                                                @else
                                                    <span class="text-body fw-medium">{{ $report->item->fullname }}</span>
                                                @endif
                                            </div>
                                            <div class="vr"></div>
                                            <div class="text-muted">Date ({{ $report->item->type }}): <span
                                                    class="text-body fw-medium">{{ $report->item->date->format('d-m-Y') }}</span>
                                            </div>
                                            <div class="vr"></div>
                                            <div class="text-muted">Reported on: <span
                                                    class="text-body fw-medium">{{ $report->created_at->format('d-m-Y') }}</span>
                                            </div>
                                        </div>
                                        <!--end row-->
                                        <div class="mt-4 text-muted">
                                            <h5 class="fs-14">Description:</h5>
                                            <p>{{ $report->item->description }}</p>
                                        </div>
                                        <div class="mt-4 text-muted">
                                            <h5 class="fs-14">Retrieval Info:</h5>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div class="text-muted">Phone Number: @if (Auth::check() && Auth::id() != $report->user_id && $approvedRequests->isEmpty())
                                                        <span class="text-danger fw-medium">[Hidden]</span>
                                                    @else
                                                        <span
                                                            class="text-body fw-medium">{{ $report->item->phone_number }}</span>
                                                    @endif
                                                </div>
                                                <div class="vr"></div>
                                                <div class="text-muted">Email: @if (Auth::check() && Auth::id() != $report->user_id && $approvedRequests->isEmpty())
                                                        <span class="text-danger fw-medium">[Hidden]</span>
                                                    @else
                                                        <span class="text-body fw-medium">{{ $report->item->email }}</span>
                                                    @endif
                                                </div>
                                                <div class="vr"></div>
                                                <div class="text-muted">
                                                    Social Media:
                                                    @if (Auth::check() && Auth::id() != $report->user_id && $approvedRequests->isEmpty())
                                                        <span class="text-danger fw-medium">[Hidden]</span>
                                                    @else
                                                        <br>
                                                        <span class="text-body fw-medium">
                                                            @foreach ($report->item->social_media as $key => $value)
                                                                @if ($value)
                                                                    @php
                                                                        $platform = '';
                                                                        if (strpos($key, 'ig_') !== false) {
                                                                            $platform = 'Instagram';
                                                                        } elseif (strpos($key, 'twitter_') !== false) {
                                                                            $platform = 'Twitter';
                                                                        } elseif (strpos($key, 'tiktok_') !== false) {
                                                                            $platform = 'TikTok';
                                                                        }
                                                                    @endphp

                                                                    @if ($platform)
                                                                        {{ $platform }}: {{ $value }}<br>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </span>
                                                    @endif
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
                                                                    <td>{{ $report->item->location['desc'] }}</td>
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
            <!-- Edit Report Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form id="editForm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Report</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="fullname" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="number" class="form-control" id="phone_number" name="phone_number"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <input type="hidden" id="date" name="date">
                                <div class="mb-3">
                                    <label for="ig_username" class="form-label">Instagram</label>
                                    <div class="input-group">
                                        <div class="input-group-text">@</div>
                                        <input type="text" class="form-control" id="socialmedia_ig"
                                            name="ig_username">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="twt_username" class="form-label">Twitter</label>
                                    <div class="input-group">
                                        <div class="input-group-text">@</div>
                                        <input type="text" class="form-control" id="socialmedia_twt"
                                            name="twt_username">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="tt_username" class="form-label">Tiktok</label>
                                    <div class="input-group">
                                        <div class="input-group-text">@</div>
                                        <input type="text" class="form-control" id="socialmedia_tt"
                                            name="tt_username">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this report?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resolved Confirmation Modal -->
            <div class="modal fade" id="resolvedItemModal" tabindex="-1" aria-labelledby="resolvedModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="resolvedModalLabel">Confirm Resolved</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you have resolved this report?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-success" id="confirmResolvedBtn">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Start footer -->
            @include('layouts-user.footer')
            <!-- end footer -->

        </div>
        <!-- end layout wrapper -->
    @endsection
    @section('script')
        <script src="{{ URL::asset('/assets/libs/swiper/swiper.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/js/pages/swiper.init.js') }}"></script>
        <script src="{{ URL::asset('/assets/js/pages/landing.init.js') }}"></script>
        <script src="{{ URL::asset('/assets/libs/jsvectormap/jsvectormap.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-wizard.init.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/apps-nft-explore.init.js') }}"></script>
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
                        _token: '{{ csrf_token() }}'
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
                        _token: '{{ csrf_token() }}'
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
                const reportId = '{{ $report->id }}';
                loadRequests(reportId);

                var reportLat = @json($report->item->location['lat']);
                var reportLng = @json($report->item->location['lng']);
                var reportType = @json($report->item->type);
                var reportTitle = @json($report->item->title);
                var reportDesc = @json($report->item->location['desc']);

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
                            if ((notification.type === 'App\\Notifications\\SimpleReportSubmitted') || (
                                    notification.type === 'App\\Notifications\\DeleteItemDetails')|| (
                                        notification.type === 'App\\Notifications\\FeedbackSubmitted')) {
                                href = '/home#hero';
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

                function fillEditForm(report) {
                    document.getElementById('title').value = report.item.title;
                    document.getElementById('description').value = report.item.description;
                    document.getElementById('phone_number').value = report.item.phone_number;
                    document.getElementById('email').value = report.item.email;
                    document.getElementById('fullname').value = report.item.fullname;
                    let date = new Date(report.item.date);
                    let formattedDate = date.toISOString().substring(0, 19);
                    document.getElementById('date').value = formattedDate;
                    document.getElementById('socialmedia_ig').value = report.item.social_media.ig_username ? report.item
                        .social_media.ig_username : "";
                    document.getElementById('socialmedia_twt').value = report.item.social_media.twitter_username ?
                        report.item.social_media.twitter_username : "";
                    document.getElementById('socialmedia_tt').value = report.item.social_media.tiktok_username ? report
                        .item.social_media.tiktok_username : "";
                }

                // Handle Edit button click
                document.querySelector('.edit-item-btn').addEventListener('click', function(event) {
                    event.preventDefault();
                    const reportId = '{{ $report->id }}';
                    fetch(`/item/edit/${reportId}`)
                        .then(response => response.json())
                        .then(data => {
                            fillEditForm(data.report);
                            console.log(data.report.item);
                            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                            editModal.show();
                        })
                        .catch(error => console.error('Error fetching report data:', error));
                });

                // Handle Edit form submission
                document.getElementById('editForm').addEventListener('submit', function(event) {
                    event.preventDefault();
                    const reportId = '{{ $report->id }}';
                    const formData = new FormData(this);
                    fetch(`/item/update/${reportId}`, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                alert('Report updated successfully!');
                                location.reload();
                            }
                        })
                        .catch(error => console.error('Error updating report:', error));
                });

                // Handle Delete button click
                document.querySelector('.remove-item-btn').addEventListener('click', function(event) {
                    event.preventDefault();
                    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    deleteModal.show();
                });

                // Handle Delete confirmation
                document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                    const reportId = '{{ $report->id }}';
                    fetch(`/item/delete/${reportId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                alert('Report deleted successfully!');
                                window.location.href = '/';
                            }
                        })
                        .catch(error => console.error('Error deleting report:', error));
                });

                // Handle Resolved button click
                document.querySelector('.resolved-item-btn').addEventListener('click', function(event) {
                    event.preventDefault();
                    const resolvedItemModal = new bootstrap.Modal(document.getElementById('resolvedItemModal'));
                    resolvedItemModal.show();
                });

                // Handle Resolved confirmation
                document.getElementById('confirmResolvedBtn').addEventListener('click', function() {
                    const reportId = '{{ $report->id }}';
                    fetch(`/item/resolved/${reportId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                alert('Report marked as resolved!');
                                window.location.href = '/';
                            }
                        })
                        .catch(error => console.error('Error resolving report:', error));
                });
            });
        </script>
    @endsection
