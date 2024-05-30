@extends('layouts.master')
@section('title')
    @lang('translation.starter')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')


<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card p-4 shadow-sm">
            <h4>Tips for Reporting</h4>
            <ul class="list-unstyled mt-3">
                <li class="mb-2"><i class="mdi mdi-check-circle-outline"></i> Provide as much detail as possible.</li>
                <li class="mb-2"><i class="mdi mdi-check-circle-outline"></i> Include clear images of the item.</li>
                <li class="mb-2"><i class="mdi mdi-check-circle-outline"></i> Specify the exact location and date.</li>
                <li class="mb-2"><i class="mdi mdi-check-circle-outline"></i> Be honest and accurate in your report.</li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Vertical nav Steps</h4>
            </div><!-- end card header -->
            <div class="card-body form-steps">
                <form class="vertical-navs-step">
                    <div class="row gy-5">
                        <div class="col-lg-3">
                            <div class="nav flex-column custom-nav nav-pills" role="tablist" aria-orientation="vertical">
                                <button class="nav-link done" id="v-pills-bill-info-tab" data-bs-toggle="pill" data-bs-target="#v-pills-bill-info" type="button" role="tab" aria-controls="v-pills-bill-info" aria-selected="true">
                                    <span class="step-title me-2">
                                        <i class="ri-close-circle-fill step-icon me-2"></i>
                                        Step 1
                                    </span>
                                    Billing Info
                                </button>
                                <button class="nav-link active" id="v-pills-bill-address-tab" data-bs-toggle="pill" data-bs-target="#v-pills-bill-address" type="button" role="tab" aria-controls="v-pills-bill-address" aria-selected="false">
                                    <span class="step-title me-2">
                                        <i class="ri-close-circle-fill step-icon me-2"></i>
                                        Step 2
                                    </span>
                                    Address
                                </button>
                                <button class="nav-link" id="v-pills-payment-tab" data-bs-toggle="pill" data-bs-target="#v-pills-payment" type="button" role="tab" aria-controls="v-pills-payment" aria-selected="false">
                                    <span class="step-title me-2">
                                        <i class="ri-close-circle-fill step-icon me-2"></i>
                                        Step 3
                                    </span>
                                    Payment
                                </button>
                                <button class="nav-link" id="v-pills-finish-tab" data-bs-toggle="pill" data-bs-target="#v-pills-finish" type="button" role="tab" aria-controls="v-pills-finish" aria-selected="false">
                                    <span class="step-title me-2">
                                        <i class="ri-close-circle-fill step-icon me-2"></i>
                                        Step 4
                                    </span>
                                    Finish
                                </button>
                            </div>
                            <!-- end nav -->
                        </div> <!-- end col-->
                        <div class="col-lg-6">
                            <div class="px-lg-4">
                                <div class="tab-content">
                                    <div class="tab-pane fade" id="v-pills-bill-info" role="tabpanel" aria-labelledby="v-pills-bill-info-tab">
                                        <div>
                                            <h5>Billing Info</h5>
                                            <p class="text-muted">Fill all information below</p>
                                        </div>

                                        <div>
                                            <div class="row g-3">
                                                <div class="col-sm-6">
                                                    <label for="firstName" class="form-label">First name</label>
                                                    <input type="text" class="form-control" id="firstName" placeholder="Enter First Name" value="">
                                                </div>

                                                <div class="col-sm-6">
                                                    <label for="lastName" class="form-label">Last name</label>
                                                    <input type="text" class="form-control" id="lastName" placeholder="Enter Last Name" value="">
                                                </div>

                                                <div class="col-12">
                                                    <label for="username" class="form-label">Username</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">@</span>
                                                        <input type="text" class="form-control" id="username" placeholder="Username">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
                                                    <input type="email" class="form-control" id="email" placeholder="Enter Email">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-start gap-3 mt-4">
                                            <button type="button" class="btn btn-success btn-label right ms-auto nexttab
