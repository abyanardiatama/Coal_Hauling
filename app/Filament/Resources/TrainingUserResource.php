<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingUserResource\Pages;
use App\Filament\Resources\TrainingUserResource\RelationManagers;
use App\Models\TrainingUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TrainingUserResource extends Resource
{
    protected static ?string $model = TrainingUser::class;
    protected static ?string $navigationGroup = 'Training Management';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('training_id')
                    ->label('Training')
                    ->options(\App\Models\Training::pluck('title', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label('Driver')
                    ->options(\App\Models\User::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->disabled()
                    ->dehydrated()
                    ->default('pending')
                    ->options([
                        'pending' => 'Pending',
                        'attendance' => 'Attendance',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('training.title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending' => 'Pending',
                        'attendance' => 'Attendance',
                        'approved' => 'Completed',
                        'rejected' => 'Failed',
                    })
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'gray',
                        'attendance' => 'warning',
                        'approved' => 'export',
                        'rejected' => 'danger',
                    })
                    ,
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // filter for each training
                Tables\Filters\SelectFilter::make('training_id')
                    ->options(fn () => \App\Models\Training::pluck('title', 'id')->toArray())
                    ->label('Training')
                    ->searchable()
                    ->placeholder('Select Trainings'),
            ])
            ->actions([
                Action::make('attendance')
                    ->label('Attendance')
                    ->color('warning')
                    //visible for admin only
                    ->visible(fn () => Auth::user()->role === 'admin')
                    ->action(fn ($record) => $record->update(['status' => 'attendance'])),
                Action::make('approve')
                    ->label('Approve')
                    ->color('export')
                    ->visible(fn () => Auth::user()->role === 'admin')
                    ->action(fn ($record) => $record->update(['status' => 'approved'])),
                Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->visible(fn () => Auth::user()->role === 'admin')
                    ->action(fn ($record) => $record->update(['status' => 'rejected'])),
                ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->visible(fn () => Auth::user()->role === 'admin'),
                    Tables\Actions\DeleteAction::make()
                        ->visible(fn () => Auth::user()->role === 'admin'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrainingUsers::route('/'),
            'create' => Pages\CreateTrainingUser::route('/create'),
            'edit' => Pages\EditTrainingUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return parent::getEloquentQuery();
        }
        elseif ($user->role === 'driver') {
            return parent::getEloquentQuery()->where('user_id', $user->id);
        }
    }

}
