@extends('adminlte::page')

@section('title', 'Chi tiết lịch hẹn')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Chi tiết lịch hẹn</h1>
        <div>
            <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Sửa
            </a>
            <form action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa lịch hẹn này?')">
                    <i class="fas fa-trash"></i> Xóa
                </button>
            </form>
            <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Bệnh nhân</label>
                        <p class="form-control-static">{{ $appointment->patient->name }}</p>
                    </div>
                    <div class="form-group">
                        <label>Bác sĩ</label>
                        <p class="form-control-static">{{ $appointment->doctor->user->name }}</p>
                    </div>
                    <div class="form-group">
                        <label>Ngày hẹn</label>
                        <p class="form-control-static">{{ $appointment->appointment_date }}</p>
                    </div>
                    <div class="form-group">
                        <label>Giờ hẹn</label>
                        <p class="form-control-static">{{ $appointment->appointment_time }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Phí khám</label>
                        <p class="form-control-static">{{ number_format($appointment->fee, 0, ',', '.') }} VNĐ</p>
                    </div>
                    <div class="form-group">
                        <label>Trạng thái thanh toán</label>
                        <p class="form-control-static">
                            @if($appointment->is_paid)
                                <span class="badge badge-success">Đã thanh toán</span>
                            @else
                                <span class="badge badge-warning">Chưa thanh toán</span>
                            @endif
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Ghi chú</label>
                        <p class="form-control-static">{{ $appointment->notes ?? 'Không có ghi chú' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
