@extends('frontend.layouts.app')

@section('content')
<section class="appointments">
    <div class="container">
        <div class="section-title">
            <h2>Danh sách lịch hẹn</h2>
            <p>Quản lý các cuộc hẹn khám của bạn</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Bác sĩ</th>
                                        <th>Chuyên khoa</th>
                                        <th>Ngày khám</th>
                                        <th>Giờ khám</th>
                                        <th>Phí khám</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($appointments as $index => $appointment)
                                    <tr>
                                        <td>{{ ($appointments->currentPage() - 1) * $appointments->perPage() + $index + 1 }}</td>
                                        <td>{{ $appointment->doctor->user->name }}</td>
                                        <td>{{ $appointment->doctor->specialty->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</td>
                                        <td>{{ $appointment->appointment_time }}</td>
                                        <td>{{ $appointment->fee > 0 ? number_format($appointment->fee, 0, ',', '.') . ' VNĐ' : 'Thanh toán sau' }}</td>
                                        <td>
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
                                        </td>
                                        <td>
                                            <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Xem
                                            </a>
                                            @if($appointment->status == 'pending')
                                            <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn hủy lịch hẹn này?')">
                                                    <i class="fas fa-times"></i> Hủy
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Bạn chưa có lịch hẹn nào</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $appointments->links() }}
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
.appointments {
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
.table th {
    background-color: #f8f9fa;
}
.badge {
    font-size: 0.9em;
    padding: 0.5em 0.8em;
}
</style>
@endpush
