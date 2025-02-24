<?php

namespace App\Observers;

use App\Models\TrainingUser;
use Filament\Notifications\Notification;

class TrainingUserObserver
{
    /**
     * Handle the TrainingUser "created" event.
     */
    public function created(TrainingUser $trainingUser): void
    {
        //
    }

    /**
     * Handle the TrainingUser "updated" event.
     */
    public function updated(TrainingUser $trainingUser): void
    {
        //
    }

    /**
     * Handle the TrainingUser "deleted" event.
     */
    public function deleted(TrainingUser $trainingUser): void
    {
        //
    }

    /**
     * Handle the TrainingUser "restored" event.
     */
    public function restored(TrainingUser $trainingUser): void
    {
        //
    }

    /**
     * Handle the TrainingUser "force deleted" event.
     */
    public function forceDeleted(TrainingUser $trainingUser): void
    {
        //
    }
}
