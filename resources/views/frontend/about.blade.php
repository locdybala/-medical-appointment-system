@extends('frontend.layouts.app')

@section('content')
<!-- About Section -->
<section id="about" class="about section">
    <div class="container">
        <div class="section-title">
            <h2>Về chúng tôi</h2>
            <p>Giới thiệu về phòng khám Medilab</p>
        </div>

        <div class="row gy-4 gx-5">
            <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="200">
                <img src="{{asset('frontend/assets/img/about.jpg')}}" class="img-fluid" alt="">
                <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn"></a>
            </div>

            <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                <h3>Phòng khám Medilab</h3>
                <p>
                    Medilab là phòng khám đa khoa chất lượng cao, được trang bị đầy đủ các thiết bị y tế hiện đại 
                    và đội ngũ bác sĩ chuyên môn cao. Chúng tôi cam kết mang đến dịch vụ chăm sóc sức khỏe tốt nhất 
                    cho cộng đồng.
                </p>
                <ul>
                    <li>
                        <i class="fa-solid fa-vial-circle-check"></i>
                        <div>
                            <h5>Đội ngũ bác sĩ chuyên môn cao</h5>
                            <p>Với nhiều năm kinh nghiệm trong lĩnh vực y tế, chúng tôi tự hào có đội ngũ bác sĩ giỏi</p>
                        </div>
                    </li>
                    <li>
                        <i class="fa-solid fa-pump-medical"></i>
                        <div>
                            <h5>Trang thiết bị hiện đại</h5>
                            <p>Được trang bị các thiết bị y tế tiên tiến nhất, đảm bảo chẩn đoán và điều trị chính xác</p>
                        </div>
                    </li>
                    <li>
                        <i class="fa-solid fa-heart-circle-xmark"></i>
                        <div>
                            <h5>Dịch vụ chăm sóc tận tâm</h5>
                            <p>Luôn đặt sức khỏe và sự hài lòng của bệnh nhân lên hàng đầu</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section id="stats" class="stats section light-background">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
            <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                <i class="fa-solid fa-user-doctor"></i>
                <div class="stats-item">
                    <span data-purecounter-start="0" data-purecounter-end="85" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Bác sĩ</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                <i class="fa-regular fa-hospital"></i>
                <div class="stats-item">
                    <span data-purecounter-start="0" data-purecounter-end="18" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Chuyên khoa</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                <i class="fas fa-flask"></i>
                <div class="stats-item">
                    <span data-purecounter-start="0" data-purecounter-end="12" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Phòng xét nghiệm</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                <i class="fas fa-award"></i>
                <div class="stats-item">
                    <span data-purecounter-start="0" data-purecounter-end="150" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Bệnh nhân mỗi ngày</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Doctors Section -->
<section id="doctors" class="doctors section">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Đội ngũ bác sĩ</h2>
            <p>Gặp gỡ đội ngũ bác sĩ chuyên môn cao của chúng tôi</p>
        </div>

        <div class="row">
            @foreach($doctors as $doctor)
            <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                <div class="member" data-aos="fade-up" data-aos-delay="100">
                    <div class="member-img">
                        <img src="{{ $doctor->image ?? asset('frontend/assets/img/doctors/doctor-1.jpg') }}" class="img-fluid" alt="">
                        <div class="social">
                            <a href="#"><i class="bi bi-twitter"></i></a>
                            <a href="#"><i class="bi bi-facebook"></i></a>
                            <a href="#"><i class="bi bi-instagram"></i></a>
                            <a href="#"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="member-info">
                        <h4>{{ $doctor->name }}</h4>
                        <span>{{ $doctor->specialty->name }}</span>
                        <p>{{ Str::limit($doctor->description, 100) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection 