<?php

namespace App\Filament\Resources\RewardResource\Pages;

use App\Filament\Resources\RewardResource;
use App\Models\ProductExchangeLog;
use App\Models\RewardLog;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;

class EditReward extends EditRecord
{
    protected static string $resource = RewardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Runs after the form fields are saved to the database.

        $reward = $this->record;
        $user = auth()->user();

        try {
            DB::beginTransaction();

            // create log
            $rewardLog = new RewardLog();
            $rewardLog->reward_id = $reward->id;
            $rewardLog->reward_status_id = $reward->reward_status_id;
            $rewardLog->reward_status_name = $reward->rewardStatus->name;
            $rewardLog->actor_id = $user->id;
            $rewardLog->actor_name = $user->name;
            $rewardLog->save();

            // decrement product amount nya saat di exchange
            $product = $reward->product;
            $product->amount = $product->amount - 1;
            $product->save();

            // buat log product
            $productExchangeLog = new ProductExchangeLog();
            $productExchangeLog->product_id = $reward->product->id;
            $productExchangeLog->reward_id = $reward->id;
            $productExchangeLog->actor_id = $user->id;
            $productExchangeLog->actor_name = $user->name;
            $productExchangeLog->customer_id = $reward->user->id;
            $productExchangeLog->customer_name = $reward->user->name;
            $productExchangeLog->reward_status_id = $reward->reward_status_id;
            $productExchangeLog->reward_status_name = $reward->rewardStatus->name;
            $productExchangeLog->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        // decrement product amount nya saat di exchange

        // catat product di log decrementnya dan requestnya
    }
}
