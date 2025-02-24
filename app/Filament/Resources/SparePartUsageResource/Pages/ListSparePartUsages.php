<?php

namespace App\Filament\Resources\SparePartUsageResource\Pages;

use App\Filament\Resources\SparePartUsageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSparePartUsages extends ListRecords
{
    protected static string $resource = SparePartUsageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
