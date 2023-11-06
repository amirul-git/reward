<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptLog extends Model
{
    use HasFactory;

    protected $fillable = ['actor_id', 'actor_name', 'user_id', 'user_name', 'amount', 'photo', 'point', 'receipt_id', 'receipt_status_id', 'receipt_status_name'];

    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }

    public static function Create($actor, $receipt)
    {
        $receiptLog = new ReceiptLog();
        $receiptLog->actor_id = $actor->id;
        $receiptLog->actor_name = $actor->name;
        $receiptLog->user_id = $receipt->user->id;
        $receiptLog->user_name = $receipt->user->name;
        $receiptLog->photo = $receipt->photo;
        $receiptLog->amount = $receipt->amount;
        $receiptLog->point = $receipt->point;
        $receiptLog->receipt_id = $receipt->id;
        $receiptLog->receipt_status_id = $receipt->receiptStatus->id;
        $receiptLog->receipt_status_name = $receipt->receiptStatus->name;
        $receiptLog->save();
    }
}
