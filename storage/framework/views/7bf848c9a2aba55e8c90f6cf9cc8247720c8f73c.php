<nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
    <div class="container">
        <a class="navbar-brand mt-1" href="<?php echo e(URL::asset('/')); ?>">
            <img src="<?php echo e(URL::asset('assets/images/logo-dark-new.png')); ?>" class="card-logo card-logo-dark" alt="logo dark"
                height="20">
            <img src="<?php echo e(URL::asset('assets/images/logo-light-new.png')); ?>" class="card-logo card-logo-light"
                alt="logo light" height="20">
        </a>
        <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="mdi mdi-menu"></i>
        </button>
        <?php
            $homeUrl = url('/home#hero');
            $reportUrl = url('/home#reports');
            $itemsUrl = url('/home#items');
            $faqsUrl = url('/home#faqs');
            $contactUrl = url('/home#contact');
        ?>
        <div class="collapse navbar-collapse" id="navbarSupportedContent2">
            <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
                <li class="nav-item">
                    <a class="nav-link fs-14 active" href="<?php echo e($homeUrl); ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-14" href="<?php echo e($reportUrl); ?>">Report</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-14" href="<?php echo e($itemsUrl); ?>">Items</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-14" href="<?php echo e($faqsUrl); ?>">FAQs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-14" href="<?php echo e($contactUrl); ?>">Contact</a>
                </li>
            </ul>

            <?php if(auth()->guard()->check()): ?>
            <?php if(Auth::user()->hasRole('normal_user')): ?>
                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button"
                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class='bx bx-bell fs-22'></i>
                        <span
                            class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">0<span
                                class="visually-hidden">unread messages</span></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="px-2 pt-2">
                                <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true"
                                    id="notificationItemsTab" role="tablist">
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab"
                                            role="tab" aria-selected="true">
                                            All (<span class="notification-count2">0</span>)
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>

                        <div class="tab-content" id="notificationItemsTabContent" data-simplebar
                            data-simplebar-auto-hide="false" style="max-height: 300px; overflow-y: auto;">
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

            <!-- Guest/Anonymous user content -->
            <?php if(auth()->guard()->guest()): ?>
                <div class="">
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-link fw-medium text-decoration-none text-dark">Sign in</a>
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">Sign Up</a>
                </div>
            <?php endif; ?>

            <!-- Logged in normal_user content -->
            <?php if(auth()->guard()->check()): ?>
                <?php if(Auth::user()->hasRole('normal_user')): ?>
                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <button type="button" class="btn shadow-none" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-flex align-items-center">
                                <img class="rounded-circle header-profile-user"
                                    src="<?php if(Auth::user()->profile && Auth::user()->profile->avatar != ''): ?> <?php echo e(URL::asset('images/' . Auth::user()->profile->avatar)); ?>

                        <?php else: ?>
                            <?php echo e(URL::asset('images/default-avatar.jpg')); ?> <?php endif; ?>"
                                    alt="Header Avatar">
                                <span class="text-start ms-xl-2">
                                    <span
                                        class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo e(Auth::user()->name); ?></span>
                                    <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
                                        <?php if(Auth::user()->role === 'normal_user'): ?>
                                            User
                                        <?php else: ?>
                                            Admin
                                        <?php endif; ?>
                                    </span>
                                </span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header">Welcome <?php echo e(Auth::user()->name); ?>!</h6>
                            <a class="dropdown-item" href="<?php echo e(route('user.profile')); ?>"><i
                                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Profile</span></a>
                            <a class="dropdown-item" href="<?php echo e(route('user.myReports')); ?>"><i
                                    class="mdi mdi-briefcase-check text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">My Reports</span></a>
                            <a class="dropdown-item " href="javascript:void();"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="mdi mdi-logout-variant text-muted fs-16 align-middle me-1"></i> <span
                                    key="t-logout"><?php echo app('translator')->get('translation.logout'); ?></span></a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                <?php echo csrf_field(); ?>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>


        </div>

    </div>
</nav>
<!-- end navbar -->
<?php /**PATH C:\xampp\htdocs\FYP\resources\views/layouts-user/navbar.blade.php ENDPATH**/ ?>