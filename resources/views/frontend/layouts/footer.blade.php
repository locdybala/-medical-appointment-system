<!-- Footer Start -->
<div class="container-fluid bg-dark text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <h5 class="text-light mb-4">Địa chỉ</h5>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Đường ABC, Quận XYZ, TP.HCM</p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+84 123 456 789</p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@medical-appointment.com</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="text-light mb-4">Liên kết nhanh</h5>
                <a class="btn btn-link" href="{{ route('home') }}">Trang chủ</a>
                <a class="btn btn-link" href="{{ route('about') }}">Giới thiệu</a>
                <a class="btn btn-link" href="{{ route('doctors') }}">Bác sĩ</a>
                <a class="btn btn-link" href="{{ route('specialties') }}">Chuyên khoa</a>
                <a class="btn btn-link" href="{{ route('contact.index') }}">Liên hệ</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="text-light mb-4">Dịch vụ</h5>
                <a class="btn btn-link" href="{{ route('appointments.create') }}">Đặt lịch khám</a>
                <a class="btn btn-link" href="{{ route('appointments.history') }}">Lịch sử khám</a>
                <a class="btn btn-link" href="#">Tư vấn trực tuyến</a>
                <a class="btn btn-link" href="#">Xét nghiệm</a>
                <a class="btn btn-link" href="#">Chăm sóc tại nhà</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="text-light mb-4">Giờ làm việc</h5>
                <p class="mb-1">Thứ 2 - Thứ 6</p>
                <h6 class="text-light">08:00 - 17:00</h6>
                <p class="mb-1">Thứ 7</p>
                <h6 class="text-light">08:00 - 12:00</h6>
                <p class="mb-1">Chủ nhật</p>
                <h6 class="text-light">Nghỉ</h6>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="{{ route('home') }}">{{ config('app.name') }}</a>, All Right Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                    </br>
                    Distributed By <a class="border-bottom" href="https://themewagon.com" target="_blank">ThemeWagon</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer End -->
