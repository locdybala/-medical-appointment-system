@extends('frontend.layouts.app')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Đăng nhập</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">Đăng nhập</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Login Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp mx-auto" data-wow-delay="0.1s">
                    <div class="bg-light rounded h-100 d-flex align-items-center p-5">
                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf
                            <h2 class="text-center mb-4">Đăng nhập</h2>

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
                                        <input type="email" class="form-control border-0" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="password" class="form-control border-0" id="password" name="password" placeholder="Mật khẩu" required>
                                        <label for="password">Mật khẩu</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                        <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Đăng nhập</button>
                                </div>
                                <div class="col-12 text-center">
                                    <p class="mb-0">Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login End -->
@endsection
