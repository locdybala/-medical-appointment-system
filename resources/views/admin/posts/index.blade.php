@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý bài viết</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary float-right">
                    <i class="fas fa-plus"></i> Thêm bài viết mới
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
                <table id="posts-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ảnh đại diện</th>
                            <th>Tiêu đề</th>
                            <th>Danh mục</th>
                            <th>Tác giả</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>
                                    @if($post->featured_image)
                                        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" 
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('adminlte/dist/img/no-image.png') }}" alt="No image" 
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    @endif
                                </td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->category?->name ?? 'Không có danh mục' }}</td>
                                <td>{{ $post->user->name }}</td>
                                <td>
                                    @if($post->is_published)
                                        <span class="badge badge-success">Đã xuất bản</span>
                                    @else
                                        <span class="badge badge-warning">Bản nháp</span>
                                    @endif
                                </td>
                                <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
                                            Thao tác
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.posts.edit', $post) }}">
                                                <i class="fas fa-edit"></i> Chỉnh sửa
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </button>
                                            </form>
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
        $('#posts-table').DataTable({
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