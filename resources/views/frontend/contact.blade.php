@extends('frontend.layouts.app')
@section('content')
 <!-- Page Header Start -->
 <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Contact Us</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb text-uppercase mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Contact</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->


<!-- Contact Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="h-100 bg-light rounded d-flex align-items-center p-5">
                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-white" style="width: 55px; height: 55px;">
                        <i class="fa fa-map-marker-alt text-primary"></i>
                    </div>
                    <div class="ms-4">
                        <p class="mb-2">Address</p>
                        <h5 class="mb-0">123 Street, New York, USA</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="h-100 bg-light rounded d-flex align-items-center p-5">
                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-white" style="width: 55px; height: 55px;">
                        <i class="fa fa-phone-alt text-primary"></i>
                    </div>
                    <div class="ms-4">
                        <p class="mb-2">Call Us Now</p>
                        <h5 class="mb-0">+012 345 6789</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="h-100 bg-light rounded d-flex align-items-center p-5">
                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-white" style="width: 55px; height: 55px;">
                        <i class="fa fa-envelope-open text-primary"></i>
                    </div>
                    <div class="ms-4">
                        <p class="mb-2">Mail Us Now</p>
                        <h5 class="mb-0">info@example.com</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 wow fadeIn" data-wow-delay="0.5s">
                <div class="h-100" style="min-height: 400px;">
                    <iframe class="rounded w-100 h-100"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001156.4288297426!2d-78.01371936852176!3d42.72876761954724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ccc4bf0f123a5a9%3A0xddcfc6c1de189567!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd"
                    frameborder="0" allowfullscreen="" aria-hidden="false"
                    tabindex="0"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->


@endsection