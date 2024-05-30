<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.tour'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/shepherd.js/shepherd.js.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Advance UI
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Tour
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Shepherdjs</h4>
                </div><!-- end card header -->

                <div class="card-body">

                    <p class="text-muted mb-4">Use when you want to help users along getting accustomed to your user
                        interface or
                        Use when you want to notify your users of new or unfamiliar features.
                    </p>

                    <div>
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="text-center mt-4 mb-5">
                                    <div class="py-3 px-2 d-inline-block" id="logo-tour">
                                        <img src="<?php echo e(URL::asset('assets/images/logo-dark.png')); ?>" class="card-logo card-logo-dark" alt="logo"
                                            height="17">
                                        <img src="<?php echo e(URL::asset('assets/images/logo-light.png')); ?>" class="card-logo card-logo-light" alt="logo"
                                            height="17">
                                    </div>
                                    <h5 class="fs-16">Responsive Admin Dashboard Template</h5>
                                    <p class="text-muted">Vestibulum auctor tincidunt semper. Phasellus
                                        ut vulputate lacus. Suspendisse ultricies mi eros, sit amet
                                        tempor nulla varius sed dapibus in tellus.</p>
                                    <div class="hstack gap-2 justify-content-center">
                                        <button type="button" class="btn btn-primary btn-sm">View more</button>
                                        <button type="button" class="btn btn-success btn-sm">Email us</button>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row justify-content-center">
                            <div class="col-xxl-9 col-lg-10 col-sm-8">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="card border">
                                            <div class="card-body text-center">
                                                <div class="avatar-md mx-auto mb-4" id="register-tour">
                                                    <div
                                                        class="avatar-title bg-light rounded-circle text-primary fs-24 shadow">
                                                        <i class="ri-edit-box-line"></i>
                                                    </div>
                                                </div>
                                                <h5>Free register</h5>
                                                <p class="text-muted mb-0">Get your Free Velzon account now.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-lg-4">
                                        <div class="card border">
                                            <div class="card-body text-center">
                                                <div class="avatar-md mx-auto mb-4" id="login-tour">
                                                    <div
                                                        class="avatar-title bg-light rounded-circle text-primary fs-24 shadow">
                                                        <i class="ri-user-shared-line"></i>
                                                    </div>
                                                </div>
                                                <h5>Log in account</h5>
                                                <p class="text-muted mb-0">Sign in to continue to Velzon.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-lg-4">
                                        <div class="card border">
                                            <div class="card-body text-center">
                                                <div class="avatar-md mx-auto mb-4" id="getproduct-tour">
                                                    <div
                                                        class="avatar-title bg-light rounded-circle text-primary fs-24 shadow">
                                                        <i class="ri-file-download-line"></i>
                                                    </div>
                                                </div>
                                                <h5>Get Product</h5>
                                                <p class="text-muted mb-0">Sign in to continue to Velzon.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="text-center my-4">
                            <button class="btn btn-success" id="thankyou-tour">Thank you !</button>
                        </div>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('/assets/libs/shepherd.js/shepherd.js.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/pages/tour.init.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('assets/js/app.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\FYP-1\resources\views/advance-ui-tour.blade.php ENDPATH**/ ?>