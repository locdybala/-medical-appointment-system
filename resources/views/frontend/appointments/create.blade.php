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
                    <select name="specialty_id" id="specialty_id" class="form-select">
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
                    <label for="room_id">Phòng khám</label>
                    <select name="room_id" id="room_id" class="form-select">
                        <option value="">Chọn phòng khám</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}"
                                @if(isset($doctor) && $doctor->room_id == $room->id) selected @endif>
                                {{ $room->name }} - {{ $room->floor }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 form-group mt-3 mt-md-0">
                    <label for="doctor_id">Bác sĩ</label>
                    <select name="doctor_id" id="doctor_id" class="form-select" required disabled>
                        <option value="">Chọn bác sĩ</option>
                        @if(isset($doctor))
                            <option value="{{ $doctor->id }}" selected>{{ $doctor->user->name }}</option>
                        @endif
                    </select>
                    <div id="no-doctors-message" class="text-danger mt-2" style="display: none;">
                        Không tìm thấy bác sĩ phù hợp
                    </div>
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
$(document).ready(function() {
    // Khởi tạo các biến jQuery
    const $specialtySelect = $('#specialty_id');
    const $roomSelect = $('#room_id');
    const $doctorSelect = $('#doctor_id');
    const $dateInput = $('#appointment_date');
    const $slotsContainer = $('#available_slots');
    const $doctorInfo = $('.doctor-info');
    const $appointmentTimeInput = $('#appointment_time');
    const $submitButton = $('#submitButton');
    const $noDoctorsMessage = $('#no-doctors-message');

    // ===== EVENT HANDLERS =====
    
    // Xử lý khi chọn chuyên khoa
    $specialtySelect.on('change', loadRooms);

    // Xử lý khi chọn phòng khám
    $roomSelect.on('change', loadDoctors);

    // Xử lý khi chọn bác sĩ
    $doctorSelect.on('change', handleDoctorChange);

    // Xử lý khi chọn ngày khám
    $dateInput.on('change', handleDateChange);

    // ===== MAIN FUNCTIONS =====

    /**
     * Load danh sách phòng khám theo chuyên khoa
     */
    async function loadRooms() {
        const specialtyId = $specialtySelect.val();
        
        // Reset form
        resetForm();
        $roomSelect.html('<option value="">Chọn phòng khám</option>');
        $doctorSelect.html('<option value="">Chọn bác sĩ</option>').prop('disabled', true);

        if (!specialtyId) return;

        try {
            const response = await $.ajax({
                url: `/frontend/specialties/${specialtyId}/rooms`,
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.success) {
                throw new Error(response.message || 'Không thể lấy danh sách phòng khám');
            }

            const rooms = response.data || [];

            if (rooms.length === 0) {
                $noDoctorsMessage.show().text('Không có phòng khám nào cho chuyên khoa này');
                return;
            }

            // Thêm các option phòng khám
            rooms.forEach(room => {
                $roomSelect.append(new Option(`${room.name} - ${room.floor}`, room.id, false, false));
            });

            $roomSelect.prop('disabled', false);
            $noDoctorsMessage.hide();
        } catch (error) {
            console.error('Error:', error);
            $noDoctorsMessage.show().text(error.message || 'Không thể lấy danh sách phòng khám. Vui lòng thử lại sau.');
        }
    }

    /**
     * Load danh sách bác sĩ theo phòng khám
     */
    async function loadDoctors() {
        const roomId = $roomSelect.val();
        
        // Reset form
        $doctorSelect.html('<option value="">Chọn bác sĩ</option>');
        $doctorInfo.hide();
        $dateInput.prop('disabled', true).val('');
        $slotsContainer.empty();
        $appointmentTimeInput.val('');
        $submitButton.prop('disabled', true);

        if (!roomId) return;

        try {
            const response = await $.ajax({
                url: `/frontend/rooms/${roomId}/doctors`,
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.success) {
                throw new Error(response.message || 'Không thể lấy danh sách bác sĩ');
            }

            const doctors = response.data || [];

            if (doctors.length === 0) {
                $noDoctorsMessage.show().text('Không có bác sĩ nào trong phòng khám này');
                return;
            }

            // Thêm các option bác sĩ
            doctors.forEach(doctor => {
                $doctorSelect.append(new Option(doctor.user.name, doctor.id, false, false));
            });

            $doctorSelect.prop('disabled', false);
            $noDoctorsMessage.hide();
        } catch (error) {
            console.error('Error:', error);
            $noDoctorsMessage.show().text(error.message || 'Không thể lấy danh sách bác sĩ. Vui lòng thử lại sau.');
        }
    }

    /**
     * Xử lý khi chọn bác sĩ
     */
    async function handleDoctorChange() {
        const selectedOption = $(this).find('option:selected');
        
        if (!selectedOption.val()) {
            resetForm();
            return;
        }

        try {
            const doctorId = selectedOption.val();
            const response = await $.ajax({
                url: `/frontend/doctors/${doctorId}`,
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.success) {
                throw new Error(response.message || 'Không thể lấy thông tin bác sĩ');
            }

            const doctor = response.data;

            if (!doctor) {
                throw new Error('Không tìm thấy thông tin bác sĩ');
            }

            // Hiển thị thông tin bác sĩ
            displayDoctorInfo(doctor);

            // Reset form để chọn ngày khám
            resetDateSelection();
        } catch (error) {
            console.error('Error:', error);
            $noDoctorsMessage.show().text(error.message || 'Không thể lấy thông tin bác sĩ. Vui lòng thử lại sau.');
        }
    }

    /**
     * Hiển thị thông tin bác sĩ và phí khám
     */
    function displayDoctorInfo(doctor) {
        // Hiển thị thông tin cơ bản
        $doctorInfo.show();
        $doctorInfo.find('.doctor-name').text(doctor.user.name);
        $doctorInfo.find('.doctor-specialty').text(doctor.specialty.name);
        $doctorInfo.find('.doctor-experience').text(`${doctor.experience} năm kinh nghiệm`);

        // Hiển thị phí khám
        const fee = parseInt(doctor.consultation_fee);
        const feeDisplay = fee > 0
            ? `${fee.toLocaleString('vi-VN')} VNĐ`
            : 'Thanh toán sau';

        $doctorInfo.find('.consultation-fee').val(feeDisplay);
        $('.consultation-fee-summary').text(feeDisplay);
        $('.total-fee').text(feeDisplay);
    }

    /**
     * Reset form để chọn ngày khám
     */
    function resetDateSelection() {
        $dateInput.prop('disabled', false).val('');
        $slotsContainer.empty();
        $appointmentTimeInput.val('');
    }

    /**
     * Xử lý khi chọn ngày khám
     */
    async function handleDateChange() {
        const doctorId = $doctorSelect.val();
        const date = $(this).val();
        
        // Reset form
        $slotsContainer.empty();
        $appointmentTimeInput.val('');
        $submitButton.prop('disabled', true);

        if (!doctorId || !date) return;

        try {
            const response = await $.ajax({
                url: `/frontend/doctors/${doctorId}/available-slots`,
                method: 'GET',
                data: { date: date },
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.success) {
                throw new Error(response.message || 'Không thể lấy danh sách giờ khám');
            }

            const slots = response.data || [];

            if (slots.length === 0) {
                $slotsContainer.html('<div class="alert alert-info">Không có giờ khám nào trong ngày này</div>');
                return;
            }

            // Hiển thị các slot giờ khám
            displayTimeSlots(slots);
        } catch (error) {
            console.error('Error:', error);
            $slotsContainer.html(`<div class="alert alert-danger">${error.message || 'Không thể lấy danh sách giờ khám'}</div>`);
        }
    }

    /**
     * Hiển thị các slot giờ khám
     */
    function displayTimeSlots(slots) {
        slots.forEach(slot => {
            const $button = $('<button>', {
                type: 'button',
                class: 'btn btn-outline-primary m-1 time-slot',
                text: slot
            }).on('click', function() {
                $('.time-slot').removeClass('active');
                $(this).addClass('active');
                $appointmentTimeInput.val(slot);
                $submitButton.prop('disabled', false);
            });
            $slotsContainer.append($button);
        });
    }

    /**
     * Reset form về trạng thái ban đầu
     */
    function resetForm() {
        $doctorSelect.html('<option value="">Chọn bác sĩ</option>').prop('disabled', true);
        $doctorInfo.hide();
        $dateInput.prop('disabled', true).val('');
        $appointmentTimeInput.val('');
        $slotsContainer.empty();
        $submitButton.prop('disabled', true);
        $('.consultation-fee-summary, .total-fee').text('0 VNĐ');
        $noDoctorsMessage.hide();
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
