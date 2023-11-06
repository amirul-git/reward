<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    public const REQUESTED = 1;
    public const ACCEPTED = 2;
    public const REJECTED = 3;


    protected $fillable = ['photo', 'amount', 'point', 'user_id', 'receipt_status_id'];

    public function receiptStatus()
    {
        return $this->belongsTo(ReceiptStatus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function receiptLogs()
    {
        return $this->hasMany(ReceiptLog::class);
    }
}
