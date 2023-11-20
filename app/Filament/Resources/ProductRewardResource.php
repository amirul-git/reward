<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductRewardResource\Pages;
use App\Filament\Resources\ProductRewardResource\RelationManagers;
use App\Filament\Resources\ProductRewardResource\RelationManagers\RewardsRelationManager;
use App\Models\Product;
use App\Models\ProductReward;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Nette\Utils\ImageColor;

class ProductRewardResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationGroup = 'Reward Management';

    protected static ?string $navigationLabel = 'Product Rewards';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('photo')->columnSpan(2),
                TextInput::make('name'),
                TextInput::make('description'),
                TextInput::make('amount'),
                TextInput::make('point'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')->circular(),
                TextColumn::make('name'),
                TextColumn::make('description'),
                TextColumn::make('amount'),
                TextColumn::make('point'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            RewardsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductRewards::route('/'),
            'create' => Pages\CreateProductReward::route('/create'),
            'edit' => Pages\EditProductReward::route('/{record}/edit'),
        ];
    }
}
