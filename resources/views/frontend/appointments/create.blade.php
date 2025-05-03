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
                    <div id="no-doctors-message" class="text-danger mt-2" style="display: none;">
                        Hiện tại không có bác sĩ nào trong chuyên khoa này
                    </div>
                </div>

                <div class="col-md-4 form-group mt-3 mt-md-0">
                    <label for="doctor_id">Bác sĩ</label>
                    <select name="doctor_id" id="doctor_id" class="form-select" required disabled>
                        <option value="">Chọn bác sĩ</option>
                        @if(isset($doctor))
                            <option value="{{ $doctor->id }}" selected>{{ $doctor->user->name }}</option>
                        @endif
                    </select>
                </div>

                <!-- Thông tin bác sĩ -->
                <div class="col-md-4 doctor-info" style="display: none;">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="doctor-name mb-3"></h5>
                            <p class="doctor-specialty mb-2"></p>
                            <p class="doctor-experience mb-3"></p>
                            <div class="form-group">
                                <label>Phí khám</label>
                                <input type="text" class="form-control consultation-fee" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bước 2: Chọn ngày và giờ khám -->
                <div class="col-md-4 form-group mt-3">
                    <label for="appointment_date">Ngày khám</label>
                    <input type="date" name="appointment_date" class="form-control" id="appointment_date"
                           min="{{ date('Y-m-d') }}"
                           disabled
                           required>
                </div>

                <div class="col-md-4 form-group mt-3">
                    <label>Giờ khám có sẵn</label>
                    <div id="available_slots" class="time-slots">
                        <!-- Các slot giờ sẽ được thêm vào đây bằng JavaScript -->
                    </div>
                    <input type="hidden" name="appointment_time" id="appointment_time" required>
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
    const noDoctorsMessage = document.getElementById('no-doctors-message');

    // Khi chọn chuyên khoa
    specialtySelect.addEventListener('change', async function() {
        const specialtyId = this.value;
        resetForm();

        if (!specialtyId) return;

        try {
            const response = await fetch(`/frontend/specialties/${specialtyId}/doctors`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();

            if (!data.success) {
                throw new Error(data.message || 'Không thể lấy danh sách bác sĩ');
            }

            const doctors = data.data || [];

            if (doctors.length === 0) {
                noDoctorsMessage.style.display = 'block';
                return;
            }

            doctors.forEach(doctor => {
                const option = document.createElement('option');
                option.value = doctor.id;
                option.textContent = doctor.user.name;
                option.dataset.name = doctor.user.name;
                option.dataset.specialty = doctor.specialty.name;
                option.dataset.experience = doctor.experience;
                option.dataset.fee = doctor.consultation_fee;
                doctorSelect.appendChild(option);
            });

            doctorSelect.disabled = false;
            noDoctorsMessage.style.display = 'none';
        } catch (error) {
            console.error('Error:', error);
            noDoctorsMessage.style.display = 'block';
            noDoctorsMessage.textContent = error.message || 'Không thể lấy danh sách bác sĩ. Vui lòng thử lại sau.';
        }
    });

    // Khi chọn bác sĩ
    doctorSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];

        if (!selectedOption.value) {
            resetForm();
            return;
        }

        // Hiển thị thông tin bác sĩ
        doctorInfo.style.display = 'block';
        doctorInfo.querySelector('.doctor-name').textContent = selectedOption.dataset.name;
        doctorInfo.querySelector('.doctor-specialty').textContent = selectedOption.dataset.specialty;
        doctorInfo.querySelector('.doctor-experience').textContent = `${selectedOption.dataset.experience} năm kinh nghiệm`;

        // Hiển thị phí khám
        const fee = parseInt(selectedOption.dataset.fee);
        const feeDisplay = fee > 0
            ? `${fee.toLocaleString('vi-VN')} VNĐ`
            : 'Thanh toán sau';

        doctorInfo.querySelector('.consultation-fee').value = feeDisplay;
        document.querySelector('.consultation-fee-summary').textContent = feeDisplay;
        document.querySelector('.total-fee').textContent = feeDisplay;

        // Enable date input
        dateInput.disabled = false;
        dateInput.value = '';
        slotsContainer.innerHTML = '';
        appointmentTimeInput.value = '';
    });

    // Khi chọn ngày
    dateInput.addEventListener('change', async function() {
        const doctorId = doctorSelect.value;
        const date = this.value;
        slotsContainer.innerHTML = '';
        appointmentTimeInput.value = '';
        submitButton.disabled = true;

        if (!doctorId || !date) return;

        try {
            const response = await fetch(`/frontend/doctors/${doctorId}/available-slots?date=${date}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();

            if (!data.success) {
                throw new Error(data.message || 'Không thể lấy danh sách giờ khám');
            }

            const slots = data.data || [];

            if (slots.length === 0) {
                slotsContainer.innerHTML = '<div class="alert alert-info">Không có giờ khám nào trong ngày này</div>';
                return;
            }

            slots.forEach(slot => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'btn btn-outline-primary m-1 time-slot';
                button.textContent = slot;
                button.onclick = function() {
                    document.querySelectorAll('.time-slot').forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    appointmentTimeInput.value = slot;
                    submitButton.disabled = false;
                };
                slotsContainer.appendChild(button);
            });
        } catch (error) {
            console.error('Error:', error);
            slotsContainer.innerHTML = `<div class="alert alert-danger">${error.message || 'Không thể lấy danh sách giờ khám'}</div>`;
        }
    });

    function resetForm() {
        doctorSelect.innerHTML = '<option value="">Chọn bác sĩ</option>';
        doctorSelect.disabled = true;
        doctorInfo.style.display = 'none';
        dateInput.disabled = true;
        dateInput.value = '';
        appointmentTimeInput.value = '';
        slotsContainer.innerHTML = '';
        submitButton.disabled = true;
        document.querySelector('.consultation-fee-summary').textContent = '0 VNĐ';
        document.querySelector('.total-fee').textContent = '0 VNĐ';
        noDoctorsMessage.style.display = 'none';
    }
});
</script>
@endpush

@push('styles')
<style>
.time-slots {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    margin-top: 10px;
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

.doctor-info .card {
    height: 100%;
}

.consultation-fee {
    background-color: #f8f9fa;
}
</style>
@endpush
@endsection
