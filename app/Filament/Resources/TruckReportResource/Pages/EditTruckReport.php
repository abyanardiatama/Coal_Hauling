<?php

namespace App\Filament\Resources\TruckReportResource\Pages;

use App\Filament\Resources\TruckReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTruckReport extends EditRecord
{
    protected static string $resource = TruckReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
