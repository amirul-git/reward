<?php

namespace App\Filament\Resources\ReceiptResource\Pages;

use App\Filament\Resources\ReceiptResource;
use App\Models\Point;
use App\Models\PointLog;
use App\Models\Receipt;
use App\Models\ReceiptLog;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReceipt extends EditRecord
{
    protected static string $resource = ReceiptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Runs after the form fields are saved to the database.
        $receipt = $this->record;

        // create receipt logs
        $actor = auth()->user();
        ReceiptLog::Create($actor, $receipt);

        $receiptAccepted = (int)$receipt->receipt_status_id === Receipt::ACCEPTED;

        if ($receiptAccepted) {
            // add point
            $point = Point::where('user_id', $receipt->user_id)->first();
            $point->amount = $point->amount + $receipt->point;
            $point->save();

            // add point log
            $pointLog = new PointLog();
            $pointLog->point_id = $point->id;
            $pointLog->point_status_id = Point::IN;
            $pointLog->amount = $receipt->point;
            $pointLog->actor_id = $actor->id;
            $pointLog->actor_name = $actor->name;
            $pointLog->receipt_id = $receipt->id;
            $pointLog->save();
        }
    }
}
