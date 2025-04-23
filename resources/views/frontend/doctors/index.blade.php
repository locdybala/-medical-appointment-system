@extends('frontend.layouts.app')

@section('content')
<!-- Doctors Section -->
<section id="doctors" class="doctors section">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Đội ngũ bác sĩ</h2>
            <p>Gặp gỡ đội ngũ bác sĩ chuyên môn cao của chúng tôi</p>
        </div>

        <div class="row">
            <div class="col-lg-3">
                <div class="sidebar">
                    <div class="sidebar-item categories">
                        <h3 class="sidebar-title">Chuyên khoa</h3>
                        <ul class="mt-3">
                            <li><a href="{{ route('doctors') }}">Tất cả</a></li>
                            @foreach($specialties as $specialty)
                            <li><a href="{{ route('doctors', ['specialty' => $specialty->id]) }}">{{ $specialty->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    @foreach($doctors as $doctor)
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
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
                                <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-primary">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="pagination justify-content-center mt-4">
                    {{ $doctors->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 