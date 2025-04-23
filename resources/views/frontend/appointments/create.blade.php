@extends('frontend.layouts.app')

@section('content')
<section class="appointment">
    <div class="container">
        <div class="section-title">
            <h2>Đặt lịch khám</h2>
            <p>Đặt lịch khám với bác sĩ của chúng tôi</p>
        </div>

        <form action="{{ route('appointments.store') }}" method="POST" class="php-email-form">
            @csrf
            <div class="row">
                <!-- Bước 1: Chọn chuyên khoa và bác sĩ -->
                <div class="col-md-4 form-group">
                    <label for="specialty_id">Chuyên khoa</label>
                    <select name="specialty_id" id="specialty_id" class="form-select">
                        <option value="">Chọn chuyên khoa</option>
                        @foreach($specialties as $specialty)
                            <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 form-group mt-3 mt-md-0">
                    <label for="doctor_id">Bác sĩ</label>
                    <select name="doctor_id" id="doctor_id" class="form-select">
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
                    <input type="date" name="appointment_date" class="form-control" id="appointment_date" min="{{ date('Y-m-d') }}">
                </div>

                <div class="col-md-4 form-group mt-3">
                    <label>Giờ khám có sẵn</label>
                    <div id="available_slots" class="time-slots">
                        <!-- Các slot giờ sẽ được thêm vào đây bằng JavaScript -->
                    </div>
                </div>

                <!-- Bước 3: Thông tin bệnh nhân -->
                <div class="col-md-12 form-group mt-3">
                    <label for="symptoms">Triệu chứng/Lý do khám</label>
                    <textarea class="form-control" name="symptoms" rows="3" placeholder="Mô tả triệu chứng của bạn"></textarea>
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
                        <button type="submit" class="btn btn-primary">Xác nhận đặt lịch</button>
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

    // Khi chọn chuyên khoa
    specialtySelect.addEventListener('change', async function() {
        const specialtyId = this.value;
        if (!specialtyId) {
            doctorSelect.innerHTML = '<option value="">Vui lòng chọn chuyên khoa trước</option>';
            return;
        }

        // Lấy danh sách bác sĩ theo chuyên khoa
        const response = await fetch(`/api/specialties/${specialtyId}/doctors`);
        const doctors = await response.json();

        doctorSelect.innerHTML = '<option value="">Chọn bác sĩ</option>';
        doctors.forEach(doctor => {
            doctorSelect.innerHTML += `<option value="${doctor.id}">${doctor.name}</option>`;
        });
    });

    // Khi chọn bác sĩ
    doctorSelect.addEventListener('change', async function() {
        const doctorId = this.value;
        if (!doctorId) {
            doctorInfo.style.display = 'none';
            return;
        }

        // Lấy thông tin bác sĩ
        const response = await fetch(`/api/doctors/${doctorId}`);
        const doctor = await response.json();

        // Hiển thị thông tin bác sĩ
        doctorInfo.style.display = 'block';
        doctorInfo.querySelector('.doctor-name').textContent = doctor.name;
        doctorInfo.querySelector('.doctor-specialty').textContent = doctor.specialty.name;
        doctorInfo.querySelector('.doctor-experience').textContent = `${doctor.experience} năm kinh nghiệm`;
        doctorInfo.querySelector('.consultation-fee').textContent = `Phí khám: ${doctor.consultation_fee} VNĐ`;
        
        // Cập nhật tổng chi phí
        document.querySelector('.consultation-fee-summary').textContent = `${doctor.consultation_fee} VNĐ`;
        document.querySelector('.total-fee').textContent = `${doctor.consultation_fee} VNĐ`;

        // Reset và enable date input
        dateInput.value = '';
        dateInput.disabled = false;
    });

    // Khi chọn ngày
    dateInput.addEventListener('change', async function() {
        const doctorId = doctorSelect.value;
        const date = this.value;
        if (!doctorId || !date) return;

        // Lấy các slot trống của bác sĩ
        const response = await fetch(`/api/doctors/${doctorId}/available-slots?date=${date}`);
        const slots = await response.json();

        // Hiển thị các slot trống
        slotsContainer.innerHTML = '';
        slots.forEach(slot => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'btn btn-outline-primary m-1';
            button.textContent = slot.time;
            button.onclick = function() {
                // Bỏ chọn các slot khác
                slotsContainer.querySelectorAll('.btn').forEach(btn => btn.classList.remove('active'));
                // Chọn slot này
                this.classList.add('active');
                // Cập nhật giờ đã chọn
                document.querySelector('input[name="appointment_time"]').value = slot.time;
            };
            slotsContainer.appendChild(button);
        });

        if (slots.length === 0) {
            slotsContainer.innerHTML = '<p class="text-danger">Không có giờ khám trống trong ngày này</p>';
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