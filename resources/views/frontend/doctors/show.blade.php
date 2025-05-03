@extends('frontend.layouts.app')

@section('content')
<!-- Doctor Detail Section -->
<section id="doctor-detail" class="doctor-detail section">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-4">
                <div class="member" data-aos="fade-up" data-aos-delay="100">
                    <div class="member-img">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="{{ $doctor->avatar ? asset($doctor->avatar) : asset('frontend/img/team-1.jpg') }}" alt="{{ $doctor->name }}">
                        </div>
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
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="doctor-info">
                    <h3>Thông tin bác sĩ</h3>
                    <p>{{ $doctor->description }}</p>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <ul>
                                <li><i class="bi bi-check-circle"></i> <strong>Kinh nghiệm:</strong> {{ $doctor->experience }} năm</li>
                                <li><i class="bi bi-check-circle"></i> <strong>Học vị:</strong> {{ $doctor->qualification }}</li>
                                <li><i class="bi bi-check-circle"></i> <strong>Phòng khám:</strong> {{ $doctor->room->name ?? 'Chưa thuộc phòng nào' }}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                <li><i class="bi bi-check-circle"></i> <strong>Email:</strong> {{ $doctor->email }}</li>
                                <li><i class="bi bi-check-circle"></i> <strong>Điện thoại:</strong> {{ $doctor->phone }}</li>
                                <li><i class="bi bi-check-circle"></i> <strong>Trạng thái:</strong>
                                    @if($doctor->is_active)
                                        <span class="badge bg-success">Đang làm việc</span>
                                    @else
                                        <span class="badge bg-danger">Tạm nghỉ</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="appointment-info">
                        <h4>Thông tin đặt lịch</h4>
                        <ul>
                            <li><i class="bi bi-clock"></i> <strong>Giờ làm việc:</strong> 8:00 - 17:00 (Thứ 2 - Thứ 6)</li>
                            <li><i class="bi bi-cash"></i> <strong>Phí khám:</strong> {{ $doctor->consultation_fee > 0 ? number_format($doctor->consultation_fee, 0, ',', '.') . ' VNĐ' : 'Thanh toán sau' }}</li>
                            <li><i class="bi bi-info-circle"></i> <strong>Lưu ý:</strong> Vui lòng đặt lịch trước ít nhất 24 giờ</li>
                        </ul>
                    </div>
                    <a href="{{ route('appointments.create', ['doctor' => $doctor->id]) }}" class="btn btn-primary">
                        <i class="bi bi-calendar-plus"></i> Đặt lịch khám
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
