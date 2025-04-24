@extends('frontend.layouts.app')

@section('content')
<section class="appointment-details">
    <div class="container">
        <div class="section-title">
            <h2>Chi tiết lịch hẹn</h2>
            <p>Thông tin chi tiết về cuộc hẹn của bạn</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="card-title">Thông tin bác sĩ</h5>
                                <p><strong>Tên bác sĩ:</strong> {{ $appointment->doctor->user->name }}</p>
                                <p><strong>Chuyên khoa:</strong> {{ $appointment->doctor->specialty->name }}</p>
                                <p><strong>Kinh nghiệm:</strong> {{ $appointment->doctor->experience }} năm</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="card-title">Thông tin lịch hẹn</h5>
                                <p><strong>Ngày khám:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</p>
                                <p><strong>Giờ khám:</strong> {{ $appointment->appointment_time }}</p>
                                <p><strong>Phí khám:</strong> {{ $appointment->fee > 0 ? number_format($appointment->fee, 0, ',', '.') . ' VNĐ' : 'Thanh toán sau' }}</p>
                                <p>
                                    <strong>Trạng thái:</strong>
                                    @switch($appointment->status)
                                        @case('pending')
                                            <span class="badge bg-warning">Chờ xác nhận</span>
                                            @break
                                        @case('confirmed')
                                            <span class="badge bg-success">Đã xác nhận</span>
                                            @break
                                        @case('completed')
                                            <span class="badge bg-info">Đã hoàn thành</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger">Đã hủy</span>
                                            @break
                                    @endswitch
                                </p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="card-title">Triệu chứng/Lý do khám</h5>
                                <p>{{ $appointment->symptoms }}</p>
                            </div>
                        </div>

                        @if($appointment->status == 'completed')
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="card-title">Kết quả khám</h5>
                                <p><strong>Chẩn đoán:</strong> {{ $appointment->diagnosis }}</p>
                                <p><strong>Đơn thuốc:</strong> {{ $appointment->prescription }}</p>
                                <p><strong>Ghi chú:</strong> {{ $appointment->notes }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                                @if($appointment->status == 'pending')
                                <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn hủy lịch hẹn này?')">
                                        <i class="fas fa-times"></i> Hủy lịch hẹn
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
</section>
@endsection

@push('styles')
<style>
.appointment-details {
    padding: 60px 0;
}
.section-title {
    text-align: center;
    margin-bottom: 40px;
}
.section-title h2 {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 10px;
}
.section-title p {
    color: #6c757d;
}
.card-title {
    color: #0d6efd;
    margin-bottom: 20px;
}
.badge {
    font-size: 0.9em;
    padding: 0.5em 0.8em;
}
</style>
@endpush
