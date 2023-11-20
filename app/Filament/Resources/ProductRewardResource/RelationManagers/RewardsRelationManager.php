<?php

namespace App\Filament\Resources\ProductRewardResource\RelationManagers;

use App\Models\Point;
use App\Models\PointLog;
use App\Models\Product;
use App\Models\ProductExchangeLog;
use App\Models\Reward;
use App\Models\RewardLog;
use App\Models\RewardStatus;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function Laravel\Prompts\select;

class RewardsRelationManager extends RelationManager
{
    protected static string $relationship = 'rewards';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('product_id')
                    ->label('Product')
                    ->options(Product::all()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->default($this->getOwnerRecord()->id),
                Select::make('reward_status_id')->label('Reward Status')->options(RewardStatus::all()->pluck('name', 'id'))->default(1),
                TextInput::make('key')->default(Str::random(6)),
                TextInput::make('user_id')->default(auth()->user()->id)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')->label('ID')->searchable(),
                TextColumn::make('key')->searchable(),
                TextColumn::make('product.name'),
                TextColumn::make('product.point')->label('Point'),
                TextColumn::make('user.name')->label('Customer'),
                TextColumn::make('rewardStatus.name'),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->after(function (Reward $reward) {
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
                }),
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
}
