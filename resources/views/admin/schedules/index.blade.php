@extends('adminlte::page')

@section('title', 'Quản lý lịch khám')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Quản lý lịch khám</h1>
        <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm lịch khám
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

            <table id="schedules-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Bác sĩ</th>
                        <th>Ngày</th>
                        <th>Ca</th>
                        <th>Thời gian</th>
                        <th>Số bệnh nhân tối đa</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedules as $schedule)
                        <tr>
                            <td>{{ $schedule->id }}</td>
                            <td>{{ $schedule->doctor->name }}</td>
                            <td>{{ $schedule->date->format('d/m/Y') }}</td>
                            <td>
                                @if($schedule->shift == 'morning')
                                    <span class="badge badge-info">Buổi sáng</span>
                                @else
                                    <span class="badge badge-warning">Buổi chiều</span>
                                @endif
                            </td>
                            <td>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</td>
                            <td>{{ $schedule->max_patients }} người</td>
                            <td>
                                @if($schedule->is_available)
                                    <span class="badge badge-success">Có thể đặt</span>
                                @else
                                    <span class="badge badge-danger">Đã đầy</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger delete-schedule" data-id="{{ $schedule->id }}">
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
            $('#schedules-table').DataTable({
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

            // Xử lý xóa lịch khám với SweetAlert2
            $('.delete-schedule').click(function() {
                const form = $(this).closest('form');
                const scheduleId = $(this).data('id');

                Swal.fire({
                    title: 'Xác nhận xóa?',
                    text: "Bạn có chắc chắn muốn xóa lịch khám này không?",
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