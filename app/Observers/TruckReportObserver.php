<?php

namespace App\Observers;

use App\Models\User;
use App\Models\TruckReport;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Illuminate\Support\Facades\Auth;

class TruckReportObserver
{
    /**
     * Handle the TruckReport "created" event.
     */
    public function created(TruckReport $truckReport): void
    {
        //
    }

    /**
     * Handle the TruckReport "updated" event.
     */
    public function updated(TruckReport $truckReport): void
    {
        //if the report's approval_status is changed to approved
        if ($truckReport->isDirty('approval_status') && $truckReport->approval_status === 'approved') {
            $driver = User::find($truckReport->driver_id);
            $admin = Auth::user();
            
            Notification::make()
                ->title('Truck Report Approved')
                ->success()
                ->body('Your truck report has been approved')
                ->actions([
                    Action::make('view')
                        ->button()
                        ->markAsRead(),
                ])
                ->sendToDatabase($driver);
                

            // //send to admin who approved the report
            Notification::make()
                ->title('Truck Report Approved')
                ->success()
                ->body('You have approved a truck report')
                ->actions([
                    Action::make('view')
                        ->button()
                        ->markAsRead(),
                ])
                ->sendToDatabase($admin)
                ->getDatabaseMessage();
        }
        elseif ($truckReport->isDirty('approval_status') && $truckReport->approval_status === 'rejected') {
            $driver = User::find($truckReport->driver_id);
            $admin = Auth::user();
            
            Notification::make()
                ->title('Truck Report Rejected')
                ->danger()
                ->body('Your truck report has been rejected')
                ->actions([
                    Action::make('view')
                        ->button()
                        ->markAsRead(),
                ])
                ->sendToDatabase($driver);
                

            // //send to admin who approved the report
            Notification::make()
                ->title('Truck Report Rejected')
                ->danger()
                ->body('You have rejected a truck report')
                ->actions([
                    Action::make('view')
                        ->button()
                        ->markAsRead(),
                ])
                ->sendToDatabase($admin)
                ->getDatabaseMessage();
        }
    }

    /**
     * Handle the TruckReport "deleted" event.
     */
    public function deleted(TruckReport $truckReport): void
    {
        //
    }

    /**
     * Handle the TruckReport "restored" event.
     */
    public function restored(TruckReport $truckReport): void
    {
        //
    }

    /**
     * Handle the TruckReport "force deleted" event.
     */
    public function forceDeleted(TruckReport $truckReport): void
    {
        //
    }
}
