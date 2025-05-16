@extends('adminlte::page')

@section('title', 'Lịch khám của tôi')

@section('content_header')
    <h1>Lịch khám của tôi</h1>
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

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Ngày khám</th>
                            <th>Giờ khám</th>
                            <th>Bệnh nhân</th>
                            <th>Triệu chứng</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->appointment_date->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                                <td>
                                    {{ $appointment->patient->name }}<br>
                                    <small class="text-muted">{{ $appointment->patient->phone }}</small>
                                </td>
                                <td>{{ Str::limit($appointment->symptoms, 50) }}</td>
                                <td>
                                    @switch($appointment->status)
                                        @case('pending')
                                            <span class="badge badge-warning">Chờ xác nhận</span>
                                            @break
                                        @case('confirmed')
                                            <span class="badge badge-success">Đã xác nhận</span>
                                            @break
                                        @case('completed')
                                            <span class="badge badge-info">Đã hoàn thành</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge badge-danger">Đã hủy</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{ route('admin.appointments.show', $appointment) }}" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($appointment->status === 'pending')
                                        <form action="{{ route('admin.appointments.update', $appointment) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Không có lịch khám nào</td>
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
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json"
                }
            });
        });
    </script>
@stop 