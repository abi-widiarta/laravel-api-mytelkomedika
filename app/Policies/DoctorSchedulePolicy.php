<?php

namespace App\Policies;

use App\Models\DoctorSchedule;
use App\Models\Patient;
use Illuminate\Auth\Access\Response;

class DoctorSchedulePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Patient $patient): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Patient $patient, DoctorSchedule $doctorSchedule): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Patient $patient): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Patient $patient, DoctorSchedule $doctorSchedule): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Patient $patient, DoctorSchedule $doctorSchedule): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Patient $patient, DoctorSchedule $doctorSchedule): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Patient $patient, DoctorSchedule $doctorSchedule): bool
    {
        //
    }
}
