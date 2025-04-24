@extends('frontend.layouts.app')

@section('content')
<section class="appointment">
    <div class="container">
        <div class="section-title">
            <h2>Đặt lịch khám</h2>
            <p>Đặt lịch khám với bác sĩ của chúng tôi</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <form action="{{ route('appointments.store') }}" method="POST" class="php-email-form" id="appointmentForm">
            @csrf
            <div class="row">
                <!-- Bước 1: Chọn chuyên khoa và bác sĩ -->
                <div class="col-md-4 form-group">
                    <label for="specialty_id">Chuyên khoa</label>
                    <select name="specialty_id" id="specialty_id" class="form-select" required>
                        <option value="">Chọn chuyên khoa</option>
                        @foreach($specialties as $specialty)
                            <option value="{{ $specialty->id }}"
                                @if(isset($doctor) && $doctor->specialty_id == $specialty->id) selected @endif>
                                {{ $specialty->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 form-group mt-3 mt-md-0">
                    <label for="doctor_id">Bác sĩ</label>
                    <select name="doctor_id" id="doctor_id" class="form-select" required>
                        <option value="">Chọn bác sĩ</option>
                        @if(isset($doctor))
                            <option value="{{ $doctor->id }}" selected>{{ $doctor->user->name }}</option>
                        @endif
                    </select>
                </div>

                <!-- Thông tin bác sĩ -->
                <div class="col-md-4 doctor-info" @if(isset($doctor)) style="display: block;" @else style="display: none;" @endif>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="doctor-name">@if(isset($doctor)) {{ $doctor->user->name }} @endif</h5>
                            <p class="doctor-specialty">@if(isset($doctor)) {{ $doctor->specialty->name }} @endif</p>
                            <p class="doctor-experience">@if(isset($doctor)) {{ $doctor->experience }} năm kinh nghiệm @endif</p>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phí khám</label>
                                    <input type="text" class="form-control" value="{{ $doctor->consultation_fee > 0 ? number_format($doctor->consultation_fee, 0, ',', '.') . ' VNĐ' : 'Thanh toán sau' }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bước 2: Chọn ngày và giờ khám -->
                <div class="col-md-4 form-group mt-3">
                    <label for="appointment_date">Ngày khám</label>
                    <input type="date" name="appointment_date" class="form-control" id="appointment_date"
                           min="{{ date('Y-m-d') }}"
                           @if(isset($doctor)) disabled @endif
                           required>
                </div>

                <div class="col-md-4 form-group mt-3">
                    <label>Giờ khám có sẵn</label>
                    <div id="available_slots" class="time-slots">
                        <!-- Các slot giờ sẽ được thêm vào đây bằng JavaScript -->
                    </div>
                    <input type="hidden" name="appointment_time" id="appointment_time" required>
                    <div class="invalid-feedback">Vui lòng chọn giờ khám</div>
                </div>

                <!-- Bước 3: Thông tin bệnh nhân -->
                <div class="col-md-12 form-group mt-3">
                    <label for="symptoms">Triệu chứng/Lý do khám</label>
                    <textarea class="form-control" name="symptoms" rows="3" placeholder="Mô tả triệu chứng của bạn" required></textarea>
                </div>

                <!-- Tổng chi phí -->
                <div class="col-md-12 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Chi tiết thanh toán</h5>
                            <table class="table">
                                <tr>
                                    <td>Phí khám</td>
                                    <td class="consultation-fee-summary">@if(isset($doctor)) {{ $doctor->consultation_fee > 0 ? number_format($doctor->consultation_fee, 0, ',', '.') . ' VNĐ' : 'Thanh toán sau' }} @else 0 VNĐ @endif</td>
                                </tr>
                                <tr>
                                    <th>Tổng cộng</th>
                                    <th class="total-fee">@if(isset($doctor)) {{ $doctor->consultation_fee > 0 ? number_format($doctor->consultation_fee, 0, ',', '.') . ' VNĐ' : 'Thanh toán sau' }} @else 0 VNĐ @endif</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" id="submitButton" @if(!isset($doctor)) disabled @endif>Xác nhận đặt lịch</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const specialtySelect = document.getElementById('specialty_id');
    const doctorSelect = document.getElementById('doctor_id');
    const dateInput = document.getElementById('appointment_date');
    const slotsContainer = document.getElementById('available_slots');
    const doctorInfo = document.querySelector('.doctor-info');
    const appointmentTimeInput = document.getElementById('appointment_time');
    const submitButton = document.getElementById('submitButton');
    const appointmentForm = document.getElementById('appointmentForm');

    // Nếu đã có bác sĩ được chọn trước
    @if(isset($doctor))
        dateInput.disabled = false;
        submitButton.disabled = false;
    @endif

    // Khi chọn chuyên khoa
    specialtySelect.addEventListener('change', async function() {
        const specialtyId = this.value;
        if (!specialtyId) {
            doctorSelect.innerHTML = '<option value="">Vui lòng chọn chuyên khoa trước</option>';
            doctorSelect.disabled = true;
            return;
        }

        try {
            // Lấy danh sách bác sĩ theo chuyên khoa
            const response = await fetch(`/specialties/${specialtyId}/doctors`);
            const doctors = await response.json();

            doctorSelect.innerHTML = '<option value="">Chọn bác sĩ</option>';
            doctors.forEach(doctor => {
                doctorSelect.innerHTML += `<option value="${doctor.id}">${doctor.name}</option>`;
            });
            doctorSelect.disabled = false;
        } catch (error) {
            console.error('Error fetching doctors:', error);
        }
    });

    // Khi chọn bác sĩ
    doctorSelect.addEventListener('change', async function() {
        const doctorId = this.value;
        if (!doctorId) {
            doctorInfo.style.display = 'none';
            dateInput.disabled = true;
            dateInput.value = '';
            appointmentTimeInput.value = '';
            slotsContainer.innerHTML = '';
            submitButton.disabled = true;
            return;
        }

        try {
            // Lấy thông tin bác sĩ
            const response = await fetch(`/doctors/${doctorId}`);
            const doctor = await response.json();

            if (doctor) {
                // Hiển thị thông tin bác sĩ
                doctorInfo.style.display = 'block';
                doctorInfo.querySelector('.doctor-name').textContent = doctor.name;
                doctorInfo.querySelector('.doctor-specialty').textContent = doctor.specialty.name;
                doctorInfo.querySelector('.doctor-experience').textContent = `${doctor.experience} năm kinh nghiệm`;
                doctorInfo.querySelector('.consultation-fee').textContent = `Phí khám: ${doctor.consultation_fee.toLocaleString('vi-VN')} VNĐ`;

                // Cập nhật tổng chi phí
                document.querySelector('.consultation-fee-summary').textContent = `${doctor.consultation_fee.toLocaleString('vi-VN')} VNĐ`;
                document.querySelector('.total-fee').textContent = `${doctor.consultation_fee.toLocaleString('vi-VN')} VNĐ`;

                // Reset và enable date input
                dateInput.value = '';
                dateInput.disabled = false;
                appointmentTimeInput.value = '';
                slotsContainer.innerHTML = '';
                submitButton.disabled = true;
            }
        } catch (error) {
            console.error('Error fetching doctor details:', error);
        }
    });

    // Khi chọn ngày
    dateInput.addEventListener('change', async function() {
        const doctorId = doctorSelect.value;
        const date = this.value;
        if (!doctorId || !date) return;

        try {
            // Reset trạng thái
            slotsContainer.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            appointmentTimeInput.value = '';
            submitButton.disabled = true;

            // Lấy CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const headers = {
                'X-Requested-With': 'XMLHttpRequest'
            };

            if (csrfToken) {
                headers['X-CSRF-TOKEN'] = csrfToken;
            }

            // Lấy các slot giờ còn trống
            const response = await fetch(`/doctors/${doctorId}/available-slots?date=${date}`, {
                headers: headers
            });

            if (response.status === 401) {
                window.location.href = '/login';
                return;
            }

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || 'Không thể lấy danh sách giờ khám');
            }

            // Hiển thị các slot giờ
            slotsContainer.innerHTML = '';
            if (data.length === 0) {
                slotsContainer.innerHTML = '<div class="alert alert-warning">Không có giờ khám trống trong ngày này</div>';
                return;
            }

            data.forEach(slot => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'btn btn-outline-primary m-1 time-slot';
                button.textContent = `${slot} - ${parseInt(slot.split(':')[0]) + 1}:00`;
                button.onclick = function() {
                    // Xóa class active của các button khác
                    document.querySelectorAll('.time-slot').forEach(btn => btn.classList.remove('active'));
                    // Thêm class active cho button được chọn
                    this.classList.add('active');
                    // Cập nhật giá trị input ẩn
                    appointmentTimeInput.value = slot;
                    // Enable nút submit
                    submitButton.disabled = false;
                };
                slotsContainer.appendChild(button);
            });
        } catch (error) {
            console.error('Error fetching available slots:', error);
            slotsContainer.innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.time-slots {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}

.time-slots .btn {
    min-width: 80px;
}

.time-slots .btn.active {
    background-color: #007bff;
    color: white;
}

.doctor-info {
    transition: all 0.3s ease;
}
</style>
@endpush
@endsection
