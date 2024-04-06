<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\Review;
use Illuminate\Auth\Access\Response;

class ReviewPolicy
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
    public function view(Patient $patient, Review $review): bool
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
    public function update(Patient $patient, Review $review): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Patient $patient, Review $review): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Patient $patient, Review $review): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Patient $patient, Review $review): bool
    {
        //
    }
}
