<?php

namespace App\Filament\Resources\ShipmentPermitResource\Pages;

use App\Filament\Resources\ShipmentPermitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShipmentPermits extends ListRecords
{
    protected static string $resource = ShipmentPermitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
