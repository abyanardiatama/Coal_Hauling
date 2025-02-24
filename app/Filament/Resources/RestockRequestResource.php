<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\RestockRequest;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RestockRequestResource\Pages;
use App\Filament\Resources\RestockRequestResource\RelationManagers;

class RestockRequestResource extends Resource
{
    protected static ?string $model = RestockRequest::class;
    protected static ?string $navigationGroup = 'Spare Part Management';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('spare_part_id')
                    ->label('Spare Part')
                    ->options(\App\Models\SparePart::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('supplier_id')
                    ->label('Supplier')
                    ->options(\App\Models\Supplier::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('requested_by')
                    ->label('Requested By')
                    ->options(\App\Models\User::pluck('name', 'id'))
                    ->disabled()
                    ->default(Auth::user()->id)
                    ->dehydrated()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('requested_quantity')
                    ->label('Requested Quantity')
                    ->numeric()
                    ->required(),
                Forms\Components\DatePicker::make('date_requested')
                    ->label('Date Requested')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sparePart.name')
                    ->sortable()
                    ->searchable()
                    //correpond to spare_part->name
                    ->label('Spare Part'),
                Tables\Columns\TextColumn::make('supplier.name')
                    ->sortable()
                    ->searchable()
                    //correpond to supplier->name
                    ->label('Supplier'),
                Tables\Columns\TextColumn::make('requested_by')
                    ->sortable()
                    ->searchable()
                    //correpond to user->name
                    ->formatStateUsing(fn ($state) => User::find($state)->name)
                    // ->getStateUsing(fn ($record) => $record->requestedBy?->name)
                    ->label('Requested By'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
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
                Tables\Columns\TextColumn::make('requested_quantity'),
                Tables\Columns\TextColumn::make('date_requested'),
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
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->icon('heroicon-o-check-circle')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'approved',
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
                    ->visible(fn ($record) => $record->status === 'pending')
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
            'index' => Pages\ListRestockRequests::route('/'),
            'create' => Pages\CreateRestockRequest::route('/create'),
            'edit' => Pages\EditRestockRequest::route('/{record}/edit'),
        ];
    }
}
