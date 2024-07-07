@extends('layouts.master-without-nav')
@section('title')
    Landing
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('body')

    <body data-bs-spy="scroll" data-bs-target="#navbar-example">
    @endsection
    @section('content')
        <!-- Begin page -->
        <div class="layout-wrapper landing">

            @include('layouts-user.navbar')
            <!-- end navbar -->

            <!-- start items -->
            <section class="section bg-light" id="items">
                <div class="bg-overlay bg-overlay-pattern"></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="text-center mb-5">
                                <h2 class="mb-3 fw-semibold lh-base">Explore Your Reported Items</h2>
                                <p class="text-muted mb-4">Explore the list below and click on the card
                                    for more details.</p>
                                <ul class="nav nav-pills filter-btns justify-content-center" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link fw-medium active" type="button" data-filter="all">All
                                            Items</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link fw-medium" type="button" data-filter="lost">Lost</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link fw-medium" type="button" data-filter="found">Found</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link fw-medium" type="button" data-toggle="tooltip"
                                            data-placement="bottom" title="Filtering based on your report"
                                            data-filter="auto" id="auto-matching-btn">Auto-matching</button>

                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link fw-medium" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseWithicon2" aria-expanded="false"
                                            aria-controls="collapseWithicon2" data-toggle="tooltip" data-placement="bottom"
                                            title="Filter">
                                            <i class="ri-filter-2-line"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- end col -->
                        <div class="collapse" id="collapseWithicon2">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h5 class="card-title mb-0 fw-semibold flex-grow-1">Filter Item</h5>
                                            <button type="button" class="btn btn-md btn-outline-primary"
                                                id="closeFilterBtn">
                                                <i class="ri-close-fill"></i> Close
                                            </button>
                                        </div>
                                        <div class="row row-cols-xxl-5 row-cols-lg-3 row-cols-md-2 row-cols-1 mt-3 g-3">
                                            <div class="col">
                                                <h6 class="text-uppercase fs-12 mb-2">Search</h6>
                                                <input type="text" class="form-control" placeholder="Search item keyword"
                                                    autocomplete="off" id="searchItem">
                                            </div>
                                            <div class="col">
                                                <h6 class="text-uppercase fs-12 mb-2">Select Type</h6>
                                                <select class="form-control" id="item-type" name="select-type">
                                                    <option value="" selected>Select Type</option>
                                                    <option value="found">Found</option>
                                                    <option value="lost">Lost</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <h6 class="text-uppercase fs-12 mb-2">Select Category</h6>
                                                <select class="form-control" id="item-category" data-choices
                                                    name="select-category" data-choices-search-false>
                                                    <option value="" selected>Select Category</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fs-14 mb-0">Filter Result: <span id="filter-result-count"><span
                                                    id="totalItemsCount"></span></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end row -->
                    <div id="alert-container" class="mt-2"></div>
                    <div class="row">
                        <div class="col-12" style="display: none;">
                            <p id="totalContainer" class="text-muted mb-3">Total: <span id="totalItemsCount2"></span></p>
                        </div>
                        @foreach ($paginateDetailedReports as $report)
                            <div class="col-lg-4 product-item artwork crypto-card 3d-style" data-id="{{ $report->id }}"
                                data-type="{{ $report->item->type }}" data-category-id="{{ $report->item->category_id }}"
                                data-title="{{ $report->item->title }}">
                                <div class="card explore-box card-animate">
                                    <div class="explore-place-bid-img">
                                        <div
                                            class="ribbon-box {{ $report->item->type === 'lost' ? 'lost-ribbon' : 'found-ribbon' }} left">
                                            <div
                                                class="ribbon-two {{ $report->item->type === 'lost' ? 'ribbon-two-danger' : 'ribbon-two-secondary' }}">
                                                <span>{{ ucfirst($report->item->type) }}</span>
                                            </div>
                                        </div>
                                        @php
                                            $imagePaths = json_decode($report->item->image_paths, true);
                                            $firstImage = $imagePaths[0] ?? null;
                                        @endphp

                                        @if ($firstImage)
                                            <img src="{{ asset($firstImage) }}" alt="{{ $report->item->title }}"
                                                class="card-img-top explore-img" />
                                        @else
                                            <img src="{{ asset('assets/images/image-error.png') }}" alt="error"
                                                class="card-img-top explore-img" />
                                        @endif
                                        <div class="bg-overlay"></div>
                                        @auth
                                            <div class="place-bid-btn">
                                                <a href="{{ route('user.itemDetail', $report->id) }}"
                                                    class="btn btn-success"><i
                                                        class="ri-information-line align-bottom me-2"></i> See Detail</a>
                                            </div>
                                        @endauth
                                    </div>
                                    <div class="card-body">
                                        <p class="fw-medium mb-0 float-end">{{ $report->item->date->format('d-m-Y') }}
                                        </p>
                                        <h5 class="mb-1">{{ $report->item->title }}</h5>
                                        <p class="text-muted mb-0">{{ $report->item->category->name }}</p>
                                    </div>
                                    <div class="card-footer border-top border-top-dashed">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 fs-14">
                                                <i class="ri-map-pin-2-fill text-danger align-bottom me-1"></i>
                                                {{ $report->item->location['desc'] }}
                                            </div>
                                            @if (Auth::check() && Auth::id() == $report->user_id && $report->isResolved != 'resolved')
                                                <span class="badge badge-soft-info fs-12">
                                                    <i class="ri-eye-line me-1 align-bottom"></i>Reported by you
                                                </span>
                                            @else
                                                <span class="badge badge-soft-success fs-12">
                                                    <i class="ri-eye-line me-1 align-bottom"></i>Resolved
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if ($detailedReports->isEmpty())
                            <div class="col-12 text-center mt-4">
                                <p class="alert alert-warning">No items available.</p>
                            </div>
                        @endif
                    </div>
                    @if ($paginateDetailedReports->isNotEmpty())
                        <!-- Pagination Links -->
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center mt-4">
                                {{ $paginateDetailedReports->fragment('items')->onEachSide(2)->links() }}
                            </div>
                        </div>
                    @endif

            </section>
            <!-- end items -->
            <!-- Feedback Reply Modal -->
            <div class="modal fade" id="feedbackReplyModal" tabindex="-1" aria-labelledby="feedbackReplyModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="feedbackReplyModalLabel">Feedback Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="feedbackContent">
                                <!-- Feedback and reply content will be populated here by JavaScript -->
                            </div>
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
            document.addEventListener('DOMContentLoaded', function() {

                //call notification
                fetchNotifications();
                setInterval(fetchNotifications, 60000);

                const closeFilterBtn = document.getElementById('closeFilterBtn');
                const collapseWithicon2 = new bootstrap.Collapse(document.getElementById('collapseWithicon2'), {
                    toggle: false
                });
                closeFilterBtn.addEventListener('click', function() {
                    collapseWithicon2.hide();
                    totalContainer.style.display = '';
                    searchInput.value = '';
                    itemTypeSelect.selectedIndex = 0;
                    itemCategorySelect.selectedIndex = 0;
                    filterButtons.forEach(btn => {
                        if (btn.getAttribute('data-filter') === 'all') {
                            btn.click();
                        }
                    });
                });
                const filterButtons = document.querySelectorAll('.filter-btns button[data-filter]');
                const items = document.querySelectorAll('.product-item');
                const alertContainer = document.getElementById(
                    'alert-container');
                const searchInput = document.getElementById('searchItem');
                const itemTypeSelect = document.getElementById('item-type');
                const itemCategorySelect = document.getElementById('item-category');
                const filterResultCount = document.getElementById('filter-result-count');
                const totalItemsCount = document.getElementById('totalItemsCount');
                const totalItemsCount2 = document.getElementById('totalItemsCount2');
                filterItems('all');
                filterButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const filter = this.getAttribute('data-filter');

                        filterButtons.forEach(btn => btn.classList.remove('active'));
                        this.classList.add('active');

                        if (filter === 'auto') {
                            fetchLatestReportAndFilter();
                        } else {
                            filterItems(filter);
                        }
                    });
                });

                function filterItems(filter) {
                    alertContainer.innerHTML = '';
                    totalContainer.style.display = '';
                    let itemsToShow = [];

                    items.forEach(item => {
                        if (filter === 'all' || item.getAttribute('data-type') === filter) {
                            item.style.display = '';
                            itemsToShow.push(item);
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    updateItemCount(itemsToShow.length);
                    if (itemsToShow.length <= 0) {
                        showAlert("No item found.");
                        const totalContainer = document.getElementById('totalContainer');
                        totalContainer.style.display = 'none';
                    }
                }

                searchInput.addEventListener('input', function() {
                    filterToggle();
                });

                itemTypeSelect.addEventListener('change', function() {
                    filterToggle();
                });

                itemCategorySelect.addEventListener('change', function() {
                    filterToggle();
                });

                function filterToggle() {
                    alertContainer.innerHTML = '';
                    totalContainer.style.display = '';
                    let itemsToShow = [];

                    items.forEach(item => {
                        item.style.display = 'none';
                        const itemType = item.getAttribute('data-type');
                        const itemCategory = item.getAttribute('data-category-id');
                        const itemName = item.getAttribute('data-title').toLowerCase();

                        const searchValue = searchInput.value.toLowerCase();
                        const selectedType = itemTypeSelect.value;
                        const selectedCategory = itemCategorySelect.value;

                        const matchesSearch = itemName.includes(searchValue);
                        const matchesType = selectedType === '' || itemType === selectedType;
                        const matchesCategory = selectedCategory === '' || itemCategory === selectedCategory;

                        if (matchesSearch && matchesType && matchesCategory) {
                            item.style.display = '';
                            itemsToShow.push(item);
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    updateFilterResultCount(itemsToShow.length);
                    if (itemsToShow.length <= 0) {
                        showAlert("No item found.");
                        const totalContainer = document.getElementById('totalContainer');
                        totalContainer.style.display = 'none';
                    }
                }

                function updateFilterResultCount(count) {
                    const result = filterResultCount.textContent = count;
                    totalItemsCount2.textContent = result;
                }

                function updateItemCount(count) {
                    totalItemsCount.textContent = count;
                    totalItemsCount2.textContent = count;
                }

                function fetchLatestReportAndFilter() {
                    alertContainer.innerHTML = '';
                    fetch('{{ route('user.latestReport') }}')
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const report = data.report.item;

                                if (!report || !report.category_id || !report.title) {
                                    console.error('Incomplete report data:', report);
                                    return;
                                }

                                const category = report.category_id;
                                const title = report.title.toLowerCase();
                                let itemsToShow = [];

                                items.forEach(item => {
                                    const itemCategory = item.getAttribute('data-category-id');
                                    const itemTitle = item.getAttribute('data-title');

                                    if (itemCategory == category || itemTitle.toLowerCase().includes(
                                            title)) {
                                        item.style.display = '';
                                        itemsToShow.push(item);
                                        updateItemCount(itemsToShow.length);
                                    } else {
                                        item.style.display = 'none';
                                    }
                                });
                            } else {
                                items.forEach(item => {
                                    item.style.display = 'none';
                                });
                                showAlert(data.message);
                                const totalContainer = document.getElementById('totalContainer');
                                totalContainer.style.display = 'none';
                            }
                        })
                        .catch(error => console.error('Error fetching latest report:', error));
                }

                function showAlert(message) {
                    const alertHTML = `
<div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
${message}
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
`;

                    alertContainer.innerHTML = alertHTML;
                }

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
                                href = '/home#hero';
                            } else if ((notification.type === 'App\\Notifications\\FeedbackToReview') || (
                                    notification.type === 'App\\Notifications\\FeedbackReply')) {
                                href = `{{ route('admin.displayFeedbacks') }}`;
                            } else if ((notification.type === 'App\\Notifications\\FeedbackReplied')) {
                                href = 'javascript:void(0)';
                            } else {
                                href = `{{ route('user.itemDetail', ['id' => ':report_id']) }}`
                                    .replace(':report_id', notification.data.report_id);
                            }

                            return `
<div class="text-reset notification-item d-block dropdown-item position-relative ${isRead}" 
                    data-notification-id="${notification.id}" data-notification-type="${notification.type}"
                        data-feedback-id="${notification.data.feedback_id}"    style="background-color: ${backgroundColor};">
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
    @endsection
