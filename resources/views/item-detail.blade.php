@extends('layouts.master-without-nav')
@section('title')
    Landing
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .map-container {
            height: 300px;
            max-width: 500px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .map-container {
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
@endsection
@section('body')

    <body data-bs-spy="scroll" data-bs-target="#navbar-example">
    @endsection
    @section('content')
        <!-- Begin page -->
        <div class="layout-wrapper landing">

            @include('layouts-user.navbar')
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
                                                        @foreach ($report->image_paths as $image)
                                                            <div class="swiper-slide">
                                                                <div
                                                                    class="ribbon-two {{ $report->type === 'lost' ? 'ribbon-two-danger' : 'ribbon-two-secondary' }}">
                                                                    <span>{{ ucfirst($report->type) }}</span>
                                                                </div>
                                                                <img src="{{ asset($image) }}" alt="{{ $report->title }}"
                                                                    class="img-fluid" />
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="swiper-button-next bg-white shadow"></div>
                                                    <div class="swiper-button-prev bg-white shadow"></div>
                                                    <div class="swiper-pagination"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hstack gap-2">
                                            @if ($report->type === 'lost')
                                                <button class="btn btn-primary w-100">Request Proof of Ownership</button>
                                            @else
                                                <button class="btn btn-primary w-100">Request to Contact</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-8">
                                    <div>
                                        <h3>{{ $report->title }} | {{ $report->category->name }}</h3>
                                        <div class="hstack gap-3 flex-wrap mt-4">
                                            <div class="text-muted">Reporter: <span
                                                    class="text-body fw-medium">{{ $report->fullname }}</span></div>
                                            <div class="vr"></div>
                                            <div class="text-muted">Date ({{ $report->type }}): <span
                                                    class="text-body fw-medium">{{ $report->reported_at->format('d-m-Y') }}</span>
                                            </div>
                                            <div class="vr"></div>
                                            <div class="text-muted">Reported on: <span
                                                    class="text-body fw-medium">{{ $report->created_at->format('d-m-Y') }}</span>
                                            </div>
                                        </div>
                                        <!--end row-->
                                        <div class="mt-4 text-muted">
                                            <h5 class="fs-14">Description:</h5>
                                            <p>{{ $report->description }}</p>
                                        </div>
                                        <div class="mt-4 text-muted">
                                            <h5 class="fs-14">Retrieval Info:</h5>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div class="text-muted">Phone Number: <span
                                                        class="text-body fw-medium">{{ $report->phone_number }}</span>
                                                </div>
                                                <div class="vr"></div>
                                                <div class="text-muted">Email: <span
                                                        class="text-body fw-medium">{{ $report->email }}</span>
                                                </div>
                                                <div class="vr"></div>
                                                <div class="text-muted">
                                                    Social Media:
                                                    <br>
                                                    <span class="text-body fw-medium">
                                                        @foreach ($report->social_media as $key => $value)
                                                            @if ($value)
                                                                @php
                                                                    $platform = '';
                                                                    if (strpos($key, 'ig_') !== false) {
                                                                        $platform = 'Instagram';
                                                                    } elseif (strpos($key, 'twitter_') !== false) {
                                                                        $platform = 'Twitter';
                                                                    } elseif (strpos($key, 'tiktok_') !== false) {
                                                                        $platform = 'TikTok';
                                                                    }
                                                                @endphp

                                                                @if ($platform)
                                                                    {{ $platform }}: {{ $value }}<br>
                                                                @endif
                                                            @endif
                                                        @endforeach
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
                                                        <div id="displayDetailReportMap" class="map-container"></div>
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
                                                                    <td>{{ $report->location['desc'] }}</td>
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
            @include('layouts-user.footer')
            <!-- end footer -->

        </div>
        <!-- end layout wrapper -->
    @endsection
    @section('script')
        <script src="{{ URL::asset('/assets/libs/swiper/swiper.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/js/pages/swiper.init.js') }}"></script>
        <script src="{{ URL::asset('/assets/js/pages/landing.init.js') }}"></script>
        <script src="{{ URL::asset('/assets/libs/jsvectormap/jsvectormap.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-wizard.init.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/apps-nft-explore.init.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var reportLat = @json($report->location['lat']);
                var reportLng = @json($report->location['lng']);
                var reportType = @json($report->type);
                var reportTitle = @json($report->title);
                var reportDesc = @json($report->location['desc']);

                // Initialize the map
                var displayDetailReportMap = L.map('displayDetailReportMap').setView([3.05603, 101.70022], 17);

                // Add a tile layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(displayDetailReportMap);

                // Add a marker
                var markerColor = reportType === 'found' ? 'blue' : 'red';
                var marker = L.circleMarker([reportLat, reportLng], {
                    color: markerColor,
                    radius: 10
                }).addTo(displayDetailReportMap);

                // Add popup to the marker
                marker.bindPopup("<b>" + reportTitle + "</b><br>" + reportDesc).openPopup();
            });
        </script>
    @endsection
