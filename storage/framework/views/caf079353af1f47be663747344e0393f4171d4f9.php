<div class="col-xl-3 col-md-6">
    <div class="card card-animate">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="fw-medium text-muted mb-0"><?php echo e($title); ?></p>
                    <h2 class="mt-4 ff-secondary fw-semibold">
                        <span class="counter-value" data-target="<?php echo e($count); ?>">0</span>
                    </h2>
                    <p class="mb-0 text-muted">
                        <span class="badge bg-light <?php echo e($badgeClass); ?>">
                            <i class="<?php echo e($iconClass); ?> align-middle"></i>
                            <?php echo e($percentageChange); ?>%
                        </span> vs. previous week
                    </p>
                </div>
                <div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                            <i class="<?php echo e($avatarIconClass); ?> text-info"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div><!-- end card body -->
    </div> <!-- end card-->
</div> <!-- end col--><?php /**PATH C:\xampp\htdocs\FYP-TESTING\resources\views/partials/card.blade.php ENDPATH**/ ?>