<?php

namespace App\Filament\Resources\TruckResource\Pages;

use Actions\Button;
use Filament\Actions;
use App\Filament\Resources\TruckResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\DeleteAction;

class ListTrucks extends ListRecords
{
    protected static string $resource = TruckResource::class;
    // protected static ?string $recordTitleAttribute = 'Trucks List';
    public static ?string $title = 'List of Trucks';


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
