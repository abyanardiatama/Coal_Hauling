<?php

namespace App\Filament\Resources\ShipmentPermitResource\Pages;

use App\Filament\Resources\ShipmentPermitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShipmentPermit extends EditRecord
{
    protected static string $resource = ShipmentPermitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function mutateFormDataBeforeSave(array $data): array
    {
        // if file_path is not empty, then change shipment_status to approved
        if (!empty($data['file_path'])) {
            $data['shipment_status'] = 'approved';
        }
        return $data;
    }
}
