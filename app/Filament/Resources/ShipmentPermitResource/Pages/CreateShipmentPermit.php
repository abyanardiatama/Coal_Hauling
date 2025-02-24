<?php

namespace App\Filament\Resources\ShipmentPermitResource\Pages;

use Filament\Actions;
use App\Models\ShipmentPermit;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;
use App\Filament\Resources\ShipmentPermitResource;

class CreateShipmentPermit extends CreateRecord
{
    protected static string $resource = ShipmentPermitResource::class;

    //avoid assign driver_id and truck_id to the form on the same day
    protected function beforeCreate(): void
    {
        $data = $this->form->getState(); // Ambil data yang diinput

        // Cek permit_number
        $permitNumberExists = ShipmentPermit::where('permit_number', $data['permit_number'])->exists();
        if ($permitNumberExists) {
            Notification::make()
                ->title('Permit number already exists.')
                ->danger()
                ->send();

            $this->halt(); // Stop proses penyimpanan
        }
        // Cek apakah driver sudah memiliki jadwal di tanggal yang sama
        $driverConflict = ShipmentPermit::where('driver_id', $data['driver_id'])
            ->whereDate('shipment_date', $data['shipment_date'])
            ->exists();

        if ($driverConflict) {
            Notification::make()
                ->title('Driver already has a schedule on this date.')
                ->danger()
                ->send();

            $this->halt(); // Stop proses penyimpanan
        }

        // Cek apakah truk sudah memiliki jadwal di tanggal yang sama
        $truckConflict = ShipmentPermit::where('truck_id', $data['truck_id'])
            ->whereDate('shipment_date', $data['shipment_date'])
            ->exists();

        if ($truckConflict) {
            Notification::make()
                ->title('Truck already has a schedule on this date.')
                ->danger()
                ->send();

            $this->halt(); // Stop proses penyimpanan
        }
    }
}
