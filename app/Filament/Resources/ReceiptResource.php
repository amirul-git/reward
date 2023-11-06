<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReceiptResource\Pages;
use App\Filament\Resources\ReceiptResource\RelationManagers;
use App\Filament\Resources\ReceiptResource\RelationManagers\ReceiptLogsRelationManager;
use App\Models\Receipt;
use App\Models\ReceiptStatus;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReceiptResource extends Resource
{
    protected static ?string $model = Receipt::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Receipt Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('photo')->disk('public')->directory('receipt')->image()->columnSpan(2),
                TextInput::make('amount')->numeric()->required()->live()->afterStateUpdated(fn (Set $set, $state) => $set('point', floor($state / 5000))),
                TextInput::make('point')->numeric()->required(),
                Select::make('user_id')->label('Customer')->options(User::all()->pluck('name', 'id'))->searchable()->preload()->required(),
                Select::make('receipt_status_id')->label('Status')->options(ReceiptStatus::all()->pluck('name', 'id'))->searchable()->preload()->default(1)->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                ImageColumn::make('photo'),
                TextColumn::make('amount'),
                TextColumn::make('point'),
                TextColumn::make('user.name')->label('Customer')->searchable(),
                TextColumn::make('receiptStatus.name')->label('Status'),
                TextColumn::make('created_at')->dateTime()->sortable()
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
            ReceiptLogsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReceipts::route('/'),
            'create' => Pages\CreateReceipt::route('/create'),
            'edit' => Pages\EditReceipt::route('/{record}/edit'),
        ];
    }
}