nexttab" data-nexttab="v-pills-bill-address-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to Shipping</button>
                                        </div>
                                    </div>
                                    <!-- end tab pane -->
                                    <div class="tab-pane fade show active" id="v-pills-bill-address" role="tabpanel" aria-labelledby="v-pills-bill-address-tab">
                                        <div>
                                            <h5>Shipping Address</h5>
                                            <p class="text-muted">Fill all information below</p>
                                        </div>

                                        <div>
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label for="address" class="form-label">Address</label>
                                                    <input type="text" class="form-control" id="address" placeholder="1234 Main St">
                                                </div>

                                                <div class="col-12">
                                                    <label for="address2" class="form-label">Address 2 <span class="text-muted">(Optional)</span></label>
                                                    <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
                                                </div>

                                                <div class="col-md-5">
                                                    <label for="country" class="form-label">Country</label>
                                                    <select class="form-select" id="country">
                                                        <option value="">Choose...</option>
                                                        <option>United States</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="state" class="form-label">State</label>
                                                    <select class="form-select" id="state">
                                                        <option value="">Choose...</option>
                                                        <option>California</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="zip" class="form-label">Zip</label>
                                                    <input type="text" class="form-control" id="zip" placeholder="">
                                                </div>
                                            </div>

                                            <hr class="my-4 text-muted">

                                            <div class="form-check mb-2">
                                                <input type="checkbox" class="form-check-input" id="same-address">
                                                <label class="form-check-label" for="same-address">Shipping address is the same as my billing address</label>
                                            </div>

                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="save-info">
                                                <label class="form-check-label" for="save-info">Save this information for next time</label>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-start gap-3 mt-4">
                                            <button type="button" class="btn btn-light btn-label previestab" data-previous="v-pills-bill-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to Billing Info</button>
                                            <button type="button" class="btn btn-success btn-label right ms-auto nexttab
nexttab" data-nexttab="v-pills-payment-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to Payment</button>
                                        </div>
                                    </div>
                                    <!-- end tab pane -->
                                    <div class="tab-pane fade" id="v-pills-payment" role="tabpanel" aria-labelledby="v-pills-payment-tab">
                                        <div>
                                            <h5>Payment</h5>
                                            <p class="text-muted">Fill all information below</p>
                                        </div>

                                        <div>
                                            <div class="my-3">
                                                <div class="form-check form-check-inline">
                                                    <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>
                                                    <label class="form-check-label" for="credit">Credit card</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input id="debit" name="paymentMethod" type="radio" class="form-check-input" required>
                                                    <label class="form-check-label" for="debit">Debit card</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required>
                                                    <label class="form-check-label" for="paypal">PayPal</label>
                                                </div>
                                            </div>

                                            <div class="row gy-3">
                                                <div class="col-md-12">
                                                    <label for="cc-name" class="form-label">Name on card</label>
                                                    <input type="text" class="form-control" id="cc-name" placeholder="" required>
                                                    <small class="text-muted">Full name as displayed on card</small>
                                                    <div class="invalid-feedback">
                                                        Name on card is required
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="cc-number" class="form-label">Credit card number</label>
                                                    <input type="text" class="form-control" id="cc-number" placeholder="" required>
                                                    <div class="invalid-feedback">
                                                        Credit card number is required
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="cc-expiration" class="form-label">Expiration</label>
                                                    <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                                                    <div class="invalid-feedback">
                                                        Expiration date required
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="cc-cvv" class="form-label">CVV</label>
                                                    <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                                                    <div class="invalid-feedback">
                                                        Security code required
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-start gap-3 mt-4">
                                            <button type="button" class="btn btn-light btn-label previestab" data-previous="v-pills-bill-address-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to Shipping Info</button>
                                            <button type="button" class="btn btn-success btn-label right ms-auto nexttab
nexttab" data-nexttab="v-pills-finish-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i> Order Complete</button>
                                        </div>
                                    </div>
                                    <!-- end tab pane -->
                                    <div class="tab-pane fade" id="v-pills-finish" role="tabpanel" aria-labelledby="v-pills-finish-tab">
                                        <div class="text-center pt-4 pb-2">

                                            <div class="mb-4">
                                                <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>
                                            </div>
                                            <h5>Your Order is Completed !</h5>
                                            <p class="text-muted">You Will receive an order confirmation email with details of your order.</p>
                                        </div>
                                    </div>
                                    <!-- end tab pane -->
                                </div>
                                <!-- end tab content -->
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </form>
            </div>
        </div>
        <!-- end -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->
<style>
.card {
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.form-label {
    font-weight: bold;
}

.form-control, .form-select {
    border-radius: 5px;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    transition: background-color 0.3s, border-color 0.3s;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
}

.list-unstyled li {
    display: flex;
    align-items: center;
}

.list-unstyled i {
    margin-right: 10px;
    color: #007bff;
}
</style>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
});
</script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/form-wizard.init.js') }}"></script>
@endsection
