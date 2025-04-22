@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Thêm lịch hẹn mới</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-default float-right">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <form action="{{ route('admin.appointments.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="patient_id">Bệnh nhân <span class="text-danger">*</span></label>
                                <select name="patient_id" id="patient_id" class="form-control @error('patient_id') is-invalid @enderror" required>
                                    <option value="">Chọn bệnh nhân</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->name }} ({{ $patient->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('patient_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="doctor_id">Bác sĩ <span class="text-danger">*</span></label>
                                <select name="doctor_id" id="doctor_id" class="form-control @error('doctor_id') is-invalid @enderror" required>
                                    <option value="">Chọn bác sĩ</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->name }} ({{ $doctor->specialty->name }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('doctor_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="appointment_date">Ngày hẹn <span class="text-danger">*</span></label>
                                <input type="date" name="appointment_date" id="appointment_date" 
                                    class="form-control @error('appointment_date') is-invalid @enderror" 
                                    value="{{ old('appointment_date') }}" required>
                                @error('appointment_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="appointment_time">Giờ hẹn <span class="text-danger">*</span></label>
                                <select name="appointment_time" id="appointment_time" 
                                    class="form-control @error('appointment_time') is-invalid @enderror" required>
                                    <option value="">Chọn giờ hẹn</option>
                                    @foreach($schedules as $schedule)
                                        <option value="{{ $schedule->time }}" {{ old('appointment_time') == $schedule->time ? 'selected' : '' }}>
                                            {{ $schedule->time }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('appointment_time')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fee">Phí khám <span class="text-danger">*</span></label>
                                <input type="number" name="fee" id="fee" 
                                    class="form-control @error('fee') is-invalid @enderror" 
                                    value="{{ old('fee') }}" required>
                                @error('fee')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="is_paid">Trạng thái thanh toán</label>
                                <select name="is_paid" id="is_paid" class="form-control">
                                    <option value="0" {{ old('is_paid') == '0' ? 'selected' : '' }}>Chưa thanh toán</option>
                                    <option value="1" {{ old('is_paid') == '1' ? 'selected' : '' }}>Đã thanh toán</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Ghi chú</label>
                        <textarea name="notes" id="notes" rows="3" 
                            class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(function() {
        // Initialize select2 for better dropdown experience
        $('#patient_id, #doctor_id, #appointment_time').select2({
            theme: 'bootstrap4'
        });
    });
</script>
@endpush 