<!-- Footer Start -->
<div class="container-fluid bg-dark text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <h5 class="text-light mb-4">Thông tin liên hệ</h5>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Đường ABC, Quận XYZ, TP.HCM</p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+84 123 456 789</p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@phongkham.com</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-outline-light btn-social rounded-circle" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social rounded-circle" href="#"><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-outline-light btn-social rounded-circle" href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="text-light mb-4">Chuyên khoa</h5>
                <a class="btn btn-link" href="{{ route('specialties') }}">Nội khoa</a>
                <a class="btn btn-link" href="{{ route('specialties') }}">Ngoại khoa</a>
                <a class="btn btn-link" href="{{ route('specialties') }}">Nhi khoa</a>
                <a class="btn btn-link" href="{{ route('specialties') }}">Sản phụ khoa</a>
                <a class="btn btn-link" href="{{ route('specialties') }}">Răng hàm mặt</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="text-light mb-4">Liên kết nhanh</h5>
                <a class="btn btn-link" href="{{ route('home') }}">Trang chủ</a>
                <a class="btn btn-link" href="{{ route('doctors') }}">Đội ngũ bác sĩ</a>
                <a class="btn btn-link" href="{{ route('contact.index') }}">Liên hệ</a>
                <a class="btn btn-link" href="#">Điều khoản sử dụng</a>
                <a class="btn btn-link" href="#">Chính sách bảo mật</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="text-light mb-4">Giờ làm việc</h5>
                <p class="mb-1"><i class="far fa-clock me-2"></i>Thứ 2 - Thứ 6: 8:00 - 17:00</p>
                <p class="mb-1"><i class="far fa-clock me-2"></i>Thứ 7: 8:00 - 12:00</p>
                <p class="mb-1"><i class="far fa-clock me-2"></i>Chủ nhật: Nghỉ</p>
                <p class="mt-4">Đăng ký nhận thông báo</p>
                <div class="position-relative mx-auto" style="max-width: 400px;">
                    <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Email của bạn">
                    <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Đăng ký</button>
                </div>
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
                    <!--/*** This template is free as long as you keep the footer author's credit link/attribution link/backlink. If you'd like to use the template without the footer author's credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Designed By <a class="border-bottom" href="#">Your Team</a>
                    </br>
                    Distributed By <a class="border-bottom" href="https://themewagon.com" target="_blank">ThemeWagon</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer End -->
