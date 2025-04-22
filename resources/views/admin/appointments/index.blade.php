@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý lịch hẹn</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary float-right">
                    <i class="fas fa-plus"></i> Thêm lịch hẹn mới
                </a>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <table id="appointments-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Bệnh nhân</th>
                            <th>Bác sĩ</th>
                            <th>Ngày hẹn</th>
                            <th>Giờ hẹn</th>
                            <th>Trạng thái</th>
                            <th>Phí khám</th>
                            <th>Thanh toán</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->id }}</td>
                                <td>{{ $appointment->patient->name }}</td>
                                <td>{{ $appointment->doctor->name }}</td>
                                <td>{{ $appointment->appointment_date->format('d/m/Y') }}</td>
                                <td>{{ $appointment->appointment_time }}</td>
                                <td>{!! $appointment->status_badge !!}</td>
                                <td>{{ number_format($appointment->fee, 0, ',', '.') }} VNĐ</td>
                                <td>
                                    @if($appointment->is_paid)
                                        <span class="badge badge-success">Đã thanh toán</span>
                                    @else
                                        <span class="badge badge-danger">Chưa thanh toán</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
                                            Thao tác
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.appointments.edit', $appointment) }}">
                                                <i class="fas fa-edit"></i> Chỉnh sửa
                                            </a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#statusModal{{ $appointment->id }}">
                                                <i class="fas fa-sync"></i> Cập nhật trạng thái
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa lịch hẹn này?')">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Status Update Modal -->
                                    <div class="modal fade" id="statusModal{{ $appointment->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.appointments.update-status', $appointment) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Cập nhật trạng thái lịch hẹn</h5>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Trạng thái</label>
                                                            <select name="status" class="form-control" required>
                                                                <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                                                                <option value="approved" {{ $appointment->status == 'approved' ? 'selected' : '' }}>Đã xác nhận</option>
                                                                <option value="rejected" {{ $appointment->status == 'rejected' ? 'selected' : '' }}>Đã từ chối</option>
                                                                <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Đã hoàn thành</option>
                                                                <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                                                <option value="no_show" {{ $appointment->status == 'no_show' ? 'selected' : '' }}>Không đến</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(function () {
        $('#appointments-table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json"
            }
        });
    });
</script>
@endpush 