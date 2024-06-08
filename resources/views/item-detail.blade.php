@extends('layouts.master-without-nav')
@section('title')
    Landing
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <link href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}" rel="stylesheet" type="text/css" />
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
                                <div class="col-lg-4">
                                    <div class="sticky-side-div">
                                        <div class="card ribbon-box border shadow-none right">
                                            <img src="{{ URL::asset('assets/images/nft/img-05.jpg') }}" alt=""
                                                class="img-fluid rounded">
                                            {{-- <div class="position-absolute bottom-0 p-3">
                                                <div class="position-absolute top-0 end-0 start-0 bottom-0 bg-white opacity-25"></div>
                                                <div class="row justify-content-center">
                                                    <div class="col-3">
                                                        <img src="{{URL::asset('assets/images/nft/img-02.jpg')}}" alt="" class="img-fluid rounded">
                                                    </div>
                                                    <div class="col-3">
                                                        <img src="{{URL::asset('assets/images/nft/img-03.jpg')}}" alt="" class="img-fluid rounded">
                                                    </div>
                                                    <div class="col-3">
                                                        <img src="{{URL::asset('assets/images/nft/gif/img-3.gif')}}" alt="" class="img-fluid rounded h-100 object-cover">
                                                    </div>
                                                    <div class="col-3">
                                                        <img src="{{URL::asset('assets/images/nft/img-06.jpg')}}" alt="" class="img-fluid rounded">
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                        <div class="hstack gap-2">
                                            <button class="btn btn-primary w-100">Request to contact</button>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-8">
                                    <div>
                                        {{-- <div class="dropdown float-end">
                                            <button class="btn btn-ghost-primary btn-icon dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle fs-16"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item view-item-btn" href="javascript:void(0);"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>View</a></li>
                                                <li><a class="dropdown-item edit-item-btn" href="#showModal" data-bs-toggle="modal"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                <li><a class="dropdown-item remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                            </ul>
                                        </div> --}}
                                        <span class="badge badge-soft-info mb-3 fs-12"><i
                                                class="ri-eye-line me-1 align-bottom"></i>Lost/Found Item</span>
                                        <h4>[Name of Item] | [Category]</h4>
                                        <div class="hstack gap-3 flex-wrap">
                                            <div class="text-muted">Reporter : <span class="text-body fw-medium">[Full
                                                    name of reporter]</span></div>
                                            <div class="vr"></div>
                                            <div class="text-muted">Date found/lost : <span
                                                    class="text-body fw-medium">[Date]</span></div>
                                            <div class="vr"></div>
                                            <div class="text-muted">Reported on : <span
                                                    class="text-body fw-medium">[Date]</span></div>
                                        </div>
                                        <!--end row-->
                                        <div class="mt-4 text-muted">
                                            <h5 class="fs-14">Description :</h5>
                                            <p>[Description]</p>
                                        </div>
                                        <div class="mt-4 text-muted">
                                            <h5 class="fs-14">Retrieval Info :</h5>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div class="text-muted">Phone Number : <span class="text-body fw-medium">[Phone Number but censored, only upon approval then show]</span></div>
                                                <div class="vr"></div>
                                                <div class="text-muted">Social Media : <span class="text-body fw-medium">[follow the json social media but censored, only upon approval then show]</span></div>
                                                <div class="vr"></div>
                                            </div>
                                        </div>
                                        <div class="product-content mt-5">
                                            <h5 class="fs-14 mb-3">Location Information :</h5>
                                            <nav>
                                                <ul class="nav nav-tabs nav-tabs-custom nav-success" id="nav-tab"
                                                    role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="nav-speci-tab"
                                                            data-bs-toggle="tab" href="#nav-speci" role="tab"
                                                            aria-controls="nav-speci" aria-selected="true">Map</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="nav-additional-tab" data-bs-toggle="tab"
                                                            href="#nav-additional" role="tab"
                                                            aria-controls="nav-additional"
                                                            aria-selected="false">Description</a>
                                                    </li>
                                                    {{-- <li class="nav-item">
                                                        <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab"
                                                            href="#nav-detail" role="tab" aria-controls="nav-detail"
                                                            aria-selected="false">Details</a>
                                                    </li> --}}
                                                </ul>
                                            </nav>
                                            <div class="tab-content border border-top-0 p-4" id="nav-tabContent">
                                                <div class="tab-pane fade" id="nav-additional" role="tabpanel"
                                                    aria-labelledby="nav-additional-tab">
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row" style="width: 200px;">Description: </th>
                                                                    <td>Location Description</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                {{-- <div class="tab-pane fade" id="nav-detail" role="tabpanel"
                                                    aria-labelledby="nav-detail-tab">
                                                    <div>
                                                        <h5 class="font-size-16 mb-3">Patterns arts & culture</h5>
                                                        <p>Cultural patterns are the similar behaviors within similar
                                                            situations we witness due to shared beliefs, values, norms and
                                                            social practices that are steady over time. In art, a pattern is
                                                            a repetition of specific visual elements. The dictionary.com
                                                            definition of "pattern" is: an arrangement of repeated or
                                                            corresponding parts, decorative motifs, etc.</p>
                                                        <div>
                                                            <p class="mb-2"><i
                                                                    class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>
                                                                On digital or printed media</p>
                                                            <p class="mb-2"><i
                                                                    class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>
                                                                For commercial and personal projects</p>
                                                            <p class="mb-2"><i
                                                                    class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>
                                                                From anywhere in the world</p>
                                                            <p class="mb-0"><i
                                                                    class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>
                                                                Full copyrights sale</p>
                                                        </div>
                                                    </div>
                                                </div> --}}
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
        <script src="{{ URL::asset('/assets/js/pages/landing.init.js') }}"></script>
        <script src="{{ URL::asset('/assets/libs/jsvectormap/jsvectormap.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-wizard.init.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/apps-nft-explore.init.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script>
        </script>
    @endsection
