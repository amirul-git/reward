<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardLog extends Model
{
    use HasFactory;

    protected $fillable = ['reward_id', 'reward_status_id', 'reward_status_name', 'actor_id', 'actor_name'];

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }
}
