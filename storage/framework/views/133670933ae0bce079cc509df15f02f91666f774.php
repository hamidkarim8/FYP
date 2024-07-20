<footer class="custom-footer bg-dark py-5 position-relative">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mt-4">
                <div>
                    <div>
                        <img src="<?php echo e(URL::asset('assets/images/logo-light-new.png')); ?>" alt="logo light" height="20">
                    </div>
                    <div class="mt-4 fs-13">
                        <p>Lost and Found System</p>
                        <p class="ff-secondary">A centralized platform for resolving lost and found items
                            efficiently. Connect directly with the person who found or lost an item, eliminating
                            waiting times and manual form filling.</p>
                    </div>
                </div>
            </div>
            <?php
                $homeUrl = url('/home#hero');
                $reportUrl = url('/home#reports');
                $itemsUrl = url('/home#items');
                $faqsUrl = url('/home#faqs');
                $contactUrl = url('/home#contact');
            ?>
            <div class="col-lg-7 ms-lg-auto">
                <div class="row">
                    <div class="col-sm-4 mt-4">
                        <h5 class="text-white mb-0">Menu</h5>
                        <div class="text-muted mt-3">
                            <ul class="list-unstyled ff-secondary footer-list fs-14">
                                <li><a href="<?php echo e($homeUrl); ?>">Home</a></li>
                                <li><a href="<?php echo e($reportUrl); ?>">Reports</a></li>
                                <li><a href="<?php echo e($itemsUrl); ?>">Items</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4 mt-4">
                        <h5 class="text-white mb-0">Support</h5>
                        <div class="text-muted mt-3">
                            <ul class="list-unstyled ff-secondary footer-list fs-14">
                                <li><a href="<?php echo e($faqsUrl); ?>">FAQ</a></li>
                                <li><a href="<?php echo e($contactUrl); ?>">Contact</a></li>
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
<?php /**PATH C:\xampp\htdocs\FYP\resources\views/layouts-user/footer.blade.php ENDPATH**/ ?>