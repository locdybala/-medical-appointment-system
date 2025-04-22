@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Chỉnh sửa bài viết</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-default float-right">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" 
                            class="form-control @error('title') is-invalid @enderror" 
                            value="{{ old('title', $post->title) }}" required>
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="category_id">Danh mục</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Chọn danh mục</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="featured_image">Ảnh đại diện</label>
                        @if($post->featured_image)
                            <div class="mb-2">
                                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" 
                                    style="max-width: 200px; max-height: 200px;">
                            </div>
                        @endif
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="featured_image" id="featured_image" 
                                    class="custom-file-input @error('featured_image') is-invalid @enderror">
                                <label class="custom-file-label" for="featured_image">Chọn ảnh mới</label>
                            </div>
                        </div>
                        @error('featured_image')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted">
                            Định dạng: jpeg, png, jpg, gif. Kích thước tối đa: 2MB
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="content">Nội dung <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" rows="10" 
                            class="form-control @error('content') is-invalid @enderror" required>{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="meta_title">Meta Title</label>
                                <input type="text" name="meta_title" id="meta_title" 
                                    class="form-control @error('meta_title') is-invalid @enderror" 
                                    value="{{ old('meta_title', $post->meta_title) }}">
                                @error('meta_title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="meta_description">Meta Description</label>
                                <textarea name="meta_description" id="meta_description" rows="2" 
                                    class="form-control @error('meta_description') is-invalid @enderror">{{ old('meta_description', $post->meta_description) }}</textarea>
                                @error('meta_description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="is_published" id="is_published" 
                                class="custom-control-input" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_published">Xuất bản ngay</label>
                        </div>
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

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(function() {
        // Initialize summernote
        $('#content').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        // Initialize select2
        $('#category_id').select2({
            theme: 'bootstrap4'
        });

        // Show file name when file is selected
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });
</script>
@endpush 