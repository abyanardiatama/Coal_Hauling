<?php

namespace App\Filament\Resources\RestockRequestResource\Pages;

use App\Filament\Resources\RestockRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRestockRequests extends ListRecords
{
    protected static string $resource = RestockRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
