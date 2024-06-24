<nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
    <div class="container">
        <a class="navbar-brand mt-1" href="{{ URL::asset('/') }}">
            <img src="{{ URL::asset('assets/images/logo-dark-new.png') }}" class="card-logo card-logo-dark" alt="logo dark"
                height="20">
            <img src="{{ URL::asset('assets/images/logo-light-new.png') }}" class="card-logo card-logo-light"
                alt="logo light" height="20">
        </a>
        <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="mdi mdi-menu"></i>
        </button>
        @php
            $homeUrl = url('/home#hero');
            $reportUrl = url('/home#reports');
            $itemsUrl = url('/home#items');
            $faqsUrl = url('/home#faqs');
            $contactUrl = url('/home#contact');
        @endphp
        <div class="collapse navbar-collapse" id="navbarSupportedContent2">
            <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
                <li class="nav-item">
                    <a class="nav-link fs-14 active" href="{{ $homeUrl }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-14" href="{{ $reportUrl }}">Report</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-14" href="{{ $itemsUrl }}">Items</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-14" href="{{ $faqsUrl }}">FAQs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-14" href="{{ $contactUrl }}">Contact</a>
                </li>
            </ul>

            <!-- Guest/Anonymous user content -->
            @guest
                <div class="">
                    <a href="{{ route('login') }}" class="btn btn-link fw-medium text-decoration-none text-dark">Sign in</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
                </div>
            @endguest

            <!-- Logged in normal_user content -->
            @auth
                @if (Auth::user()->hasRole('normal_user'))
                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <button type="button" class="btn shadow-none" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-flex align-items-center">
                                <img class="rounded-circle header-profile-user"
                                    src="@if (Auth::user()->profile && Auth::user()->profile->avatar != '') {{ URL::asset('images/' . Auth::user()->profile->avatar) }}
                        @else
                            {{ URL::asset('images/default-avatar.jpg') }} @endif"
                                    alt="Header Avatar">
                                <span class="text-start ms-xl-2">
                                    <span
                                        class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span>
                                    <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
                                        @if (Auth::user()->role === 'normal_user')
                                            User
                                        @else
                                            Admin
                                        @endif
                                    </span>
                                </span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header">Welcome {{ Auth::user()->name }}!</h6>
                            <a class="dropdown-item" href="{{ route('user.profile') }}"><i
                                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Profile</span></a>
                            <a class="dropdown-item " href="javascript:void();"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="bx bx-power-off font-size-16 align-middle me-1"></i> <span
                                    key="t-logout">@lang('translation.logout')</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endif
            @endauth


        </div>

    </div>
</nav>
<!-- end navbar -->
