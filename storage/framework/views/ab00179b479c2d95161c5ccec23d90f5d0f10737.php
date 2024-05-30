
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.starter'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/swiper/swiper.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row mt-4">
    <div class="col-lg-12">
        <div>
            <h5>Reported Items Timeline</h5>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <select id="itemFilter" class="form-select w-auto">
                    <option value="found">Found Items</option>
                    <option value="lost">Lost Items</option>
                </select>
            </div>
            <div id="timelineContainer">
                <div class="horizontal-timeline my-3">
                    <div class="swiper timelineSlider">
                        <div class="swiper-wrapper" id="timelineItems">
                            <!-- Timeline items will be injected here by JavaScript -->
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
                <!--end timeline-->
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const itemFilter = document.getElementById('itemFilter');
    const timelineItems = document.getElementById('timelineItems');

    function fetchItems(filter) {
        fetch(`/timeline?filter=${filter}`, {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Network response was not ok (${response.statusText})`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }

            timelineItems.innerHTML = data.items.map(item => `
                <div class="swiper-slide">
                    <div class="card pt-2 border-0 item-box text-center">
                        <div class="timeline-content p-3 rounded">
                            <div>
                                <p class="text-muted mb-1">${item.date}</p>
                                <h6 class="mb-0">${item.title || 'No title'}</h6>
                                <p class="mb-1">${item.description}</p>
                            </div>
                        </div>
                        <div class="time">
                            <span class="badge bg-success">${item.time}</span>
                        </div>
                    </div>
                </div>
            `).join('');

            // Reinitialize Swiper to update the new content
            if (typeof Swiper !== 'undefined') {
                new Swiper('.timelineSlider', {
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    slidesPerView: 4,
                    spaceBetween: 30,
                    breakpoints: {
                        320: {
                            slidesPerView: 1,
                        },
                        640: {
                            slidesPerView: 2,
                        },
                        992: {
                            slidesPerView: 3,
                        },
                        1200: {
                            slidesPerView: 4,
                        },
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error fetching items:', error);
            timelineItems.innerHTML = `<p>Error loading items: ${error.message}</p>`;
        });
    }

    itemFilter.addEventListener('change', function () {
        fetchItems(this.value);
    });

    // Initial fetch
    fetchItems(itemFilter.value);
});
</script>
<script src="<?php echo e(URL::asset('/assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('/assets/libs/jsvectormap/jsvectormap.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/libs/swiper/swiper.min.js')); ?>"></script>
<!-- dashboard init -->
<script src="<?php echo e(URL::asset('/assets/js/pages/dashboard-ecommerce.init.js')); ?>"></script>
<script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\FYP-1\resources\views/timeline.blade.php ENDPATH**/ ?>