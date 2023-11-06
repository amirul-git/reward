<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PointResource\Pages;
use App\Filament\Resources\PointResource\RelationManagers;
use App\Filament\Resources\PointResource\RelationManagers\PointLogsRelationManager;
use App\Models\Point;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PointResource extends Resource
{
    protected static ?string $model = Point::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Point Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('user_id')->disabled(),
                TextInput::make('amount')->disabled()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.id')->searchable()->label('User ID'),
                TextColumn::make('user.name')->searchable()->label('Name'),
                TextColumn::make('amount')->label('Point'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PointLogsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPoints::route('/'),
            'create' => Pages\CreatePoint::route('/create'),
            'edit' => Pages\EditPoint::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
