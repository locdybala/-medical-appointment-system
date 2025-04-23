@extends('frontend.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <h2 class="mb-4">Liên hệ với chúng tôi</h2>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Họ và tên</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Tiêu đề</label>
                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" required>
                    @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Nội dung</label>
                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Gửi liên hệ</button>
            </form>
        </div>
        <div class="col-md-6">
            <h2 class="mb-4">Thông tin liên hệ</h2>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Địa chỉ</h5>
                    <p class="card-text">123 Đường ABC, Quận XYZ, Thành phố Hồ Chí Minh</p>
                    
                    <h5 class="card-title mt-4">Điện thoại</h5>
                    <p class="card-text">(84) 123 456 789</p>
                    
                    <h5 class="card-title mt-4">Email</h5>
                    <p class="card-text">info@medical-appointment.com</p>
                    
                    <h5 class="card-title mt-4">Giờ làm việc</h5>
                    <p class="card-text">
                        Thứ 2 - Thứ 6: 8:00 - 17:00<br>
                        Thứ 7: 8:00 - 12:00<br>
                        Chủ nhật: Nghỉ
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 