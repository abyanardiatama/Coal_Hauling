<?php

namespace App\Filament\Resources\TrainingUserResource\Pages;

use Filament\Actions;
use App\Models\TrainingUser;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TrainingUserResource;

class CreateTrainingUser extends CreateRecord
{
    protected static string $resource = TrainingUserResource::class;
    protected function beforeCreate(): void
    {
        $data = $this->form->getState(); // Ambil data dalam bentuk array

        // Cek apakah data training user sudah ada
        $trainingUserExists = TrainingUser::where('training_id', $data['training_id'])
            ->where('user_id', $data['user_id'])
            ->exists();

        if ($trainingUserExists) {
            Notification::make()
                ->title('Driver already assigned to this training.')
                ->danger()
                ->send();

            $this->halt(); // Stop proses penyimpanan
        }
    }
}
