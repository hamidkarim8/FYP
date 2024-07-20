<div class="col-xl-3 col-md-6">
    <div class="card card-animate">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="fw-medium text-muted mb-0">{{ $title }}</p>
                    <h2 class="mt-4 ff-secondary fw-semibold">
                        <span class="counter-value" data-target="{{ $count }}">0</span>
                    </h2>
                    <p class="mb-0 text-muted">
                        <span class="badge bg-light {{ $badgeClass }}">
                            <i class="{{ $iconClass }} align-middle"></i>
                            {{ $percentageChange }}%
                        </span> vs. previous week
                    </p>
                </div>
                <div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                            <i class="{{ $avatarIconClass }} text-info"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div><!-- end card body -->
    </div> <!-- end card-->
</div> <!-- end col-->