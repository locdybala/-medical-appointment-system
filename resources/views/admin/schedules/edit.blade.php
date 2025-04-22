@extends('adminlte::page')

@section('title', 'Sửa thông tin lịch khám')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Sửa thông tin lịch khám</h1>
        <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="doctor_id">Bác sĩ <span class="text-danger">*</span></label>
                    <select class="form-control @error('doctor_id') is-invalid @enderror" 
                        id="doctor_id" name="doctor_id" required>
                        <option value="">Chọn bác sĩ</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" 
                                {{ old('doctor_id', $schedule->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->name }} - {{ $doctor->specialty->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Ngày khám <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                id="date" name="date" value="{{ old('date', $schedule->date->format('Y-m-d')) }}" required>
                            @error('date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="shift">Ca khám <span class="text-danger">*</span></label>
                            <select class="form-control @error('shift') is-invalid @enderror" 
                                id="shift" name="shift" required>
                                <option value="">Chọn ca khám</option>
                                <option value="morning" {{ old('shift', $schedule->shift) == 'morning' ? 'selected' : '' }}>Buổi sáng</option>
                                <option value="afternoon" {{ old('shift', $schedule->shift) == 'afternoon' ? 'selected' : '' }}>Buổi chiều</option>
                            </select>
                            @error('shift')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_time">Thời gian bắt đầu <span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('start_time') is-invalid @enderror" 
                                id="start_time" name="start_time" value="{{ old('start_time', $schedule->start_time->format('H:i')) }}" required>
                            @error('start_time')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_time">Thời gian kết thúc <span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('end_time') is-invalid @enderror" 
                                id="end_time" name="end_time" value="{{ old('end_time', $schedule->end_time->format('H:i')) }}" required>
                            @error('end_time')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="max_patients">Số bệnh nhân tối đa <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('max_patients') is-invalid @enderror" 
                        id="max_patients" name="max_patients" value="{{ old('max_patients', $schedule->max_patients) }}" min="1" required>
                    @error('max_patients')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="is_available" name="is_available" value="1" 
                            {{ old('is_available', $schedule->is_available) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_available">Có thể đặt lịch</label>
                    </div>
                </div>

                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop 