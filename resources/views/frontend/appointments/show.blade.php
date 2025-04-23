@extends('frontend.layouts.app')

@section('content')
<!-- Appointment Detail Section -->
<section id="appointment-detail" class="appointment-detail section">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Chi tiết lịch hẹn</h2>
            <p>Thông tin chi tiết về lịch hẹn khám bệnh của bạn</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="appointment-info">
                            <h3 class="mb-4">Thông tin lịch hẹn #{{ $appointment->id }}</h3>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5>Thông tin bệnh nhân</h5>
                                    <p><strong>Họ và tên:</strong> {{ $appointment->patient->name }}</p>
                                    <p><strong>Email:</strong> {{ $appointment->patient->email }}</p>
                                    <p><strong>Số điện thoại:</strong> {{ $appointment->patient->phone }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5>Thông tin bác sĩ</h5>
                                    <p><strong>Bác sĩ:</strong> {{ $appointment->doctor->name }}</p>
                                    <p><strong>Chuyên khoa:</strong> {{ $appointment->doctor->specialty->name }}</p>
                                    <p><strong>Phòng khám:</strong> {{ $appointment->doctor->room->name }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5>Thời gian khám</h5>
                                    <p><strong>Ngày khám:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</p>
                                    <p><strong>Giờ khám:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5>Trạng thái</h5>
                                    <p>
                                        <strong>Tình trạng:</strong>
                                        @switch($appointment->status)
                                            @case('pending')
                                                <span class="badge bg-warning">Chờ xác nhận</span>
                                                @break
                                            @case('confirmed')
                                                <span class="badge bg-success">Đã xác nhận</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge bg-danger">Đã hủy</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ $appointment->status }}</span>
                                        @endswitch
                                    </p>
                                    <p><strong>Phí khám:</strong> {{ number_format($appointment->fee) }} VNĐ</p>
                                    <p>
                                        <strong>Thanh toán:</strong>
                                        @if($appointment->is_paid)
                                            <span class="badge bg-success">Đã thanh toán</span>
                                        @else
                                            <span class="badge bg-warning">Chưa thanh toán</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            @if($appointment->message)
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h5>Ghi chú</h5>
                                    <p>{{ $appointment->message }}</p>
                                </div>
                            </div>
                            @endif

                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Quay lại
                                        </a>
                                        @if($appointment->status === 'pending')
                                        <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn hủy lịch hẹn này?')">
                                                <i class="bi bi-x-circle"></i> Hủy lịch hẹn
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 