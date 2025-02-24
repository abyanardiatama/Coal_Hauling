<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Truck;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ShipmentPermit;
use Illuminate\Validation\Rule;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ShipmentPermitResource\Pages;
use App\Filament\Resources\ShipmentPermitResource\RelationManagers;

class ShipmentPermitResource extends Resource
{
    protected static ?string $model = ShipmentPermit::class;
    protected static ?string $navigationGroup = 'Shipments';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('permit_number')
                    ->label('Letter Number')
                    ->required()
                    ->prefix('CH-')
                    ->maxLength(8),
                Forms\Components\Select::make('truck_id')
                    ->label('Truck')
                    ->options(Truck::pluck('plate_number', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('driver_id')
                    ->label('Driver')
                    ->options(User::where('role', 'driver')->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\DatePicker::make('shipment_date')
                    ->label('Shipment Date')
                    ->required(),
                Forms\Components\TextInput::make('shipment_from')
                    ->label('Shipped From')
                    ->required(),
                Forms\Components\TextInput::make('shipment_to')
                    ->label('Shipped To')
                    ->required(),
                Forms\Components\Select::make('shipment_type')
                    ->label('Shipment Type')
                    ->options([
                        'export' => 'Ekspor',
                        'import' => 'Impor',
                    ])
                    ->required(),
                Forms\Components\Select::make('shipment_status')
                    ->label('Shipment Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->required()
                    ->disabled()
                    ->dehydrated() // Agar tetap dikirim meskipun hidden
                    ->default('pending'),                    
                Forms\Components\FileUpload::make('file_path')
                    ->label('File Surat')
                    ->acceptedFileTypes([
                        'application/pdf',
                    ])
                    ->openable()
                    ->directory('shipment_permits')
                    // ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('permit_number')
                    ->label('Letter Number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('truck.plate_number')
                    ->label('Truck')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('driver.name')
                    ->label('Driver')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shipment_date')
                    ->label('Shipment Date')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shipment_from')
                    ->label('Shipped From')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shipment_to')
                    ->label('Shipped To')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shipment_type')
                    ->label('Shipment Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'export' => 'export',
                        'import' => 'warning',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'export' => 'Export',
                        'import' => 'Import',
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shipment_status')
                    ->label('Letter Status')
                    ->searchable()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'secondary',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    })
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //send email action
                // Action::make('send_email')
                //     ->label('Send')
                //     ->icon('heroicon-o-envelope')
                //     ->visible(fn ($record) => $record->shipment_status === 'pending')
                //     ->action(function ($record) {
                //         Notification::make()
                //             ->title('Email Sent')
                //             ->success()
                //             ->send();
                //     }),
                Tables\Actions\EditAction::make()
                    //if file_path is not null, then change shipment_status to approved
                    ->mutateRecordDataUsing(function (array $data): array {
                        if (!empty($data['file_path'])) {
                            $data['shipment_status'] = 'approved';
                        }
                        return $data;
                    })
                    //visible for admin only
                    ->visible(fn ($record) => Auth::user()->role === 'admin' && 
                        ($record->shipment_status === 'pending' || $record->shipment_status === 'rejected'))
                    // ->visible(fn ($record) => $record->shipment_status === 'pending' || $record->shipment_status === 'rejected')
                    ->color('warning')
                    ,
                //download action
                Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down')
                    ->url(fn ($record) => $record->file_path)
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => $record->shipment_status === 'approved' && $record->file_path !== null)
                    //add notification when download success
                    ->action(function ($record) {
                        Notification::make()
                            ->title('Download Success')
                            ->success()
                            ->send();
                    }),
                ActionGroup::make([
                    Tables\Actions\ViewAction::make()
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
            'index' => Pages\ListShipmentPermits::route('/'),
            'create' => Pages\CreateShipmentPermit::route('/create'),
            'edit' => Pages\EditShipmentPermit::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return parent::getEloquentQuery();
        }
        elseif ($user->role === 'driver') {
            return parent::getEloquentQuery()->where('driver_id', $user->id);
        }

    }
}