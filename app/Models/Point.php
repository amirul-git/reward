<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    public const IN = 1;
    public const OUT = 2;

    protected $fillable = ['amount', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pointLogs()
    {
        return $this->hasMany(PointLog::class);
    }
}
