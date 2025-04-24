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
                            <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 form-group mt-3 mt-md-0">
                    <label for="doctor_id">Bác sĩ</label>
                    <select name="doctor_id" id="doctor_id" class="form-select" disabled required>
                        <option value="">Vui lòng chọn chuyên khoa trước</option>
                    </select>
                </div>

                <!-- Thông tin bác sĩ -->
                <div class="col-md-4 doctor-info" style="display: none;">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="doctor-name"></h5>
                            <p class="doctor-specialty"></p>
                            <p class="doctor-experience"></p>
                            <p class="consultation-fee"></p>
                        </div>
                    </div>
                </div>

                <!-- Bước 2: Chọn ngày và giờ khám -->
                <div class="col-md-4 form-group mt-3">
                    <label for="appointment_date">Ngày khám</label>
                    <input type="date" name="appointment_date" class="form-control" id="appointment_date" min="{{ date('Y-m-d') }}" disabled required>
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
                                    <td class="consultation-fee-summary">0 VNĐ</td>
                                </tr>
                                <tr>
                                    <th>Tổng cộng</th>
                                    <th class="total-fee">0 VNĐ</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" id="submitButton" disabled>Xác nhận đặt lịch</button>
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
            const response = await fetch(`/specialties/${specialtySelect.value}/doctors`);
            const doctors = await response.json();
            const doctor = doctors.find(d => d.id == doctorId);

            if (doctor) {
                // Hiển thị thông tin bác sĩ
                doctorInfo.style.display = 'block';
                doctorInfo.querySelector('.doctor-name').textContent = doctor.name;
                doctorInfo.querySelector('.doctor-specialty').textContent = doctor.specialty;
                doctorInfo.querySelector('.doctor-experience').textContent = `${doctor.experience} năm kinh nghiệm`;
                doctorInfo.querySelector('.consultation-fee').textContent = `Phí khám: ${doctor.consultation_fee} VNĐ`;
                
                // Cập nhật tổng chi phí
                document.querySelector('.consultation-fee-summary').textContent = `${doctor.consultation_fee} VNĐ`;
                document.querySelector('.total-fee').textContent = `${doctor.consultation_fee} VNĐ`;

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

            // Lấy danh sách giờ khám có sẵn
            const response = await fetch(`/appointments/available-slots?doctor_id=${doctorId}&date=${date}`);
            const data = await response.json();

            if (data.success) {
                slotsContainer.innerHTML = '';
                data.slots.forEach(slot => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'btn btn-outline-primary m-1 time-slot';
                    button.textContent = slot.display;
                    button.dataset.time = slot.time;
                    button.addEventListener('click', function() {
                        // Xóa active class từ tất cả các button
                        document.querySelectorAll('.time-slot').forEach(btn => {
                            btn.classList.remove('active');
                        });
                        // Thêm active class cho button được chọn
                        this.classList.add('active');
                        // Cập nhật giá trị cho input ẩn
                        appointmentTimeInput.value = this.dataset.time;
                        submitButton.disabled = false;
                    });
                    slotsContainer.appendChild(button);
                });
            } else {
                slotsContainer.innerHTML = `<div class="alert alert-warning">${data.message}</div>`;
            }
        } catch (error) {
            console.error('Error fetching available slots:', error);
            slotsContainer.innerHTML = '<div class="alert alert-danger">Có lỗi xảy ra khi lấy danh sách giờ khám</div>';
        }
    });

    // Validate form trước khi submit
    appointmentForm.addEventListener('submit', function(e) {
        if (!appointmentTimeInput.value) {
            e.preventDefault();
            alert('Vui lòng chọn giờ khám');
            return;
        }

        // Kiểm tra xem slot đã chọn có còn trống không
        const selectedSlot = slotsContainer.querySelector('.btn.active');
        if (!selectedSlot) {
            e.preventDefault();
            alert('Vui lòng chọn giờ khám');
            return;
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