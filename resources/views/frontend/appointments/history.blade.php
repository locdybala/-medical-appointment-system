@extends('frontend.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Lịch sử đặt lịch khám</h2>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Bác sĩ</th>
                                    <th>Chuyên khoa</th>
                                    <th>Ngày khám</th>
                                    <th>Giờ khám</th>
                                    <th>Phí khám</th>
                                    <th>Trạng thái</th>
                                    <th>Thanh toán</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->id }}</td>
                                        <td>{{ $appointment->doctor->user->name }}</td>
                                        <td>{{ $appointment->doctor->specialty->name }}</td>
                                        <td>{{ $appointment->appointment_date->format('d/m/Y') }}</td>
                                        <td>{{ $appointment->appointment_time->format('H:i') }}</td>
                                        <td>{{ number_format($appointment->fee, 0, ',', '.') }} VNĐ</td>
                                        <td>
                                            <span class="badge bg-{{ $appointment->status_badge }}">
                                                {{ $appointment->status_text }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($appointment->is_paid)
                                                <span class="badge bg-success">Đã thanh toán</span>
                                            @else
                                                <span class="badge bg-warning">Chưa thanh toán</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Xem
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Bạn chưa có lịch hẹn nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $appointments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 