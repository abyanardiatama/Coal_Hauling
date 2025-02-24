<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SparePartUsage;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SparePartUsageResource\Pages;
use App\Filament\Resources\SparePartUsageResource\RelationManagers;

class SparePartUsageResource extends Resource
{
    protected static ?string $model = SparePartUsage::class;
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
                Forms\Components\Select::make('truck_id')
                    ->label('Truck')
                    ->options(\App\Models\Truck::pluck('plate_number', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label('Driver')
                    ->options(\App\Models\User::where('role', 'admin')->pluck('name', 'id'))
                    ->searchable()
                    ->disabled()
                    ->default(Auth::user()->id)
                    ->dehydrated()
                    ->required(),
                Forms\Components\TextInput::make('quantity_used')
                    ->label('Quantity Used')
                    ->minValue(1)
                    ->placeholder('Enter quantity used')
                    ->numeric()
                    ->required(),
                Forms\Components\DatePicker::make('date_used')
                    ->label('Date Used')
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->label('Notes')
                    //placeholder
                    ->placeholder('Enter notes here...')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sparePart.name')->label('Spare Part')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('truck.plate_number')->label('Truck')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user_id')->label('Usage By')->searchable()->sortable()->formatStateUsing(fn ($state) => User::find($state)->name),
                Tables\Columns\TextColumn::make('quantity_used')->label('Quantity Used')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('date_used')->label('Date Used')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('notes')->label('Notes')->searchable()->sortable()->wrap(3),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSparePartUsages::route('/'),
            'create' => Pages\CreateSparePartUsage::route('/create'),
            'edit' => Pages\EditSparePartUsage::route('/{record}/edit'),
        ];
    }
}
