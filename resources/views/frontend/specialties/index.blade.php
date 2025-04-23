@extends('frontend.layouts.app')

@section('content')
<!-- Specialties Section -->
<section id="specialties" class="specialties section">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Chuyên khoa</h2>
            <p>Khám phá các chuyên khoa y tế của chúng tôi</p>
        </div>

        <div class="row gy-4">
            @foreach($specialties as $specialty)
            <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                <div class="department" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon">
                        <i class="{{ $specialty->icon ?? 'bi bi-heart-pulse' }}"></i>
                    </div>
                    <h4><a href="{{ route('specialties.show', $specialty) }}">{{ $specialty->name }}</a></h4>
                    <p>{{ Str::limit($specialty->description, 150) }}</p>
                    <div class="meta mt-3">
                        <span class="text-primary">
                            <i class="bi bi-people"></i> {{ $specialty->doctors_count }} bác sĩ
                        </span>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('specialties.show', $specialty) }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination justify-content-center mt-4">
            {{ $specialties->links() }}
        </div>
    </div>
</section>
@endsection 