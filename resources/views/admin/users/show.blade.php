@extends('adminlte::page')

@section('title', 'Chi tiết tài khoản')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Chi tiết tài khoản</h1>
        <div>
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Sửa
            </a>
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?')">
                    <i class="fas fa-trash"></i> Xóa
                </button>
            </form>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
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
                        <label>Tên</label>
                        <p class="form-control-static">{{ $user->name }}</p>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <p class="form-control-static">{{ $user->email }}</p>
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <p class="form-control-static">{{ $user->phone }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Vai trò</label>
                        <p class="form-control-static">
                            @foreach($user->roles as $role)
                                <span class="badge badge-info">{{ $role->name }}</span>
                            @endforeach
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <p class="form-control-static">
                            @if($user->is_active)
                                <span class="badge badge-success">Hoạt động</span>
                            @else
                                <span class="badge badge-danger">Không hoạt động</span>
                            @endif
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Ngày tạo</label>
                        <p class="form-control-static">{{ $user->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                    <div class="form-group">
                        <label>Ngày cập nhật</label>
                        <p class="form-control-static">{{ $user->updated_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
