<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="<?php echo e(route('admin.index')); ?>" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('assets/images/logo-sm.png')); ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('assets/images/logo-dark-new.png')); ?>" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="<?php echo e(route('admin.index')); ?>" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('assets/images/logo-sm.png')); ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('assets/images/logo-light-new.png')); ?>" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span><?php echo app('translator')->get('translation.menu'); ?></span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('admin.index')); ?>">
                        <i class="mdi mdi-speedometer"></i> <span><?php echo app('translator')->get('translation.dashboards'); ?></span>
                    </a>
                </li>
                <li class="menu-title"><span>Management</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('admin.displayReports')); ?>">
                        <i class="mdi mdi-file-document-outline"></i> <span>Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('admin.displayAdmins')); ?>">
                        <i class="mdi mdi-account-key-outline"></i> <span>Admins</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('admin.displayUsers')); ?>">
                        <i class="mdi mdi-account-multiple-outline"></i> <span>Users</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('admin.displayFeedbacks')); ?>">
                        <i class="mdi mdi-comment-outline"></i> <span>Feedbacks</span>
                    </a>
                </li>
                <li class="menu-title"><span>Settings</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('profile')); ?>">
                        <i class="mdi mdi-account-circle-outline"></i> <span>Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="javascript:void();"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout"></i> <span key="t-logout"><?php echo app('translator')->get('translation.logout'); ?></span>
                    </a>
                </li>
            </ul>


        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
<?php /**PATH C:\xampp\htdocs\FYP-TESTING\resources\views\layouts\sidebar.blade.php ENDPATH**/ ?>