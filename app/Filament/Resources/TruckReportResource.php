<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Truck;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\TruckReport;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TruckReportResource\Pages;
use App\Filament\Resources\TruckReportResource\RelationManagers;

class TruckReportResource extends Resource
{
    protected static ?string $model = TruckReport::class;
    protected static ?string $navigationGroup = 'Vehicle Management';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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

                Forms\Components\DatePicker::make('report_date')->required(),

                //engine status
                Forms\Components\Select::make('engine_status')
                    ->options([
                        'good' => 'Good',
                        'maintenance' => 'Maintenance',
                        'repair' => 'Repair',
                    ])
                    ->required(),
                
                //tire status
                Forms\Components\Select::make('tires_status')
                    ->options([
                        'good' => 'Good',
                        'maintenance' => 'Maintenance',
                        'repair' => 'Repair',
                    ])
                    ->required(),

                //oil status
                Forms\Components\Select::make('oil_status')
                    ->options([
                        'good' => 'Good',
                        'maintenance' => 'Maintenance',
                        'repair' => 'Repair',
                    ])
                    ->required(),

                //brake status
                Forms\Components\Select::make('brakes_status')
                    ->options([
                        'good' => 'Good',
                        'maintenance' => 'Maintenance',
                        'repair' => 'Repair',
                    ])
                    ->required(),

                //light status
                Forms\Components\Select::make('lights_status')
                    ->options([
                        'good' => 'Good',
                        'maintenance' => 'Maintenance',
                        'repair' => 'Repair',
                    ])
                    ->required(),

                //battery status
                Forms\Components\Select::make('battery_status')
                    ->options([
                        'good' => 'Good',
                        'maintenance' => 'Maintenance',
                        'repair' => 'Repair',
                    ])
                    ->required(),

                //coolant status
                Forms\Components\Select::make('coolant_status')
                    ->options([
                        'good' => 'Good',
                        'maintenance' => 'Maintenance',
                        'repair' => 'Repair',
                    ])
                    ->required(),

                //transmission status
                Forms\Components\Select::make('transmission_status')
                    ->options([
                        'good' => 'Good',
                        'maintenance' => 'Maintenance',
                        'repair' => 'Repair',
                    ])
                    ->required(),

                //steering status
                Forms\Components\Select::make('steering_status')
                    ->options([
                        'good' => 'Good',
                        'maintenance' => 'Maintenance',
                        'repair' => 'Repair',
                    ])
                    ->required(),

                //suspension status
                Forms\Components\Select::make('suspension_status')
                ->options([
                    'good' => 'Good',
                    'maintenance' => 'Maintenance',
                    'repair' => 'Repair',
                ])  
                ->required(),

                //fuel status
                Forms\Components\Select::make('fuel_status')
                    ->options([
                        'full' => 'Full',
                        'half' => 'Half',
                        'low' => 'Low',
                    ])
                    ->required(),

                Forms\Components\Textarea::make('notes')->columnSpanFull(),
                
                Forms\Components\Select::make('approval_status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->required(),

                Forms\Components\Select::make('approved_by')
                    ->label('Approved By')
                    ->options(User::where('role', 'admin')->pluck('name', 'id'))
                    ->default(fn () => Auth::id())
                    ->disabled()
                    ->dehydrated() // Agar tetap dikirim meskipun hidden
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('truck.plate_number')->label('Truck'),
                Tables\Columns\TextColumn::make('driver.name')->label('Driver'),
                Tables\Columns\TextColumn::make('report_date')->date(),
                Tables\Columns\TextColumn::make('approval_status')->badge()
                    //format color badge
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'secondary',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('approved_by')->label('Approved By')->formatStateUsing(fn ($state) => User::find($state)->name),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('approve')
                    ->label('Approve')
                    ->color('secondary')
                    ->requiresConfirmation()
                    // if record is approved, then the show badge is approved
                    ->visible(fn ($record) => $record->approval_status === 'pending')
                    ->icon('heroicon-o-check-circle')
                    ->action(function ($record) {
                        $record->update([
                            'approval_status' => 'approved',
                            'approved_by' => Auth::id(),
                        ]);

                        Notification::make()
                            ->title('Approved Successfully')
                            ->success()
                            ->send();
                    }),
                Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->requiresConfirmation()
                    // if record is rejected, then the show badge is rejected
                    ->visible(fn ($record) => $record->approval_status === 'pending')
                    ->icon('heroicon-o-x-circle')
                    ->action(function ($record) {
                        $record->update([
                            'approval_status' => 'rejected',
                            'approved_by' => Auth::id(),
                        ]);

                        Notification::make()
                            ->title('Rejected Successfully')
                            ->danger()
                            ->send();
                    }),
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListTruckReports::route('/'),
            'create' => Pages\CreateTruckReport::route('/create'),
            'edit' => Pages\EditTruckReport::route('/{record}/edit'),
        ];
    }
}
