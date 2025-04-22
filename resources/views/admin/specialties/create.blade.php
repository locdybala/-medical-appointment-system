@extends('adminlte::page')

@section('title', 'Thêm chuyên khoa mới')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Thêm chuyên khoa mới</h1>
        <a href="{{ route('admin.specialties.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.specialties.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Tên chuyên khoa <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                        id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Mô tả</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                        id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="icon">Icon (Font Awesome Class)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i id="icon-preview" class="fas fa-stethoscope"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                            id="icon" name="icon" value="{{ old('icon', 'fas fa-stethoscope') }}"
                            placeholder="Ví dụ: fas fa-stethoscope">
                    </div>
                    <small class="form-text text-muted">
                        Tham khảo icon tại <a href="https://fontawesome.com/icons" target="_blank">Font Awesome</a>
                    </small>
                    @error('icon')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" 
                            {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">Trạng thái hoạt động</label>
                    </div>
                </div>

                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Cập nhật icon preview khi nhập
            $('#icon').on('input', function() {
                const iconClass = $(this).val();
                $('#icon-preview').attr('class', iconClass);
            });
        });
    </script>
@stop 