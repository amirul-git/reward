<?php

namespace App\Filament\Resources\ProductRewardResource\Pages;

use App\Filament\Resources\ProductRewardResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductRewards extends ListRecords
{
    protected static string $resource = ProductRewardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
