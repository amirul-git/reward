<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductExchangeLog extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'reward_id', 'actor_id', 'actor_name', 'customer_id', 'customer_name', 'reward_status_id', 'reward_status_name'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }
}
