@extends('frontend.layouts.app')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Đăng ký</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">Đăng ký</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Register Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8 wow fadeInUp mx-auto" data-wow-delay="0.1s">
                    <div class="bg-light rounded h-100 d-flex align-items-center p-5">
                        <form method="POST" action="{{ route('register.post') }}" class="w-100">
                            @csrf
                            <h2 class="text-center mb-4">Đăng ký tài khoản</h2>

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-0" id="name" name="name" placeholder="Họ và tên" value="{{ old('name') }}" required>
                                        <label for="name">Họ và tên</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control border-0" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control border-0" id="phone" name="phone" placeholder="Số điện thoại" value="{{ old('phone') }}" required>
                                        <label for="phone">Số điện thoại</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-0" id="address" name="address" placeholder="Địa chỉ" value="{{ old('address') }}" required>
                                        <label for="address">Địa chỉ</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control border-0" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                        <label for="date_of_birth">Ngày sinh</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select border-0" id="gender" name="gender" required>
                                            <option value="">Chọn giới tính</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác</option>
                                        </select>
                                        <label for="gender">Giới tính</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" class="form-control border-0" id="password" name="password" placeholder="Mật khẩu" required>
                                        <label for="password">Mật khẩu</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" class="form-control border-0" id="password_confirmation" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
                                        <label for="password_confirmation">Xác nhận mật khẩu</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Đăng ký</button>
                                </div>
                                <div class="col-12 text-center">
                                    <p class="mb-0">Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register End -->
@endsection
