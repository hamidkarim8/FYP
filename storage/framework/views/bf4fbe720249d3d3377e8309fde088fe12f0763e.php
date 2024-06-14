
<?php $__env->startSection('title'); ?>
    Landing
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/jsvectormap/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="<?php echo e(URL::asset('assets/libs/swiper/swiper.min.css')); ?>" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" href="<?php echo e(URL::asset('assets/libs/filepond/filepond.min.css')); ?>" type="text/css" />
    <link rel="stylesheet"
        href="<?php echo e(URL::asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-bs-spy="scroll" data-bs-target="#navbar-example">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- Begin page -->
        <div class="layout-wrapper landing">
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
                                <a class="nav-link fs-14 active" href="#hero">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fs-14" href="#reports">Report</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fs-14" href="#items">Items</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fs-14" href="#faqs">FAQs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fs-14" href="#contact">Contact</a>
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
            <!-- end navbar -->

            <!-- start hero section -->
            <section class="section pb-0 hero-section" id="hero">
                <div class="bg-overlay bg-overlay-pattern"></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-sm-10">
                            <div class="text-center pt-5">
                                <h1 class="display-6 fw-semibold mb-3 lh-base">The Best Way to Manage Your Lost and Found
                                    Items with <span class="text-success">ApFound</span></h1>
                                <p class="lead text-muted lh-base">Effortlessly Track and Recover Your Belongings</p>

                                <div class="d-flex gap-2 justify-content-center mt-4">
                                    <a href="#reports" class="btn btn-primary">Make report <i
                                            class="ri-arrow-right-line align-middle ms-1"></i></a>
                                    <a href="#items" class="btn btn-danger">See Items <i
                                            class="ri-eye-line align-middle ms-1"></i></a>
                                </div>
                            </div>

                            <div class="mt-2 pt-sm-5 mb-sm-n5 demo-carousel">
                                <div class="demo-img-patten-top d-none d-sm-block">
                                    <img src="<?php echo e(URL::asset('assets/images/landing/img-pattern.png')); ?>"
                                        class="d-block img-fluid" alt="...">
                                </div>
                                <div class="demo-img-patten-bottom d-none d-sm-block">
                                    <img src="<?php echo e(URL::asset('assets/images/landing/img-pattern.png')); ?>"
                                        class="d-block img-fluid" alt="...">
                                </div>
                                <div id="displayMap" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- Report Details Modal -->
                <div class="modal fade bs-example-modal-center" id="reportDetailsModal" tabindex="-1" role="dialog"
                    aria-labelledby="reportDetailsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div id="ribbonContainer"></div>

                            <div class="modal-header text-center">
                                <h5 class="modal-title w-100">Report Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body mt-4">
                                <div class="text-center mb-4">
                                    <h4 class="text-center text-muted"><span id="modalTitle"></span> | <span
                                            id="modalCategory"></span></h4>
                                </div>
                                
                                
                                
                                <div class="text-left mt-4">
                                    <div class="text-muted">Description : <span class="text-body fw-medium"><span
                                                id="modalDescription"></span></span></div>
                                    <div class="text-muted mt-4">Date (<span id="modalType"></span>) : <span
                                            class="text-body fw-medium"><span id="modalDate"></span></span></div>
                                </div>
                            </div>
                            <div class="modal-footer hstack gap-2 justify-content-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end container -->
                <div class="position-absolute start-0 end-0 bottom-0 hero-shape-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 1440 120">
                        <g mask="url(&quot;#SvgjsMask1003&quot;)" fill="none">
                            <path d="M 0,118 C 288,98.6 1152,40.4 1440,21L1440 140L0 140z">
                            </path>
                        </g>
                    </svg>
                </div>
                <!-- end shape -->
            </section>
            <!-- end hero section -->

            <!-- start collaboration section -->
            <div class="pt-5 mt-5">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="text-center mt-5">
                                <h5 class="fs-20">Final Year Project Collaboration</h5>

                                <!-- Swiper -->
                                <div class="swiper trusted-client-slider mt-sm-5 mt-4 mb-sm-5 mb-4" dir="ltr">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="client-images">
                                                <img src="<?php echo e(URL::asset('assets/images/collaboration/APU.png')); ?>"
                                                    alt="Asia Pacific University" class="mx-auto img-fluid d-block">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="client-images">
                                                <img src="<?php echo e(URL::asset('assets/images/collaboration/DMU.png')); ?>"
                                                    alt="De Montfort University" class="mx-auto img-fluid d-block">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="client-images">
                                                <img src="<?php echo e(URL::asset('assets/images/collaboration/SDG.jpg')); ?>"
                                                    alt="Sustainable Development Goals" class="mx-auto img-fluid d-block">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="client-images">
                                                <img src="<?php echo e(URL::asset('assets/images/collaboration/APU.png')); ?>"
                                                    alt="" class="mx-auto img-fluid d-block">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="client-images">
                                                <img src="<?php echo e(URL::asset('assets/images/collaboration/DMU.png')); ?>"
                                                    alt="" class="mx-auto img-fluid d-block">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="client-images">
                                                <img src="<?php echo e(URL::asset('assets/images/collaboration/SDG.jpg')); ?>"
                                                    alt="" class="mx-auto img-fluid d-block">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </div>
            <!-- end collaboration section -->


            
            <!-- start reports -->
            <section class="section py-5  bg-light" id="reports">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="text-center mb-5">
                                <h2 class="mb-3 fw-semibold lh-base">Report a Lost and Found Item</h2>
                                <p class="text-muted mb-4">Do you found any misplaced item somewhere? Or did you lost any
                                    item somewhere? Make a report now by pinning a location using simple report, or provide
                                    more information about the items in detailed report</p>
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->


                    <!-- Accordions Bordered -->
                    <div class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box accordion-secondary"
                        id="accordionBordered">
                        <div class="accordion-item shadow">
                            <h2 class="accordion-header" id="accordionborderedExample1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#accor_borderedExamplecollapse1" aria-expanded="true"
                                    aria-controls="accor_borderedExamplecollapse1">
                                    Simple Report
                                </button>
                            </h2>
                            <div id="accor_borderedExamplecollapse1" class="accordion-collapse collapse show"
                                aria-labelledby="accordionborderedExample1" data-bs-parent="#accordionBordered">
                                <div class="accordion-body">
                                    <div class="card card-height-100">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0">Report Through Map Location</h4>
                                        </div><!-- end card header -->
                                        <div class="card-body">
                                            <div data-simplebar style="max-height: 800px;" class="p-2">
                                                <div id="map" style="height: 400px;"></div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal fade" id="reportModal" tabindex="-1" role="dialog"
                            aria-labelledby="reportModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="reportModalLabel">Report Location</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="reportForm" novalidate>
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" id="latitude" name="latitude">
                                            <input type="hidden" id="longitude" name="longitude">
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" class="form-control" id="title" name="title"
                                                    placeholder="Enter title" required>
                                                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="text-danger"><?php echo e($message); ?></span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                            <div class="form-group mt-3">
                                                <label for="reportType">Type</label>
                                                <select class="form-control" id="reportType" name="type">
                                                    <option value="" disabled selected>Select Type</option>
                                                    <option value="found">Found</option>
                                                    <option value="lost">Lost</option>
                                                </select>
                                                <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="text-danger"><?php echo e($message); ?></span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                            <div class="form-group mt-3">
                                                <label for="reportCategory">Category</label>
                                                <select class="form-control" id="reportCategory" name="category_id">
                                                    <option value="" disabled selected>Select Category</option>
                                                </select>
                                                <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="text-danger"><?php echo e($message); ?></span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                            <div class="form-group mt-3">
                                                <label for="locationDescription">Location Description</label>
                                                <input type="text" class="form-control" id="locationDescription"
                                                    name="description" placeholder="Enter location description" required>
                                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="text-danger"><?php echo e($message); ?></span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                            <div class="form-group mt-3">
                                                <label for="reportDate">Date and Time</label>
                                                <input type="datetime-local" class="form-control" id="reportDate"
                                                    name="date" required>
                                                <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-feedback" role="alert"><?php echo e($message); ?></span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="submitReport">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item shadow">
                            <h2 class="accordion-header" id="accordionborderedExample2">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#accor_borderedExamplecollapse2" aria-expanded="true"
                                    aria-controls="accor_borderedExamplecollapse2">
                                    Detailed Report
                                </button>
                            </h2>
                            <div id="accor_borderedExamplecollapse2" class="accordion-collapse collapse show"
                                aria-labelledby="accordionborderedExample2" data-bs-parent="#accordionBordered">
                                <div class="accordion-body">
                                    <?php if(auth()->guard()->guest()): ?>
                                        <div class="alert alert-borderless alert-warning text-center mb-2 mx-2"
                                            role="alert">
                                            Please <span><a class="text-primary" href="<?php echo e(route('login')); ?>">Sign
                                                    in</a></span> to do a detailed report.
                                        </div>
                                    <?php endif; ?>
                                    <?php if(auth()->guard()->check()): ?>
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title mb-0">Report Form</h4>
                                            </div><!-- end card header -->
                                            <div class="card-body form-steps">
                                                <form action="<?php echo e(route('submit.detailed.report')); ?>" method="POST"
                                                    enctype="multipart/form-data">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('POST'); ?>
                                                    <div class="text-center pt-3 pb-4 mb-1">
                                                        <img src="<?php echo e(URL::asset('assets/images/logo-dark-new.png')); ?>"
                                                            alt="" height="17">
                                                    </div>
                                                    <div class="step-arrow-nav mb-4">

                                                        <ul class="nav nav-pills custom-nav nav-justified" role="tablist">
                                                            <li class="nav-item" role="presentation">
                                                                <button class="nav-link active" id="steparrow-gen-info-tab"
                                                                    data-bs-toggle="pill" data-bs-target="#steparrow-gen-info"
                                                                    type="button" role="tab"
                                                                    aria-controls="steparrow-gen-info"
                                                                    aria-selected="true">General</button>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <button class="nav-link" id="steparrow-description-info-tab"
                                                                    data-bs-toggle="pill"
                                                                    data-bs-target="#steparrow-description-info"
                                                                    type="button" role="tab"
                                                                    aria-controls="steparrow-description-info"
                                                                    aria-selected="false">Description</button>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <button class="nav-link" id="pills-experience-tab"
                                                                    data-bs-toggle="pill" data-bs-target="#pills-experience"
                                                                    type="button" role="tab"
                                                                    aria-controls="pills-experience"
                                                                    aria-selected="false">Finish</button>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="tab-content">
                                                        <div class="tab-pane fade show active" id="steparrow-gen-info"
                                                            role="tabpanel" aria-labelledby="steparrow-gen-info-tab">
                                                            <div>
                                                                <?php
                                                                    $socialMedia = json_decode(
                                                                        Auth::user()->profile->social_media,
                                                                        true,
                                                                    );
                                                                ?>
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="steparrow-gen-info-fullname-input">Full
                                                                        Name</label>
                                                                    <input type="text" class="form-control"
                                                                        id="steparrow-gen-info-fullname-input"
                                                                        placeholder="Enter Full Name" name="detailed-fullname"
                                                                        value="<?php if(Auth::user()->profile && Auth::user()->profile->fullname != ''): ?> <?php echo e(Auth::user()->profile->fullname); ?> <?php endif; ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="steparrow-gen-info-email-input">Email</label>
                                                                    <input type="text" class="form-control"
                                                                        id="steparrow-gen-info-email-input"
                                                                        placeholder="Enter Email" name="detailed-email"
                                                                        value="<?php if(Auth::user() && Auth::user()->email != ''): ?> <?php echo e(Auth::user()->email); ?> <?php endif; ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="steparrow-gen-info-phone-input">Phone
                                                                        Number</label>
                                                                    <input type="number" class="form-control"
                                                                        id="steparrow-gen-info-phone-input"
                                                                        placeholder="Enter Phone Number" name="detailed-phone"
                                                                        value="<?php echo e(Auth::user()->profile->phone_number); ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="steparrow-gen-info-socialmedia-input">Social
                                                                        Media</label>
                                                                    <div class="mb-3 d-flex">
                                                                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                                                                            <span
                                                                                class="avatar-title rounded-circle fs-16 text-light shadow">
                                                                                <i class="ri-instagram-fill"></i>
                                                                            </span>
                                                                        </div>
                                                                        <div class="input-group">
                                                                            <div class="input-group-text">@</div>
                                                                            <input type="text" class="form-control"
                                                                                id="steparrow-gen-info-ig-input"
                                                                                name="ig_username" placeholder="Username"
                                                                                value="<?php echo e($socialMedia['ig_username'] ?? ''); ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 d-flex">
                                                                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                                                                            <span
                                                                                class="avatar-title rounded-circle fs-16 shadow">
                                                                                <i class="ri-twitter-fill"></i>
                                                                            </span>
                                                                        </div>
                                                                        <div class="input-group">
                                                                            <div class="input-group-text">@</div>
                                                                            <input type="text" class="form-control"
                                                                                id="steparrow-gen-info-twt-input"
                                                                                name="twitter_username" placeholder="Username"
                                                                                value="<?php echo e($socialMedia['twitter_username'] ?? ''); ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 d-flex">
                                                                    <div class="avatar-xs d-block flex-shrink-0 me-3">
                                                                        <span class="avatar-title rounded-circle fs-16 shadow">
                                                                            <i class="bx bxl-tiktok"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div class="input-group">
                                                                        <div class="input-group-text">@</div>
                                                                        <input type="text" class="form-control"
                                                                            id="steparrow-gen-info-tt-input"
                                                                            name="tiktok_username" placeholder="Username"
                                                                            value="<?php echo e($socialMedia['tiktok_username'] ?? ''); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                                <button type="button"
                                                                    class="btn btn-success btn-label right ms-auto nexttab
                            nexttab"
                                                                    data-nexttab="steparrow-description-info-tab"><i
                                                                        class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go
                                                                    to more info</button>
                                                            </div>
                                                        </div>
                                                        <!-- end tab pane s -->

                                                        <div class="tab-pane fade" id="steparrow-description-info"
                                                            role="tabpanel" aria-labelledby="steparrow-description-info-tab">
                                                            <div>
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="description-title-input">Title</label>
                                                                    <input type="text" class="form-control"
                                                                        id="description-title-input" name="detailed-title"
                                                                        placeholder="Enter Title">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="reportType2">Type</label>
                                                                    <select class="form-control" id="reportType2"
                                                                        name="detailed-type">
                                                                        <option value="" selected disabled>Select Type
                                                                        </option>
                                                                        <option value="found">Found</option>
                                                                        <option value="lost">Lost</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="reportCategory2">Category</label>
                                                                    <select class="form-control" id="reportCategory2"
                                                                        name="detailed-category">
                                                                        <option value="" disabled selected>Select
                                                                            Category</option>
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="description-textarea">Description</label>
                                                                    <textarea class="form-control" id="description-textarea" placeholder="Enter Description" rows="3"
                                                                        name="detailed-description"></textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="formFile" class="form-label">Upload
                                                                        Images</label>
                                                                    <input type="file"
                                                                        class="filepond filepond-input-multiple" multiple
                                                                        name="detailed-images[]" data-allow-reorder="true"
                                                                        data-max-file-size="3MB" data-max-files="3">
                                                                    <p><span class="text-danger">*</span> Please upload only:
                                                                        jpeg, png, jpg, gif, Maximum number of files: 3</p>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="detailedReportMap">Location</label>
                                                                    <div id="detailedReportMap" style="height: 300px;">
                                                                    </div>
                                                                    <input type="hidden" id="latitude2"
                                                                        name="detailed-latitude">
                                                                    <input type="hidden" id="longitude2"
                                                                        name="detailed-longitude">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="location-description-input">Location
                                                                        Description</label>
                                                                    <textarea class="form-control" id="location-description-input" placeholder="Enter Location Description"
                                                                        name="detailed-loc-desc" rows="3"></textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="date-time-input">Date and
                                                                        Time</label>
                                                                    <input type="datetime-local" class="form-control"
                                                                        id="date-time-input" name="detailed-date">
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                                <button type="button"
                                                                    class="btn btn-light btn-label previestab"
                                                                    data-previous="steparrow-gen-info-tab">
                                                                    <i
                                                                        class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back
                                                                    to General
                                                                </button>
                                                                <button type="submit"
                                                                    class="btn btn-success btn-label right ms-auto nexttab"
                                                                    data-nexttab="pills-experience-tab">
                                                                    <i
                                                                        class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <!-- end tab pane -->

                                                        <div class="tab-pane fade" id="pills-experience" role="tabpanel">
                                                            <div class="text-center">

                                                                <div class="avatar-md mt-5 mb-4 mx-auto">
                                                                    <div
                                                                        class="avatar-title bg-light text-success display-4 rounded-circle">
                                                                        <i class="ri-checkbox-circle-fill"></i>
                                                                    </div>
                                                                </div>
                                                                <h5>Well Done !</h5>
                                                                <p class="text-muted">You have Successfully Reported an Item!
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <!-- end tab pane -->
                                                    </div>
                                                    <!-- end tab content -->
                                                </form>
                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end container -->
            </section>
            <!-- end reports -->
            


            <!-- start items -->
            <section class="section" id="items">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="text-center mb-5">
                                <h2 class="mb-3 fw-semibold lh-base">Explore Lost and Found Items</h2>
                                <p class="text-muted mb-4">Your lost item might be one of the list below! Do explore it and
                                    click on the card for more details</p>
                                <ul class="nav nav-pills filter-btns justify-content-center" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link fw-medium active" type="button" data-filter="all">All
                                            Items</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link fw-medium" type="button"
                                            data-filter="lost">Lost</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link fw-medium" type="button"
                                            data-filter="found">Found</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link fw-medium" type="button"
                                            data-filter="auto">Auto-matching</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link fw-medium" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseWithicon2" aria-expanded="false"
                                            aria-controls="collapseWithicon2">
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
                                        </div>
                                        <div class="row row-cols-xxl-5 row-cols-lg-3 row-cols-md-2 row-cols-1 mt-3 g-3">
                                            <div class="col">
                                                <h6 class="text-uppercase fs-12 mb-2">Search</h6>
                                                <input type="text" class="form-control" placeholder="Search item"
                                                    autocomplete="off" id="searchItem">
                                            </div>
                                            <div class="col">
                                                <h6 class="text-uppercase fs-12 mb-2">Select Category</h6>
                                                <select class="form-control" data-choices name="select-category"
                                                    data-choices-search-false id="select-category">
                                                    <option value="">Select Category</option>
                                                    <option value="Artwork">Artwork</option>
                                                    <option value="3d Style">3d Style</option>
                                                    <option value="Photography">Photography</option>
                                                    <option value="Collectibles">Collectibles</option>
                                                    <option value="Crypto Card">Crypto Card</option>
                                                    <option value="Games">Games</option>
                                                    <option value="Music">Music</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fs-14 mb-0">Result: 8745</p>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                    </div><!-- end row -->
                    <div class="row">
                        <?php $__currentLoopData = $detailedReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-4 product-item artwork crypto-card 3d-style">
                                <div class="card explore-box card-animate">
                                    <div class="bookmark-icon position-absolute top-0 end-0 p-2">
                                        <button type="button" class="btn btn-icon active" data-bs-toggle="button"
                                            aria-pressed="true"><i class="mdi mdi-cards-heart fs-16"></i></button>
                                    </div>
                                    <div class="explore-place-bid-img">
                                        <div
                                            class="ribbon-box <?php echo e($report->type === 'lost' ? 'lost-ribbon' : 'found-ribbon'); ?> left">
                                            <div
                                                class="ribbon-two <?php echo e($report->type === 'lost' ? 'ribbon-two-danger' : 'ribbon-two-secondary'); ?>">
                                                <span><?php echo e(ucfirst($report->type)); ?></span>
                                            </div>
                                        </div>
                                        <?php
                                            // Decode the JSON-encoded image_paths attribute
                                            $imagePaths = json_decode($report->image_paths, true);
                                            // Get the first image from the decoded array
                                            $firstImage = $imagePaths[0] ?? null;
                                        ?>

                                        <?php if($firstImage): ?>
                                            <img src="<?php echo e(asset($firstImage)); ?>" alt="<?php echo e($report->title); ?>"
                                                class="card-img-top explore-img" />
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('assets/images/image-error.png')); ?>" alt="error"
                                                class="card-img-top explore-img" />
                                        <?php endif; ?>
                                        <div class="bg-overlay"></div>
                                        <?php if(auth()->guard()->check()): ?>
                                            <div class="place-bid-btn">
                                                <a href="<?php echo e(route('user.itemDetail', $report->id)); ?>"
                                                    class="btn btn-success"><i
                                                        class="ri-information-line align-bottom me-2"></i> See Detail</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <p class="fw-medium mb-0 float-end"><?php echo e($report->reported_at->format('d-m-Y')); ?>

                                        </p>
                                        <h5 class="mb-1"><?php echo e($report->title); ?></h5>
                                        <p class="text-muted mb-0"><?php echo e($report->category->name); ?></p>
                                    </div>
                                    <div class="card-footer border-top border-top-dashed">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 fs-14">
                                                <i class="ri-map-pin-2-fill text-danger align-bottom me-1"></i>
                                                <?php echo e($report->location['desc']); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($detailedReports->isEmpty()): ?>
                            <div class="col-12 text-center mt-4">
                                <p class="alert alert-warning">No items available.</p>
                            </div>
                        <?php endif; ?>
                    </div>
            </section>
            <!-- end items -->

            <!-- start cta -->
            <section class="py-5 bg-primary position-relative">
                <div class="bg-overlay bg-overlay-pattern opacity-50"></div>
                <div class="container">
                    <div class="row align-items-center gy-4">
                        <div class="col-sm">
                            <div>
                                <h4 class="text-white mb-0 fw-semibold">Register and become one of us the life peacer</h4>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-sm-auto">
                            <div>
                                <a href="<?php echo e(route('register')); ?>" class="btn bg-gradient btn-success"><i
                                        class="ri-user-add-fill align-middle me-1"></i> Register</a>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </section>
            <!-- end cta -->

            <!-- start faqs -->
            <section class="section bg-light" id="faqs">
                <div class="bg-overlay bg-overlay-pattern"></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="text-center mb-5">
                                <h3 class="mb-3 fw-semibold">Frequently Asked Questions</h3>
                                <p class="text-muted mb-4 ff-secondary">If you can't find the answer to your question in
                                    our FAQ, you can always contact us or email us. We will answer you shortly!</p>
                                <div class="">
                                    <button type="button" class="btn btn-primary btn-label rounded-pill">
                                        <i class="ri-mail-line label-icon align-middle rounded-pill fs-16 me-2"></i> Email
                                        Us
                                    </button>
                                    <button type="button" class="btn btn-info btn-label rounded-pill">
                                        <i class="ri-twitter-line label-icon align-middle rounded-pill fs-16 me-2"></i>
                                        Send Us Tweet
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row g-lg-5 g-4">
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0 me-1">
                                    <i class="ri-question-line fs-24 align-middle text-success me-1"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fw-semibold">General Questions</h5>
                                </div>
                            </div>
                            <div class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box"
                                id="genques-accordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="genques-headingOne">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#genques-collapseOne"
                                            aria-expanded="false" aria-controls="genques-collapseOne">
                                            What is the purpose of the lost and found system?
                                        </button>
                                    </h2>
                                    <div id="genques-collapseOne" class="accordion-collapse collapse"
                                        aria-labelledby="genques-headingOne" data-bs-parent="#genques-accordion">
                                        <div class="accordion-body ff-secondary">
                                            The lost and found system helps users report lost items and find items that
                                            others have found. It aims to streamline the process of recovering lost
                                            belongings.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="genques-headingTwo">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#genques-collapseTwo"
                                            aria-expanded="false" aria-controls="genques-collapseTwo">
                                            How do I report a lost item?
                                        </button>
                                    </h2>
                                    <div id="genques-collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="genques-headingTwo" data-bs-parent="#genques-accordion">
                                        <div class="accordion-body ff-secondary">
                                            To report a lost item, you need to fill out the "Report Lost Item" form on our
                                            website, providing detailed information about the item and the location where it
                                            was lost.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="genques-headingThree">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#genques-collapseThree"
                                            aria-expanded="false" aria-controls="genques-collapseThree">
                                            How do I report a found item?
                                        </button>
                                    </h2>
                                    <div id="genques-collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="genques-headingThree" data-bs-parent="#genques-accordion">
                                        <div class="accordion-body ff-secondary">
                                            To report a found item, you need to fill out the "Report Found Item" form on our
                                            website, providing detailed information about the item and the location where it
                                            was found.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="genques-headingFour">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#genques-collapseFour"
                                            aria-expanded="false" aria-controls="genques-collapseFour">
                                            How do I search for my lost item?
                                        </button>
                                    </h2>
                                    <div id="genques-collapseFour" class="accordion-collapse collapse"
                                        aria-labelledby="genques-headingFour" data-bs-parent="#genques-accordion">
                                        <div class="accordion-body ff-secondary">
                                            You can search for your lost item by browsing the "Found Items" section on our
                                            website, using keywords or filtering by categories.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end accordion-->
                        </div>
                        <!-- end col -->
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0 me-1">
                                    <i class="ri-shield-keyhole-line fs-24 align-middle text-success me-1"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fw-semibold">Privacy & Security</h5>
                                </div>
                            </div>

                            <div class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box"
                                id="privacy-accordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="privacy-headingOne">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#privacy-collapseOne"
                                            aria-expanded="false" aria-controls="privacy-collapseOne">
                                            How is my personal information protected?
                                        </button>
                                    </h2>
                                    <div id="privacy-collapseOne" class="accordion-collapse collapse"
                                        aria-labelledby="privacy-headingOne" data-bs-parent="#privacy-accordion">
                                        <div class="accordion-body ff-secondary">
                                            Your personal information is protected through encryption and secure servers. We
                                            adhere to strict privacy policies to ensure your data is safe.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="privacy-headingTwo">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#privacy-collapseTwo"
                                            aria-expanded="false" aria-controls="privacy-collapseTwo">
                                            Who can see the details of the lost and found items?
                                        </button>
                                    </h2>
                                    <div id="privacy-collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="privacy-headingTwo" data-bs-parent="#privacy-accordion">
                                        <div class="accordion-body ff-secondary">
                                            Only registered users can see the details of the lost and found items. We ensure
                                            that the information is not accessible to unauthorized individuals.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="privacy-headingThree">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#privacy-collapseThree"
                                            aria-expanded="false" aria-controls="privacy-collapseThree">
                                            What should I do if I find my lost item?
                                        </button>
                                    </h2>
                                    <div id="privacy-collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="privacy-headingThree" data-bs-parent="#privacy-accordion">
                                        <div class="accordion-body ff-secondary">
                                            If you find your lost item, please update the status on our website by marking
                                            it as found in your account settings. This will help us keep the database
                                            up-to-date.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="privacy-headingFour">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#privacy-collapseFour"
                                            aria-expanded="false" aria-controls="privacy-collapseFour">
                                            How do I contact someone who found my item?
                                        </button>
                                    </h2>
                                    <div id="privacy-collapseFour" class="accordion-collapse collapse"
                                        aria-labelledby="privacy-headingFour" data-bs-parent="#privacy-accordion">
                                        <div class="accordion-body ff-secondary">
                                            You can contact someone who found your item through the messaging system on our
                                            website. We do not share personal contact information to ensure privacy.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end accordion-->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </section>
            <!-- end faqs -->


            <!-- start review -->
            <section class="section bg-primary" id="reviews">
                <div class="bg-overlay bg-overlay-pattern"></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="text-center">
                                <div>
                                    <i class="ri-double-quotes-l text-success display-3"></i>
                                </div>
                                <h4 class="text-white mb-5">Satisfied Users</h4>

                                <!-- Swiper -->
                                <div class="swiper client-review-swiper rounded" dir="ltr">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="row justify-content-center">
                                                <div class="col-10">
                                                    <div class="text-white-50">
                                                        <p class="fs-20 ff-secondary mb-4">" I am givng 5 stars. Theme is
                                                            great and everyone one stuff everything in theme. Future request
                                                            should not affect current
                                                            state of theme. "</p>

                                                        <div>
                                                            <h5 class="text-white">gregoriusus</h5>
                                                            <p>- Skote User</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end slide -->
                                        <div class="swiper-slide">
                                            <div class="row justify-content-center">
                                                <div class="col-10">
                                                    <div class="text-white-50">
                                                        <p class="fs-20 ff-secondary mb-4">" Awesome support. Had few
                                                            issues while setting up because of my device, the support team
                                                            helped me fix them up in a day.
                                                            Everything looks clean and good. Highly recommended! "</p>

                                                        <div>
                                                            <h5 class="text-white">GeekyGreenOwl</h5>
                                                            <p>- Skote User</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end slide -->
                                        <div class="swiper-slide">
                                            <div class="row justify-content-center">
                                                <div class="col-10">
                                                    <div class="text-white-50">
                                                        <p class="fs-20 ff-secondary mb-4">" Amazing template, Redux store
                                                            and components is nicely designed.
                                                            It's a great start point for an admin based project. Clean Code
                                                            and good documentation. Template is
                                                            completely in React and absolutely no usage of jQuery "</p>

                                                        <div>
                                                            <h5 class="text-white">sreeks456</h5>
                                                            <p>- Veltrix User</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end slide -->
                                    </div>
                                    <div class="swiper-button-next bg-white rounded-circle"></div>
                                    <div class="swiper-button-prev bg-white rounded-circle"></div>
                                    <div class="swiper-pagination position-relative mt-2"></div>
                                </div>
                                <!-- end slider -->
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </section>
            <!-- end review -->



            <!-- start Work Process -->
            <section class="section">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="text-center mb-5">
                                <h3 class="mb-3 fw-semibold">Our Work Process</h3>
                                <p class="text-muted mb-4 ff-secondary">In an ideal world this website wouldn’t exist, a
                                    client would
                                    acknowledge the importance of having web copy before the Proin vitae ipsum vel ex
                                    finibus semper design starts.</p>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row text-center">
                        <div class="col-lg-4">
                            <div class="process-card mt-4">
                                <div class="process-arrow-img d-none d-lg-block">
                                    <img src="<?php echo e(URL::asset('assets/images/landing/process-arrow-img.png')); ?>"
                                        alt="" class="img-fluid">
                                </div>
                                <div class="avatar-sm icon-effect mx-auto mb-4">
                                    <div class="avatar-title bg-transparent text-success rounded-circle h1">
                                        <i class="ri-quill-pen-line"></i>
                                    </div>
                                </div>

                                <h5>Tell us what you need</h5>
                                <p class="text-muted ff-secondary">The profession and the employer and your desire to make
                                    your mark.</p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-lg-4">
                            <div class="process-card mt-4">
                                <div class="process-arrow-img d-none d-lg-block">
                                    <img src="<?php echo e(URL::asset('assets/images/landing/process-arrow-img.png')); ?>"
                                        alt="" class="img-fluid">
                                </div>
                                <div class="avatar-sm icon-effect mx-auto mb-4">
                                    <div class="avatar-title bg-transparent text-success rounded-circle h1">
                                        <i class="ri-user-follow-line"></i>
                                    </div>
                                </div>

                                <h5>Get free quotes</h5>
                                <p class="text-muted ff-secondary">The most important aspect of beauty was, therefore, an
                                    inherent part.</p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-lg-4">
                            <div class="process-card mt-4">
                                <div class="avatar-sm icon-effect mx-auto mb-4">
                                    <div class="avatar-title bg-transparent text-success rounded-circle h1">
                                        <i class="ri-book-mark-line"></i>
                                    </div>
                                </div>

                                <h5>Deliver high quality product</h5>
                                <p class="text-muted ff-secondary">We quickly learn to fear and thus automatically avoid
                                    potentially.</p>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </section>
            <!-- end Work Process -->


            <!-- start counter -->
            <section class="py-5 position-relative bg-light">
                <div class="container">
                    <div class="row text-center gy-4">
                        <div class="col-lg-3 col-6">
                            <div>
                                <h2 class="mb-2"><span class="counter-value" data-target="100">0</span></h2>
                                <div class="text-muted">Reports</div>
                            </div>
                        </div>
                        <!-- end col -->

                        <div class="col-lg-3 col-6">
                            <div>
                                <h2 class="mb-2"><span class="counter-value" data-target="50">0</span></h2>
                                <div class="text-muted">Reports Resolved</div>
                            </div>
                        </div>
                        <!-- end col -->

                        <div class="col-lg-3 col-6">
                            <div>
                                <h2 class="mb-2"><span class="counter-value" data-target="50">0</span></h2>
                                <div class="text-muted">Users</div>
                            </div>
                        </div>
                        <!-- end col -->

                        <div class="col-lg-3 col-6">
                            <div>
                                <h2 class="mb-2"><span class="counter-value" data-target="40">0</span></h2>
                                <div class="text-muted">Satisfied Users</div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </section>
            <!-- end counter -->


            <!-- start contact -->
            <section class="section" id="contact">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="text-center mb-5">
                                <h3 class="mb-3 fw-semibold">Get In Touch</h3>
                                <p class="text-muted mb-4 ff-secondary">We thrive when coming up with innovative ideas but
                                    also
                                    understand that a smart concept should be supported with faucibus sapien odio measurable
                                    results.</p>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row gy-4">
                        <div class="col-lg-4">
                            <div>
                                <div class="mt-4">
                                    <h5 class="fs-13 text-muted text-uppercase">Office Address 1:</h5>
                                    <div class="ff-secondary fw-semibold">Asia Pacific University, <br />Technology Park
                                        Malaysia, <br />Bukit Jalil, Kuala Lumpur</div>
                                </div>
                                <div class="mt-4">
                                    <h5 class="fs-13 text-muted text-uppercase">Working Hours:</h5>
                                    <div class="ff-secondary fw-semibold">9:00am to 5:00pm</div>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-lg-8">
                            <div>
                                <form>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-4">
                                                <label for="name" class="form-label fs-13">Name</label>
                                                <input name="name" id="name" type="text"
                                                    class="form-control bg-light border-light" placeholder="Your name"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-4">
                                                <label for="email" class="form-label fs-13">Email</label>
                                                <input name="email" id="email" type="email"
                                                    class="form-control bg-light border-light" placeholder="Your email"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-4">
                                                <label for="subject" class="form-label fs-13">Subject</label>
                                                <input type="text" class="form-control bg-light border-light"
                                                    id="subject" name="subject" placeholder="Your Subject.." required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="comments" class="form-label fs-13">Message</label>
                                                <textarea name="comments" id="comments" rows="3" class="form-control bg-light border-light"
                                                    placeholder="Your message..." required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 text-end">
                                            <input type="submit" id="submit" name="send"
                                                class="submitBnt btn btn-primary" value="Send Message">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </section>
            <!-- end contact -->

            <!-- Start footer -->
            <footer class="custom-footer bg-dark py-5 position-relative">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 mt-4">
                            <div>
                                <div>
                                    <img src="<?php echo e(URL::asset('assets/images/logo-light-new.png')); ?>" alt="logo light"
                                        height="20">
                                </div>
                                <div class="mt-4 fs-13">
                                    <p>Lost and Found System</p>
                                    <p class="ff-secondary">A centralized platform where lost or found items can be easily
                                        resolved. No waiting times at counter, no hassle in filling up forms manually or
                                        confront admin's verification. All process could get done by connecting with person
                                        whom found or lost directly</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7 ms-lg-auto">
                            <div class="row">
                                <div class="col-sm-4 mt-4">
                                    <h5 class="text-white mb-0">Menu</h5>
                                    <div class="text-muted mt-3">
                                        <ul class="list-unstyled ff-secondary footer-list fs-14">
                                            <li><a href="#hero">Home</a></li>
                                            <li><a href="#reports">Reports</a></li>
                                            <li><a href="#items">Items</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-4">
                                    <h5 class="text-white mb-0">Support</h5>
                                    <div class="text-muted mt-3">
                                        <ul class="list-unstyled ff-secondary footer-list fs-14">
                                            <li><a href="#faqs">FAQ</a></li>
                                            <li><a href="#contact">Contact</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-4">
                                    <h5 class="text-white mb-0">Access</h5>
                                    <div class="text-muted mt-3">
                                        <ul class="list-unstyled ff-secondary footer-list fs-14">
                                            <li><a href="<?php echo e(route('register')); ?>">Sign Up</a></li>
                                            <li><a href="<?php echo e(route('login')); ?>">Sign In</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row text-center text-sm-start align-items-center mt-5">
                        <div class="col-sm-6">

                            <div>
                                <p class="copy-rights mb-0">
                                    <script>
                                        document.write(new Date().getFullYear())
                                    </script> © ApFound - Final Year Project
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end mt-3 mt-sm-0">
                                <ul class="list-inline mb-0 footer-social-link">
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="avatar-xs d-block">
                                            <div class="avatar-title rounded-circle">
                                                <i class="ri-facebook-fill"></i>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="avatar-xs d-block">
                                            <div class="avatar-title rounded-circle">
                                                <i class="ri-github-fill"></i>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="avatar-xs d-block">
                                            <div class="avatar-title rounded-circle">
                                                <i class="ri-linkedin-fill"></i>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="avatar-xs d-block">
                                            <div class="avatar-title rounded-circle">
                                                <i class="ri-google-fill"></i>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end footer -->

        </div>
        <!-- end layout wrapper -->
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <script src="<?php echo e(URL::asset('/assets/libs/swiper/swiper.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('/assets/js/pages/landing.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('/assets/libs/jsvectormap/jsvectormap.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/filepond/filepond.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js')); ?>">
        </script>
        <script
            src="<?php echo e(URL::asset('assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js')); ?>">
        </script>
        <script
            src="<?php echo e(URL::asset('assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js')); ?>">
        </script>
        <script src="<?php echo e(URL::asset('assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/js/pages/form-file-upload.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/js/pages/form-wizard.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/js/pages/apps-nft-explore.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/js/pages/modal.init.js')); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script>
            // Initialize the map
            var detailedReportMap;

            function initializeMap() {
                detailedReportMap = L.map('detailedReportMap').setView([3.05603, 101.70022], 17);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(detailedReportMap);
            }

            $(document).ready(function() {


                // Initialize the map
                var displayMap = L.map('displayMap').setView([3.05603, 101.70022], 17);

                // Add a tile layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(displayMap);


                // Initialize the map
                var map = L.map('map').setView([3.05603, 101.70022], 17);

                // Add a tile layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Function to handle map click event
                function handleMapClick(e) {
                    // Open modal
                    $('#reportModal').modal('show');

                    // Populate form fields with location data
                    $('#latitude').val(e.latlng.lat);
                    $('#longitude').val(e.latlng.lng);
                }


                $('button[data-bs-toggle="pill"]').on('shown.bs.tab', function(e) {
                    var target = $(e.target).attr("data-bs-target");
                    if (target == '#steparrow-description-info') {
                        if (!detailedReportMap) {
                            setTimeout(function() {
                                initializeMap();
                                // Function to handle map click event
                                var marker;
                                detailedReportMap.on('click', function(e) {
                                    if (marker) {
                                        detailedReportMap.removeLayer(marker);
                                    }

                                    // Populate form fields with location data
                                    $('#latitude2').val(e.latlng.lat);
                                    $('#longitude2').val(e.latlng.lng);

                                    // Add new marker for the clicked location
                                    marker = L.circleMarker([e.latlng.lat, e.latlng.lng], {
                                        color: 'red',
                                        radius: 10
                                    }).addTo(detailedReportMap);
                                    console.log([e.latlng.lat, e.latlng.lng]);
                                });


                            }, 100);
                        } else {
                            setTimeout(function() {
                                detailedReportMap.invalidateSize();
                            }, 100);
                        }
                    }
                });


                // Fetch categories and populate the dropdown
                axios.get('/categories')
                    .then(function(response) {
                        var categories = response.data;
                        var categorySelect = $('#reportCategory');
                        categories.forEach(function(category) {
                            categorySelect.append(new Option(category.name, category.id));
                        });
                        var categorySelect2 = $('#reportCategory2');
                        categories.forEach(function(category) {
                            categorySelect2.append(new Option(category.name, category.id));
                        });
                    })
                    .catch(function(error) {
                        console.error('Error fetching categories:', error);
                    });


                // Function to add markers
                function addMarker(lat, lng, report) {
                    var markerColor = report.type === 'found' ? 'blue' : 'red';
                    var marker = L.circleMarker([lat, lng], {
                        color: markerColor,
                        radius: 10
                    }).addTo(displayMap);

                    marker.on('click', function() {
                        // Populate modal with report details
                        $('#modalTitle').text(report.title);
                        $('#modalType').text(report.type);
                        var categoryName = typeof report.category === 'object' ? report.category.name : report
                            .category;
                        $('#modalCategory').text(categoryName);
                        $('#modalDescription').text(report.location.desc);
                        var dateDisplay = report.date ? report.date : new Date(report.reported_at)
                            .toLocaleDateString('en-GB');
                        $('#modalDate').text(dateDisplay);

                        // Add Ribbon based on report type
                        var ribbonHTML = '';
                        if (report.type === 'found') {
                            ribbonHTML =
                                '<div class="ribbon-box found-ribbon left"><div class="ribbon-two ribbon-two-secondary"><span>Found Item</span></div></div>';
                        } else if (report.type === 'lost') {
                            ribbonHTML =
                                '<div class="ribbon-box lost-ribbon left"><div class="ribbon-two ribbon-two-danger"><span>Lost Item</span></div></div>';
                        }

                        $('#ribbonContainer').html(ribbonHTML);

                        // Show modal
                        $('#reportDetailsModal').modal('show');
                    });
                }

                //Display simple report
                axios.post('/simple-report-display')
                    .then(function(response) {
                        var reports = response.data;
                        reports.forEach(function(report) {
                            addMarker(report.location.lat, report.location.lng, report);
                        });
                    })
                    .catch(function(error) {
                        console.error('Error fetching reports:', error);
                    });

                //Display Detailed Report
                var detailedReports = <?php echo json_encode($detailedReports, 15, 512) ?>;

                detailedReports.forEach(function(report) {
                    var reportLat = report.location.lat;
                    var reportLng = report.location.lng;
                    var reportType = report.type;
                    var reportTitle = report.title;
                    var reportDesc = report.location.desc;

                    detailedReports.forEach(function(report) {
                        addMarker(reportLat, reportLng, report);
                    });
                });


                //Simple report form
                // Add click event listener to map
                map.on('click', handleMapClick);
                $('#submitReport').on('click', function() {
                    var formData = $('#reportForm').serialize();

                    axios.post('/simple-report', formData)
                        .then(function(response) {
                            console.log(response.data);
                            $('#reportModal').modal('hide');
                            $('#reportForm')[0].reset();
                            Toastify({
                                text: 'You have successfully submitted a report. Thank you.',
                                duration: 3000,
                                backgroundColor: '#28a745',
                                gravity: 'top',
                                position: 'center',
                                close: true
                            }).showToast();
                        })
                        .catch(function(error) {
                            if (error.response && error.response.data.errors) {
                                // Extract validation errors
                                var errors = error.response.data.errors;
                                var errorMessages = [];
                                for (var key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        errorMessages.push(errors[key][0]);
                                    }
                                }

                                Toastify({
                                    text: errorMessages.join(' '),
                                    duration: 5000,
                                    backgroundColor: '#dc3545',
                                    gravity: 'top',
                                    position: 'center',
                                    close: true
                                }).showToast();
                            } else {
                                Toastify({
                                    text: 'Something went wrong. Please try again.',
                                    duration: 3000,
                                    backgroundColor: '#dc3545',
                                    gravity: 'top',
                                    position: 'center',
                                    close: true
                                }).showToast();
                            }
                            console.error(error);
                        });
                });
            });
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-without-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\FYP-TESTING\resources\views/index.blade.php ENDPATH**/ ?>