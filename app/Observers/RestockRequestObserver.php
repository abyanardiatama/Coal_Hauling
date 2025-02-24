<?php

namespace App\Observers;

use App\Models\RestockRequest;

class RestockRequestObserver
{
    /**
     * Handle the RestockRequest "created" event.
     */
    public function created(RestockRequest $restockRequest): void
    {
        //
    }

    /**
     * Handle the RestockRequest "updated" event.
     */
    public function updated(RestockRequest $restockRequest): void
    {
        // Update the spare part stock if the restock request is approved
        if ($restockRequest->status === 'approved') {
            $restockRequest->sparePart->increment('stock', $restockRequest->requested_quantity);
        }
    }

    /**
     * Handle the RestockRequest "deleted" event.
     */
    public function deleted(RestockRequest $restockRequest): void
    {
        //
    }

    /**
     * Handle the RestockRequest "restored" event.
     */
    public function restored(RestockRequest $restockRequest): void
    {
        //
    }

    /**
     * Handle the RestockRequest "force deleted" event.
     */
    public function forceDeleted(RestockRequest $restockRequest): void
    {
        //
    }
}
