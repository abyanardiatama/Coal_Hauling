<?php

namespace App\Observers;

use App\Models\SparePartUsage;

class SparePartUsageObserver
{
    /**
     * Handle the SparePartUsage "created" event.
     */
    public function created(SparePartUsage $sparePartUsage): void
    {
        // update the spare part stock if the spare part usage is created
        $sparePartUsage->sparePart->decrement('stock', $sparePartUsage->quantity_used);
    }

    /**
     * Handle the SparePartUsage "updated" event.
     */
    public function updated(SparePartUsage $sparePartUsage): void
    {
        //
    }

    /**
     * Handle the SparePartUsage "deleted" event.
     */
    public function deleted(SparePartUsage $sparePartUsage): void
    {
        //
    }

    /**
     * Handle the SparePartUsage "restored" event.
     */
    public function restored(SparePartUsage $sparePartUsage): void
    {
        //
    }

    /**
     * Handle the SparePartUsage "force deleted" event.
     */
    public function forceDeleted(SparePartUsage $sparePartUsage): void
    {
        //
    }
}
