<?php

namespace App\Filament\Resources\ReceiptResource\Pages;

use App\Filament\Resources\ReceiptResource;
use App\Models\ReceiptLog;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReceipt extends CreateRecord
{
    protected static string $resource = ReceiptResource::class;

    protected function afterCreate(): void
    {
        // Runs after the form fields are saved to the database.
        $receipt = $this->record;

        // create receipt logs
        $actor = auth()->user();
        ReceiptLog::Create($actor, $receipt);
    }
}
