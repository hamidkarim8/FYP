
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.dashboards'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/jsvectormap/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('assets/libs/swiper/swiper.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Dashboards
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Dashboard
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="row">
        <div class="col">

            <div class="h-100">
                <div class="row mb-3 pb-1">
                    <div class="col-12">
                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-16 mb-1">Good Morning, <?php echo e(Auth::user()->name); ?>!</h4>
                                <p class="text-muted mb-0">WELCOME TO APFOUND LOST AND FOUND SYSTEM.</p>
                            </div>
                        </div><!-- end card header -->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
                <div class="row">
                    <?php echo $__env->make('partials.card', [
                        'title' => 'Simple Reports',
                        'count' => $simpleReports->count(),
                        'badgeClass' =>
                            $simpleReportsPercentageChange > 0
                                ? 'text-success'
                                : ($simpleReportsPercentageChange < 0
                                    ? 'text-danger'
                                    : 'text-secondary'),
                        'iconClass' =>
                            $simpleReportsPercentageChange > 0
                                ? 'ri-arrow-up-line'
                                : ($simpleReportsPercentageChange < 0
                                    ? 'ri-arrow-down-line'
                                    : 'ri-equal-line'),
                        'percentageChange' => abs($simpleReportsPercentageChange),
                        'avatarIconClass' => 'ri-file-text-line',
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <?php echo $__env->make('partials.card', [
                        'title' => 'Detailed Reports',
                        'count' => $detailedReports->count(),
                        'badgeClass' =>
                            $detailedReportsPercentageChange > 0
                                ? 'text-success'
                                : ($detailedReportsPercentageChange < 0
                                    ? 'text-danger'
                                    : 'text-secondary'),
                        'iconClass' =>
                            $detailedReportsPercentageChange > 0
                                ? 'ri-arrow-up-line'
                                : ($detailedReportsPercentageChange < 0
                                    ? 'ri-arrow-down-line'
                                    : 'ri-equal-line'),
                        'percentageChange' => abs($detailedReportsPercentageChange),
                        'avatarIconClass' => 'ri-file-list-3-line',
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <?php echo $__env->make('partials.card', [
                        'title' => 'Resolved Reports',
                        'count' => $resolvedReports->count(),
                        'badgeClass' =>
                            $resolvedReportsPercentageChange > 0
                                ? 'text-success'
                                : ($resolvedReportsPercentageChange < 0
                                    ? 'text-danger'
                                    : 'text-secondary'),
                        'iconClass' =>
                            $resolvedReportsPercentageChange > 0
                                ? 'ri-arrow-up-line'
                                : ($resolvedReportsPercentageChange < 0
                                    ? 'ri-arrow-down-line'
                                    : 'ri-equal-line'),
                        'percentageChange' => abs($resolvedReportsPercentageChange),
                        'avatarIconClass' => 'ri-checkbox-circle-line',
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <?php echo $__env->make('partials.card', [
                        'title' => 'Users',
                        'count' => $normalUsers->count(),
                        'badgeClass' =>
                            $normalUsersPercentageChange > 0
                                ? 'text-success'
                                : ($normalUsersPercentageChange < 0
                                    ? 'text-danger'
                                    : 'text-secondary'),
                        'iconClass' =>
                            $normalUsersPercentageChange > 0
                                ? 'ri-arrow-up-line'
                                : ($normalUsersPercentageChange < 0
                                    ? 'ri-arrow-down-line'
                                    : 'ri-equal-line'),
                        'percentageChange' => abs($normalUsersPercentageChange),
                        'avatarIconClass' => 'ri-user-line',
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="col-xl-6">
                        <div class="card card-height-100">
                            <div class="card-header border-bottom-dashed align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Lost and Found Reports</h4>
                                <button id="downloadBtn" class="btn btn-sm btn-primary btn-animation waves-effect waves-light"
                                    style="position: absolute; top: auto; right: 20px; z-index: 10;">Generate
                                    Report</button>
                            </div><!-- end cardheader -->
                            <div class="card-body p-0">
                                <div data-simplebar style="max-height: 364px;" class="p-3">
                                    <canvas id="lineChart" class="chartjs-chart"
                                        data-colors='["--vz-danger-rgb, 0.2", "--vz-danger", "--vz-secondary-rgb, 0.2", "--vz-secondary"]'></canvas>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    <div class="col-xl-6">
                        <div class="card card-height-100">
                            <div class="card-header border-bottom-dashed align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Item's Category Reports</h4>
                                <button id="downloadBtn2" class="btn btn-sm btn-primary btn-animation waves-effect waves-light"
                                    style="position: absolute; top: auto; right: 20px; z-index: 10;">Generate
                                    Report</button>
                            </div><!-- end cardheader -->
                            <div class="card-body p-0">
                                <div data-simplebar style="max-height: 364px;" class="p-3">
                                    <div id="chart-pie" class="e-charts"></div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div> <!-- end row-->
            </div> <!-- end col -->
        </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <!-- apexcharts -->
    <script src="<?php echo e(URL::asset('/assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/libs/jsvectormap/jsvectormap.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/swiper/swiper.min.js')); ?>"></script>
    <!-- dashboard init -->
    <script src="<?php echo e(URL::asset('/assets/js/pages/dashboard-ecommerce.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="<?php echo e(URL::asset('assets/libs/chart.js/chart.js.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/echarts/echarts.min.js')); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function getChartColorsArray(chartId) {
                if (document.getElementById(chartId) !== null) {
                    var colors = document.getElementById(chartId).getAttribute("data-colors");
                    colors = JSON.parse(colors);
                    return colors.map(function(value) {
                        var newValue = value.replace(" ", "");

                        if (newValue.indexOf(",") === -1) {
                            var color = getComputedStyle(document.documentElement).getPropertyValue(
                                newValue);
                            if (color) return color;
                            else return newValue;;
                        } else {
                            var val = value.split(',');

                            if (val.length == 2) {
                                var rgbaColor = getComputedStyle(document.documentElement).getPropertyValue(
                                    val[0]);
                                rgbaColor = "rgba(" + rgbaColor + "," + val[1] + ")";
                                return rgbaColor;
                            } else {
                                return newValue;
                            }
                        }
                    });
                }
            }

            function getRandomColor() {
                const letters = '0123456789ABCDEF';
                let color = '#';
                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }

            function generateUniqueColors(numColors) {
                let colors = [];
                while (colors.length < numColors) {
                    let color = getRandomColor();
                    if (!colors.includes(color)) {
                        colors.push(color);
                    }
                }
                return colors;
            }

            let allReports = <?php echo json_encode($allReports, 15, 512) ?>;

            // Group reports by month
            function groupByMonth(reports) {
                let months = Array.from({
                    length: 12
                }, () => []);
                reports.forEach(report => {
                    let month = new Date(report.created_at).getMonth();
                    months[month].push(report);
                });
                return months;
            }

            Chart.defaults.borderColor = "rgba(133, 141, 152, 0.1)";
            Chart.defaults.color = "#858d98";

            let lostReports = allReports.filter(report => report.item.type === 'lost');
            let foundReports = allReports.filter(report => report.item.type === 'found');

            let lostReportsByMonth = groupByMonth(lostReports);
            let foundReportsByMonth = groupByMonth(foundReports);

            let lostReportData = lostReportsByMonth.map(monthReports => monthReports.length);
            let foundReportData = foundReportsByMonth.map(monthReports => monthReports.length);

            let labels = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
                "October", "November", "December"
            ];

            let lineChartColor = getChartColorsArray('lineChart');

            if (lineChartColor) {
                var islinechart = document.getElementById('lineChart');
                islinechart.setAttribute("width", islinechart.parentElement.offsetWidth);
                var lineChart = new Chart(islinechart, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: "Lost Reports",
                            fill: true,
                            lineTension: 0.5,
                            backgroundColor: lineChartColor[0],
                            borderColor: lineChartColor[1],
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: lineChartColor[1],
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: lineChartColor[1],
                            pointHoverBorderColor: "#fff",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: lostReportData
                        }, {
                            label: "Found Reports",
                            fill: true,
                            lineTension: 0.5,
                            backgroundColor: lineChartColor[2],
                            borderColor: lineChartColor[3],
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: lineChartColor[3],
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: lineChartColor[3],
                            pointHoverBorderColor: "#eef0f2",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: foundReportData
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                ticks: {
                                    font: {
                                        family: 'Poppins'
                                    }
                                }
                            },
                            y: {
                                ticks: {
                                    stepSize: 5,
                                    font: {
                                        family: 'Poppins'
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    font: {
                                        family: 'Poppins'
                                    }
                                }
                            }
                        }
                    }
                });
            }

            document.getElementById('downloadBtn').addEventListener('click', function() {
                var link = document.createElement('a');
                link.href = lineChart.toBase64Image();
                link.download = 'Lost and Found Reports.png';
                link.click();
            });

            // Group reports by item category
            function groupByCategory(reports) {
                let categoryCounts = {};
                reports.forEach(report => {
                    let category = report.item.category.name;
                    if (categoryCounts[category]) {
                        categoryCounts[category]++;
                    } else {
                        categoryCounts[category] = 1;
                    }
                });
                return categoryCounts;
            }

            let categoryCounts = groupByCategory(allReports);

            // Prepare data for the pie chart
            let pieChartData = Object.keys(categoryCounts).map(category => {
                return {
                    value: categoryCounts[category],
                    name: category
                };
            });

            // Generate unique colors for the pie chart
            let chartPieColors = generateUniqueColors(pieChartData.length);

            if (chartPieColors) {
                var chartDom = document.getElementById('chart-pie');
                var myChart = echarts.init(chartDom);
                var option = {
                    tooltip: {
                        trigger: 'item'
                    },
                    legend: {
                        orient: 'horizontal',
                        left: 'right',
                        type: 'scroll',
                        textStyle: {
                            color: '#858d98'
                        }
                    },
                    color: chartPieColors,
                    series: [{
                        name: 'Item Categories',
                        type: 'pie',
                        radius: '50%',
                        data: pieChartData,
                        emphasis: {
                            itemStyle: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }],
                    textStyle: {
                        fontFamily: 'Poppins, sans-serif'
                    }
                };
                option && myChart.setOption(option);
            }


            document.getElementById('downloadBtn2').addEventListener('click', function() {
                var link = document.createElement('a');
                link.href = myChart.getDataURL({
                    type: 'png',
                    pixelRatio: 2,
                    backgroundColor: '#fff'
                });
                link.download = "Item's Category Reports.png";
                link.click();
            });

            //call notification
            fetchNotifications();
            setInterval(fetchNotifications, 60000);

            function fetchNotifications() {
                axios.get('<?php echo e(route('notifications.fetch')); ?>')
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
                    <img src="<?php echo e(URL::asset('assets/images/svg/bell.svg')); ?>" class="img-fluid"
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
                            href = '#hero';
                        } else {
                            href = `<?php echo e(route('user.itemDetail', ['id' => ':report_id'])); ?>`
                                .replace(':report_id', notification.data.report_id);
                        }

                        return `
                <div class="text-reset notification-item d-block dropdown-item position-relative ${isRead}" 
                    data-notification-id="${notification.id}"
                    style="background-color: ${backgroundColor};">
                    <div class="d-flex align-items-center">
                        <div class="avatar-xs me-3">
                            <span class="avatar-title bg-soft-info text-info rounded-circle fs-16">
                                <i class="bx bx-badge-check"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <a href=${href} class="stretched-link">
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
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\FYP-TESTING\resources\views/admin/index.blade.php ENDPATH**/ ?>