<nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
    <div class="container">
        <a class="navbar-brand mt-1" href="<?php echo e(URL::asset('/')); ?>">
            <img src="<?php echo e(URL::asset('assets/images/logo-dark-new.png')); ?>" class="card-logo card-logo-dark"
                alt="logo dark" height="20">
            <img src="<?php echo e(URL::asset('assets/images/logo-light-new.png')); ?>" class="card-logo card-logo-light"
                alt="logo light" height="20">
        </a>
        <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <i class="mdi mdi-menu"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
                <li class="nav-item">
                    <a class="nav-link fs-14 active" href="home#hero">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-14" href="home#reports">Report</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-14" href="home#items">Items</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-14" href="home#faqs">FAQs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-14" href="home#contact">Contact</a>
                </li>
            </ul>

            <!-- Guest/Anonymous user content -->
            <?php if(auth()->guard()->guest()): ?>
                <div class="">
                    <a href="<?php echo e(route('login')); ?>"
                        class="btn btn-link fw-medium text-decoration-none text-dark">Sign in</a>
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
                                    <span
                                        class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text"><?php echo e(Auth::user()->role); ?></span>
                                </span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header">Welcome <?php echo e(Auth::user()->name); ?>!</h6>
                            <a class="dropdown-item" href="<?php echo e(route('user.profile')); ?>"><i
                                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Profile</span></a>
                            <a class="dropdown-item " href="javascript:void();"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="bx bx-power-off font-size-16 align-middle me-1"></i> <span
                                    key="t-logout"><?php echo app('translator')->get('translation.logout'); ?></span></a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST"
                                style="display: none;">
                                <?php echo csrf_field(); ?>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>


        </div>

    </div>
</nav>
<!-- end navbar --><?php /**PATH C:\xampp\htdocs\FYP-TESTING\resources\views/layouts-user/navbar.blade.php ENDPATH**/ ?>