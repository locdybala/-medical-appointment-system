@extends('frontend.layouts.app')

@section('content')
<!-- Header Start -->
<div class="container-fluid header bg-primary p-0 mb-5">
    <div class="row g-0 align-items-center flex-column-reverse flex-lg-row">
        <div class="col-lg-6 p-5 wow fadeIn" data-wow-delay="0.1s">
            <h1 class="display-4 text-white mb-5">Chăm sóc sức khỏe tận tâm, uy tín và chuyên nghiệp</h1>
            <div class="row g-4">
                <div class="col-sm-4">
                    <div class="border-start border-light ps-4">
                        <h2 class="text-white mb-1" data-toggle="counter-up">{{ $doctorCount }}</h2>
                        <p class="text-light mb-0">Bác sĩ chuyên môn</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="border-start border-light ps-4">
                        <h2 class="text-white mb-1" data-toggle="counter-up">{{ $specialtyCount }}</h2>
                        <p class="text-light mb-0">Chuyên khoa</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="border-start border-light ps-4">
                        <h2 class="text-white mb-1" data-toggle="counter-up">{{ $appointmentCount }}</h2>
                        <p class="text-light mb-0">Lượt khám</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
            <div class="owl-carousel header-carousel">
                @foreach($featuredSpecialties as $specialty)
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="{{ $specialty->image_url ? asset($specialty->image_url) : asset('frontend/img/carousel-1.jpg') }}" alt="{{ $specialty->name }}">
                    <div class="owl-carousel-text">
                        <h1 class="display-1 text-white mb-0">{{ $specialty->name }}</h1>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                <div class="d-flex flex-column">
                    <img class="img-fluid rounded w-75 align-self-end" src="{{asset('frontend/img/about-1.jpg')}}" alt="">
                    <img class="img-fluid rounded w-50 bg-white pt-3 pe-3" src="{{asset('frontend/img/about-2.jpg')}}" alt="" style="margin-top: -25%;">
                </div>
            </div>
            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                <p class="d-inline-block border rounded-pill py-1 px-4">Về chúng tôi</p>
                <h1 class="mb-4">Tại sao bạn nên tin tưởng chúng tôi?</h1>
                <p>Với đội ngũ bác sĩ giàu kinh nghiệm và trang thiết bị hiện đại, chúng tôi cam kết mang đến dịch vụ chăm sóc sức khỏe tốt nhất cho bạn và gia đình.</p>
                <p class="mb-4">Chúng tôi luôn đặt sự an toàn và hiệu quả điều trị của bệnh nhân lên hàng đầu.</p>
                <p><i class="far fa-check-circle text-primary me-3"></i>Chất lượng dịch vụ cao cấp</p>
                <p><i class="far fa-check-circle text-primary me-3"></i>Đội ngũ bác sĩ chuyên môn cao</p>
                <p><i class="far fa-check-circle text-primary me-3"></i>Trang thiết bị hiện đại</p>
                <a class="btn btn-primary rounded-pill py-3 px-5 mt-3" href="{{ route('about') }}">Xem thêm</a>
            </div>
        </div>
    </div>
</div>
<!-- About End -->

<!-- Service Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <p class="d-inline-block border rounded-pill py-1 px-4">Chuyên khoa</p>
            <h1>Các chuyên khoa nổi bật</h1>
        </div>
        <div class="row g-4">
            @foreach($specialties as $specialty)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item bg-light rounded h-100 p-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                        <i class="{{ $specialty->icon ?? 'fa fa-stethoscope' }} text-primary fs-4"></i>
                    </div>
                    <h4 class="mb-3">{{ $specialty->name }}</h4>
                    <p class="mb-4">{{ Str::limit($specialty->description, 100) }}</p>
                    <a class="btn" href="{{ route('specialties.show', $specialty->id) }}">
                        <i class="fa fa-plus text-primary me-3"></i>Chi tiết
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Service End -->

