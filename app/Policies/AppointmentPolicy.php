<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the appointment.
     */
    public function view(Patient $patient, Appointment $appointment): bool
    {
        return $patient->id === $appointment->patient_id;
    }

    /**
     * Determine whether the user can delete the appointment.
     */
    public function delete(Patient $patient, Appointment $appointment): bool
    {
        return $patient->id === $appointment->patient_id && $appointment->status === 'pending';
    }
}
