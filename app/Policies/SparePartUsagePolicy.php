<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SparePartUsage;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class SparePartUsagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if (Auth::user()->role === 'admin') {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SparePartUsage $sparePartUsage): bool
    {
        if (Auth::user()->role === 'admin') {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if (Auth::user()->role === 'admin') {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SparePartUsage $sparePartUsage): bool
    {
        if (Auth::user()->role === 'admin') {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SparePartUsage $sparePartUsage): bool
    {
        if (Auth::user()->role === 'admin') {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SparePartUsage $sparePartUsage): bool
    {
        if (Auth::user()->role === 'admin') {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SparePartUsage $sparePartUsage): bool
    {
        if (Auth::user()->role === 'admin') {
            return true;
        }
        return false;
    }
}
