@extends('adminlte::page')

@section('title', 'Quản lý chuyên khoa')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Quản lý chuyên khoa</h1>
        <a href="{{ route('admin.specialties.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm chuyên khoa
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <table id="specialties-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Icon</th>
                        <th>Tên chuyên khoa</th>
                        <th>Mô tả</th>
                        <th>Số bác sĩ</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($specialties as $specialty)
                    <tr>
                        <td>{{ $specialty->id }}</td>
                        <td>
                            @if($specialty->icon)
                                <i class="{{ $specialty->icon }} fa-2x"></i>
                            @else
                                <i class="fas fa-stethoscope fa-2x text-secondary"></i>
                            @endif
                        </td>
                        <td>{{ $specialty->name }}</td>
                        <td>{{ $specialty->description }}</td>
                        <td>{{ $specialty->doctors->count() }}</td>
                        <td>
                            @if($specialty->is_active)
                                <span class="badge badge-success">Hoạt động</span>
                            @else
                                <span class="badge badge-danger">Không hoạt động</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.specialties.edit', $specialty) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.specialties.destroy', $specialty) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger delete-specialty" data-id="{{ $specialty->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/vendor/datatables-bs4/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
    <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#specialties-table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json"
                }
            });

            // Xử lý xóa chuyên khoa với SweetAlert2
            $('.delete-specialty').click(function() {
                const form = $(this).closest('form');
                const specialtyId = $(this).data('id');

                Swal.fire({
                    title: 'Xác nhận xóa?',
                    text: "Bạn có chắc chắn muốn xóa chuyên khoa này không?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý',
                    cancelButtonText: 'Hủy bỏ'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Hiển thị thông báo thành công
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: '{{ session('success') }}',
                    timer: 1500,
                    showConfirmButton: false
                });
            @endif

            // Hiển thị thông báo lỗi
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: '{{ session('error') }}',
                });
            @endif
        });
    </script>
@stop
