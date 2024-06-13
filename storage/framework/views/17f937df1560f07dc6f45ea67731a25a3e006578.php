
<?php $__env->startSection('title'); ?>
    Landing
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/jsvectormap/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="<?php echo e(URL::asset('assets/libs/swiper/swiper.min.css')); ?>" rel="stylesheet" type="text/css" />
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
                                                        <?php $__currentLoopData = $report->image_paths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="swiper-slide">
                                                                <div
                                                                    class="ribbon-two <?php echo e($report->type === 'lost' ? 'ribbon-two-danger' : 'ribbon-two-secondary'); ?>">
                                                                    <span><?php echo e(ucfirst($report->type)); ?></span>
                                                                </div>
                                                                <img src="<?php echo e(asset($image)); ?>" alt="<?php echo e($report->title); ?>"
                                                                    class="img-fluid" />
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                    <div class="swiper-button-next bg-white shadow"></div>
                                                    <div class="swiper-button-prev bg-white shadow"></div>
                                                    <div class="swiper-pagination"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hstack gap-2">
                                            <?php if($report->type === 'found'): ?>
                                                <button class="btn btn-primary w-100">Request Proof of Ownership</button>
                                            <?php else: ?>
                                                <button class="btn btn-primary w-100">Request to Contact</button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-8">
                                    <div>
                                        <h3><?php echo e($report->title); ?> | <?php echo e($report->category->name); ?></h3>
                                        <div class="hstack gap-3 flex-wrap mt-4">
                                            <div class="text-muted">Reporter: <span
                                                    class="text-body fw-medium"><?php echo e($report->fullname); ?></span></div>
                                            <div class="vr"></div>
                                            <div class="text-muted">Date <?php echo e($report->type); ?>: <span
                                                    class="text-body fw-medium"><?php echo e($report->reported_at->format('d-m-Y')); ?></span>
                                            </div>
                                            <div class="vr"></div>
                                            <div class="text-muted">Reported on: <span
                                                    class="text-body fw-medium"><?php echo e($report->created_at->format('d-m-Y')); ?></span>
                                            </div>
                                        </div>
                                        <!--end row-->
                                        <div class="mt-4 text-muted">
                                            <h5 class="fs-14">Description:</h5>
                                            <p><?php echo e($report->description); ?></p>
                                        </div>
                                        <div class="mt-4 text-muted">
                                            <h5 class="fs-14">Retrieval Info:</h5>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div class="text-muted">Phone Number: <span
                                                        class="text-body fw-medium"><?php echo e($report->phone_number); ?></span>
                                                </div>
                                                <div class="vr"></div>
                                                <div class="text-muted">Email: <span
                                                        class="text-body fw-medium"><?php echo e($report->email); ?></span>
                                                </div>
                                                <div class="vr"></div>
                                                <div class="text-muted">
                                                    Social Media:
                                                    <br>
                                                    <span class="text-body fw-medium">
                                                        <?php $__currentLoopData = $report->social_media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                                        <!-- Replace with your map embed code or component -->
                                                        <iframe class="embed-responsive-item"
                                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d211036.98332039418!2d<?php echo e($report->location['lng']); ?>!3d<?php echo e($report->location['lat']); ?>!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x<?php echo e($report->location['lng']); ?>%3A0x<?php echo e($report->location['lat']); ?>!2s<?php echo e(urlencode($report->location['desc'])); ?>!5e0!3m2!1sen!2sus!4v1623646230252!5m2!1sen!2sus"
                                                            allowfullscreen></iframe>
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
                                                                    <td><?php echo e($report->location['desc']); ?></td>
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
        <script></script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-without-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\FYP-TESTING\resources\views/item-detail.blade.php ENDPATH**/ ?>