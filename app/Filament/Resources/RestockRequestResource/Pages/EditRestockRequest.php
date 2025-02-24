<?php

namespace App\Filament\Resources\RestockRequestResource\Pages;

use App\Filament\Resources\RestockRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRestockRequest extends EditRecord
{
    protected static string $resource = RestockRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
