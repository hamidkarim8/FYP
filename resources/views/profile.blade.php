@extends('layouts.master-without-nav')
@section('title')
    Profile
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('body')

    <body data-bs-spy="scroll" data-bs-target="#navbar-example">
    @endsection
    @section('content')
        <div class="layout-wrapper landing">
            <nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
                <div class="container">
                    <a class="navbar-brand mt-1" href="{{ URL::asset('/') }}">
                        <img src="{{ URL::asset('assets/images/logo-dark-new.png') }}" class="card-logo card-logo-dark"
                            alt="logo dark" height="20">
                        <img src="{{ URL::asset('assets/images/logo-light-new.png') }}" class="card-logo card-logo-light"
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
                                <a class="nav-link fs-14 active" href="home#hero">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fs-14" href="#services">Items</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fs-14" href="#features">Report</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fs-14" href="#faqs">FAQs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fs-14" href="#contact">Contact</a>
                            </li>
                        </ul>

                        <!-- Guest/Anonymous user content -->
                        @guest
                            <div class="">
                                <a href="{{ route('login') }}"
                                    class="btn btn-link fw-medium text-decoration-none text-dark">Sign in</a>
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
                                                <span
                                                    class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{ Auth::user()->role }}</span>
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
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
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
            {{-- <div class="position-relative mx-n4 mt-n4">
                        <div class="profile-wid-bg profile-setting-img">
                            <img src="{{ URL::asset('assets/images/about-bg.jpg') }}" class="profile-wid-img"
                                alt="">
                            <div class="overlay-content"></div>
                        </div>
                    </div> --}}

            {{-- <x-custom-toast /> --}}

            <section class="section pb-0 hero-section">
                <div class="bg-overlay bg-overlay-pattern"></div>
                <div class="container mt-4 pt-4">
                    <div class="row mt-4 pt-4">
                        <div class="col-xxl-3">
                            <div class="card mt-n5">
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <form action="{{ route('updateAvatar', ['id' => Auth::id()]) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <!-- Avatar upload field -->
                                            <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                                <img src="{{ $profile->avatar ? URL::asset('images/' . $profile->avatar) : URL::asset('images/default-avatar.jpg') }}"
                                                    class="rounded-circle avatar-xl img-thumbnail user-profile-image shadow"
                                                    alt="user-profile-image">
                                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                    <input id="profile-img-file-input" name="avatar" type="file"
                                                        class="profile-img-file-input">
                                                    <label for="profile-img-file-input"
                                                        class="profile-photo-edit avatar-xs">
                                                        <span
                                                            class="avatar-title rounded-circle bg-light text-body shadow">
                                                            <i class="ri-camera-fill"></i>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </form>
                                        <h5 class="fs-16 mb-1">{{ Auth::user()->name }}</h5>
                                        <p class="text-muted mb-0">
                                            {{ Auth::user()->role == 'admin' ? 'Admin' : 'Normal User' }}</p>
                                    </div>
                                </div>
                            </div>
                            <!--end card-->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title mb-0">Social Media test sdgzes</h5>
                                        </div>
                                    </div>
                                    <form action="{{ route('updateSocialMedia', ['id' => Auth::id()]) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        @php
                                            $socialMedia = json_decode($profile->social_media, true);
                                        @endphp
                                        <div class="mb-3 d-flex">
                                            <div class="avatar-xs d-block flex-shrink-0 me-3">
                                                <span class="avatar-title rounded-circle fs-16 text-light shadow">
                                                    <i class="ri-instagram-fill"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="igUsername"
                                                name="ig_username" placeholder="Username"
                                                value="{{ $socialMedia['ig_username'] ?? '' }}">
                                        </div>
                                        <div class="mb-3 d-flex">
                                            <div class="avatar-xs d-block flex-shrink-0 me-3">
                                                <span class="avatar-title rounded-circle fs-16 shadow">
                                                    <i class="ri-twitter-fill"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="twitterUsername"
                                                name="twitter_username" placeholder="Username"
                                                value="{{ $socialMedia['twitter_username'] ?? '' }}">
                                        </div>
                                        <div class="mb-3 d-flex">
                                            <div class="avatar-xs d-block flex-shrink-0 me-3">
                                                <span class="avatar-title rounded-circle fs-16 shadow">
                                                    <i class="bx bxl-tiktok"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="tiktokUsername"
                                                name="tiktok_username" placeholder="Username"
                                                value="{{ $socialMedia['tiktok_username'] ?? '' }}">
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->
                        <div class="col-xxl-9">
                            <div class="card mt-xxl-n5">
                                <div class="card-header">
                                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0"
                                        role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails"
                                                role="tab">
                                                <i class="fas fa-home"></i>
                                                Personal Details
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#changePassword"
                                                role="tab">
                                                <i class="far fa-user"></i>
                                                Change Password
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#privacy" role="tab">
                                                <i class="far fa-envelope"></i>
                                                Privacy Policy
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body p-4">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                            <form action="{{ route('updateProfile', ['id' => Auth::id()]) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('POST')
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="usernameInput" class="form-label">Username</label>
                                                            <input type="text" class="form-control" id="usernameInput"
                                                                name="username" placeholder="Enter your username"
                                                                value="{{ Auth::user()->name }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="emailInput" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="emailInput"
                                                                name="email" placeholder="Enter your email"
                                                                value="{{ Auth::user()->email }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="fullNameInput" class="form-label">Full
                                                                Name</label>
                                                            <input type="text" class="form-control" id="fullNameInput"
                                                                name="full_name" placeholder="Enter your full name"
                                                                value="{{ $profile->fullname }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="phonenumberInput" class="form-label">Phone
                                                                Number</label>
                                                            <input type="number" class="form-control"
                                                                id="phonenumberInput" name="phone_number"
                                                                placeholder="Enter your phone number"
                                                                value="{{ $profile->phone_number }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="cityInput" class="form-label">City</label>
                                                            <input type="text" class="form-control" id="cityInput"
                                                                name="city" placeholder="City"
                                                                value="{{ $profile->city }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="countryInput" class="form-label">Country</label>
                                                            <input type="text" class="form-control" id="countryInput"
                                                                name="country" placeholder="Country"
                                                                value="{{ $profile->country }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="postcodeInput" class="form-label">Postcode</label>
                                                            <input type="text" class="form-control" id="postcodeInput"
                                                                name="postcode" placeholder="Enter postcode"
                                                                value="{{ $profile->postcode }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mt-4">
                                                        <div class="hstack gap-2 justify-content-end mt-2">
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                            <button type="button"
                                                                class="btn btn-soft-success">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!--end tab-pane-->
                                        <div class="tab-pane" id="changePassword" role="tabpanel">
                                            <form action="{{ route('changePassword', ['id' => Auth::id()]) }}"
                                                method="POST">
                                                @csrf
                                                @method('POST')
                                                <div class="row g-2">
                                                    <div class="col-lg-4">
                                                        <div>
                                                            <label for="oldpasswordInput" class="form-label">Old
                                                                Password*</label>
                                                            <input type="password" class="form-control"
                                                                id="oldpasswordInput" name="old_password"
                                                                placeholder="Enter current password" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div>
                                                            <label for="newpasswordInput" class="form-label">New
                                                                Password*</label>
                                                            <input type="password" class="form-control"
                                                                id="newpasswordInput" name="new_password"
                                                                placeholder="Enter new password" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div>
                                                            <label for="confirmpasswordInput" class="form-label">Confirm
                                                                Password*</label>
                                                            <input type="password" class="form-control"
                                                                id="confirmpasswordInput" name="confirm_password"
                                                                placeholder="Confirm password" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <a href="{{ route('forgot-password-form') }}"
                                                                class="link-primary text-decoration-underline">Forgot
                                                                Password?</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="text-end">
                                                            <button type="submit" class="btn btn-success">Change
                                                                Password</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="privacy" role="tabpanel">
                                            <div class="mb-3">
                                                <h5 class="card-title text-decoration-underline mb-3">Permissions:
                                                </h5>
                                                <ul class="list-unstyled mb-0">
                                                    <li class="d-flex mt-2">
                                                        <div class="flex-grow-1">
                                                            <label class="form-check-label fs-14" for="allowNotification">
                                                                Allow notifications
                                                            </label>
                                                            <p class="text-muted">Enable this to receive
                                                                notifications and
                                                                updates
                                                                from the
                                                                system.</p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox"
                                                                    role="switch" id="allowNotification" />
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="d-flex mt-2">
                                                        <div class="flex-grow-1">
                                                            <label class="form-check-label fs-14" for="allowLocation">
                                                                Allow sharing current location
                                                            </label>
                                                            <p class="text-muted">Enable this to share your current
                                                                location with
                                                                the
                                                                system.</p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox"
                                                                    role="switch" id="allowLocation" />
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div>
                                                <h5 class="card-title text-decoration-underline mb-3">Delete This
                                                    Account:
                                                </h5>
                                                <p class="text-muted">Your account will be permanently removed from
                                                    the
                                                    system.
                                                    Please
                                                    enter your password to confirm.</p>
                                                <div>
                                                    <input type="password" class="form-control" id="passwordInput"
                                                        name="password" placeholder="Enter your password" value=""
                                                        style="max-width: 265px;">
                                                </div>
                                                <div class="hstack gap-2 mt-3">
                                                    <a href="javascript:void(0);" class="btn btn-soft-danger">Close &
                                                        Delete This
                                                        Account</a>
                                                    <a href="javascript:void(0);" class="btn btn-light">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end tab-pane-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                </div>

            </section>
            <!--end row-->
        @endsection
        @section('script')
            <script src="{{ URL::asset('assets/js/pages/profile-setting.init.js') }}"></script>
            <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script>
                $(document).ready(function() {
                    // Function to handle avatar file upload
                    $('#profile-img-file-input').change(function() {
                        var formData = new FormData();
                        formData.append('avatar', $(this)[0].files[0]);

                        $.ajax({
                            url: '{{ route('updateAvatar', ['id' => Auth::id()]) }}',
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Toastify({
                                    text: 'Avatar updated successfully.',
                                    duration: 3000,
                                    backgroundColor: '#28a745',
                                    gravity: 'top',
                                    position: 'center',
                                    close: true
                                }).showToast();
                            },
                            error: function(xhr, status, error) {
                                Toastify({
                                    text: 'Failed to update avatar.',
                                    duration: 3000,
                                    backgroundColor: '#dc3545',
                                    gravity: 'top',
                                    position: 'center',
                                    close: true
                                }).showToast();
                                console.error(xhr.responseText);
                            }
                        });
                    });
                });
            </script>
        @endsection
