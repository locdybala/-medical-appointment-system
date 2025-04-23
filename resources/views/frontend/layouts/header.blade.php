    <!-- Topbar Start -->
    <div class="container-fluid bg-light p-0">
        <div class="row gx-0 d-none d-lg-flex">
            <div class="col-lg-7 px-5 text-start">
                <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                    <small class="fa fa-map-marker-alt text-primary me-2"></small>
                    <small>123 Street, New York, USA</small>
                </div>
                <div class="h-100 d-inline-flex align-items-center py-3">
                    <small class="far fa-clock text-primary me-2"></small>
                    <small>Mon - Fri : 09.00 AM - 09.00 PM</small>
                </div>
            </div>
            <div class="col-lg-5 px-5 text-end">
                <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                    <small class="fa fa-phone-alt text-primary me-2"></small>
                    <small>+012 345 6789</small>
                </div>
                <div class="h-100 d-inline-flex align-items-center">
                    <small class="far fa-envelope text-primary me-2"></small>
                    <small>info@example.com</small>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0">
        <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h1 class="m-0 text-primary">Medical</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="{{ route('home') }}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Trang chủ</a>
                <a href="{{ route('about') }}" class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Giới thiệu</a>
                <a href="{{ route('specialties') }}" class="nav-item nav-link {{ request()->routeIs('specialties') ? 'active' : '' }}">Chuyên khoa</a>
                <a href="{{ route('doctors') }}" class="nav-item nav-link {{ request()->routeIs('doctors') ? 'active' : '' }}">Bác sĩ</a>
                <a href="{{ route('contact') }}" class="nav-item nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Liên hệ</a>
                
                @auth
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </a>
                        <div class="dropdown-menu fade-up m-0">
                            <a href="{{ route('appointments.history') }}" class="dropdown-item">Lịch sử đặt khám</a>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">Thông tin cá nhân</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Đăng xuất</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="nav-item nav-link">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="nav-item nav-link">Đăng ký</a>
                @endauth
            </div>
            @auth
                <a href="{{ route('appointment.create') }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Đặt lịch khám<i class="fa fa-arrow-right ms-3"></i></a>
            @else  
                <a href="{{ route('login') }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Đặt lịch khám<i class="fa fa-arrow-right ms-3"></i></a>
            @endauth
        </div>
    </nav>
    <!-- Navbar End -->