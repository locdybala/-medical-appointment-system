<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'specialty_id',
        'room_id',
        'qualification',
        'experience',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
