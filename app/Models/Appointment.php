<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'schedule_id',
        'appointment_date',
        'appointment_time',
        'status',
        'reason',
        'notes',
        'prescription',
        'diagnosis',
        'fee',
        'is_paid',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
        'is_paid' => 'boolean',
        'fee' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'approved' => 'info',
            'rejected' => 'danger',
            'completed' => 'success',
            'cancelled' => 'secondary',
            'no_show' => 'dark',
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function getStatusTextAttribute()
    {
        $texts = [
            'pending' => 'Chờ xác nhận',
            'approved' => 'Đã xác nhận',
            'rejected' => 'Đã từ chối',
            'completed' => 'Đã hoàn thành',
            'cancelled' => 'Đã hủy',
            'no_show' => 'Không đến',
        ];

        return $texts[$this->status] ?? 'Không xác định';
    }
} 