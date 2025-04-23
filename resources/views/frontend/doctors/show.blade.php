@extends('frontend.layouts.app')

@section('content')
<!-- Doctor Detail Section -->
<section id="doctor-detail" class="doctor-detail section">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-4">
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
                                <li><i class="bi bi-check-circle"></i> <strong>Phòng khám:</strong> {{ $doctor->room->name }}</li>
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

                <div class="schedule mt-4">
                    <h3>Lịch làm việc</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Thứ</th>
                                    <th>Giờ làm việc</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($doctor->schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->day_of_week }}</td>
                                    <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                    <td>
                                        @if($schedule->is_available)
                                            <span class="badge bg-success">Còn trống</span>
                                        @else
                                            <span class="badge bg-danger">Đã đặt</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('appointment.create', ['doctor' => $doctor->id]) }}" class="btn btn-primary">Đặt lịch khám</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 