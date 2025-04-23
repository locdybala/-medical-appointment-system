@extends('frontend.layouts.app')

@section('content')
<!-- Specialty Detail Section -->
<section id="specialty-detail" class="specialty-detail section">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>{{ $specialty->name }}</h2>
            <p>{{ $specialty->description }}</p>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="specialty-info mb-5">
                    <div class="icon text-center mb-4">
                        <i class="{{ $specialty->icon ?? 'bi bi-heart-pulse' }} fa-3x"></i>
                    </div>
                    <div class="meta text-center mb-4">
                        <span class="text-primary">
                            <i class="bi bi-people"></i> {{ $doctors->total() }} bác sĩ
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h3 class="mb-4">Đội ngũ bác sĩ {{ $specialty->name }}</h3>
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
                                <span>{{ $doctor->qualification }}</span>
                                <p>{{ Str::limit($doctor->description, 100) }}</p>
                                <div class="mt-3">
                                    <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-primary">Xem chi tiết</a>
                                </div>
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