<!-- Feature Start -->
<div class="container-fluid bg-primary overflow-hidden my-5 px-lg-0">
    <div class="container feature px-lg-0">
        <div class="row g-0 mx-lg-0">
            <div class="col-lg-6 feature-text py-5 wow fadeIn" data-wow-delay="0.1s">
                <div class="p-lg-5 ps-lg-0">
                    <p class="d-inline-block border rounded-pill text-light py-1 px-4">Tính năng</p>
                    <h1 class="text-white mb-4">Tại sao chọn chúng tôi</h1>
                    <p class="text-white mb-4 pb-2">Chúng tôi cam kết mang đến trải nghiệm khám chữa bệnh tốt nhất cho bạn</p>
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
                                    <i class="fa fa-user-md text-primary"></i>
                                </div>
                                <div class="ms-4">
                                    <p class="text-white mb-2">Kinh nghiệm</p>
                                    <h5 class="text-white mb-0">Bác sĩ giỏi</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
                                    <i class="fa fa-check text-primary"></i>
                                </div>
                                <div class="ms-4">
                                    <p class="text-white mb-2">Chất lượng</p>
                                    <h5 class="text-white mb-0">Dịch vụ tốt</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
                                    <i class="fa fa-comment-medical text-primary"></i>
                                </div>
                                <div class="ms-4">
                                    <p class="text-white mb-2">Tư vấn</p>
                                    <h5 class="text-white mb-0">Chuyên nghiệp</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
                                    <i class="fa fa-headphones text-primary"></i>
                                </div>
                                <div class="ms-4">
                                    <p class="text-white mb-2">Hỗ trợ</p>
                                    <h5 class="text-white mb-0">24/7</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 pe-lg-0" style="min-height: 400px;">
                <div class="position-relative h-100">
                    <img class="position-absolute img-fluid w-100 h-100" src="{{asset('frontend/img/feature.jpg')}}" style="object-fit: cover;" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Feature End -->

<!-- Team Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <p class="d-inline-block border rounded-pill py-1 px-4">Bác sĩ</p>
            <h1>Đội ngũ bác sĩ của chúng tôi</h1>
        </div>
        <div class="row g-4">
            @foreach($doctors as $doctor)
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="team-item position-relative rounded overflow-hidden">
                    <div class="overflow-hidden">
                        <img class="img-fluid" src="{{ $doctor->avatar ? asset($doctor->avatar) : asset('frontend/img/team-1.jpg') }}" alt="{{ $doctor->name }}">
                    </div>
                    <div class="team-text bg-light text-center p-4">
                        <h5>{{ $doctor->name }}</h5>
                        <p class="text-primary">{{ $doctor->specialty->name }}</p>
                        <div class="team-social text-center">
                            <a class="btn btn-primary" href="{{ route('doctors.show', $doctor->id) }}">Chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Team End -->

<!-- Appointment Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <p class="d-inline-block border rounded-pill py-1 px-4">Đặt lịch khám</p>
                <h1 class="mb-4">Đặt lịch khám trực tuyến</h1>
                <p class="mb-4">Dễ dàng đặt lịch khám với bác sĩ chuyên môn chỉ với vài bước đơn giản.</p>
                <div class="bg-light rounded d-flex align-items-center p-5 mb-4">
                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-white" style="width: 55px; height: 55px;">
                        <i class="fa fa-phone-alt text-primary"></i>
                    </div>
                    <div class="ms-4">
                        <p class="mb-2">Gọi để được tư vấn</p>
                        <h5 class="mb-0">+012 345 6789</h5>
                    </div>
                </div>
                <div class="bg-light rounded d-flex align-items-center p-5">
                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-white" style="width: 55px; height: 55px;">
                        <i class="fa fa-envelope-open text-primary"></i>
                    </div>
                    <div class="ms-4">
                        <p class="mb-2">Gửi email cho chúng tôi</p>
                        <h5 class="mb-0">info@example.com</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-light rounded h-100 d-flex align-items-center p-5">
                    <form action="{{ route('appointments.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <select class="form-select" name="specialty_id" required>
                                    <option value="">Chọn chuyên khoa</option>
                                    @foreach($specialties as $specialty)
                                        <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <select class="form-select" name="doctor_id" required>
                                    <option value="">Chọn bác sĩ</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <input type="date" class="form-control" name="date" min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" rows="5" name="symptoms" placeholder="Triệu chứng"></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Đặt lịch khám</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Appointment End -->

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const specialtySelect = document.querySelector('select[name="specialty_id"]');
    const doctorSelect = document.querySelector('select[name="doctor_id"]');

    specialtySelect.addEventListener('change', async function() {
        const specialtyId = this.value;
        if (!specialtyId) {
            doctorSelect.innerHTML = '<option value="">Chọn bác sĩ</option>';
            return;
        }

        const response = await fetch(`/api/specialties/${specialtyId}/doctors`);
        const doctors = await response.json();

        doctorSelect.innerHTML = '<option value="">Chọn bác sĩ</option>';
        doctors.forEach(doctor => {
            doctorSelect.innerHTML += `<option value="${doctor.id}">${doctor.name}</option>`;
        });
    });
});
</script>
@endpush
@endsection 