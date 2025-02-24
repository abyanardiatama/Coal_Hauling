<?php

namespace App\Filament\Resources\TrainingUserResource\Pages;

use App\Filament\Resources\TrainingUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrainingUser extends EditRecord
{
    protected static string $resource = TrainingUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
