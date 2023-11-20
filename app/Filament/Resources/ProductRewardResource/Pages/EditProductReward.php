<?php

namespace App\Filament\Resources\ProductRewardResource\Pages;

use App\Filament\Resources\ProductRewardResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductReward extends EditRecord
{
    protected static string $resource = ProductRewardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
