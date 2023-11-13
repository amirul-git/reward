<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'reward_status_id', 'key'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function rewardLogs()
    {
        return $this->hasMany(RewardLog::class);
    }

    public function rewardStatus()
    {
        return $this->belongsTo(RewardStatus::class);
    }
}
