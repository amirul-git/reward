<?php

namespace App\Filament\Resources\RewardResource\Pages;

use App\Filament\Resources\RewardResource;
use App\Models\Point;
use App\Models\PointLog;
use App\Models\Product;
use App\Models\ProductExchangeLog;
use App\Models\RewardLog;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateReward extends CreateRecord
{
    protected static string $resource = RewardResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

    protected function afterCreate(): void
    {
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

            // decrement user point
            $userPoint = Point::where('user_id', $user->id)->get()->first();
            $userPoint->amount = $userPoint->amount - $reward->product->point;
            $userPoint->save();

            // create point log for reward
            $pointLog = new PointLog();
            $pointLog->point_id = $userPoint->id;
            $pointLog->point_status_id = Point::OUT;
            $pointLog->amount = $reward->product->point;
            $pointLog->actor_id = $user->id;
            $pointLog->actor_name = $user->name;
            $pointLog->reward_id = $reward->id;
            $pointLog->save();

            // catat product log
            $productExchangeLog = new ProductExchangeLog();
            $productExchangeLog->product_id = $reward->product->id;
            $productExchangeLog->reward_id = $reward->id;
            $productExchangeLog->actor_id = $user->id;
            $productExchangeLog->actor_name = $user->name;
            $productExchangeLog->customer_id = $user->id;
            $productExchangeLog->customer_name = $user->name;
            $productExchangeLog->reward_status_id = $reward->reward_status_id;
            $productExchangeLog->reward_status_name = $reward->rewardStatus->name;
            $productExchangeLog->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
