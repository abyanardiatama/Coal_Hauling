<?php

namespace App\Policies;

use App\Models\TrainingUser;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class TrainingUserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'driver') {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TrainingUser $trainingUser): bool
    {
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'driver') {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'driver') {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TrainingUser $trainingUser): bool
    {
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'driver') {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TrainingUser $trainingUser): bool
    {
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'driver') {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TrainingUser $trainingUser): bool
    {
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'driver') {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TrainingUser $trainingUser): bool
    {
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'driver') {
            return true;
        }
        return false;
    }
}
