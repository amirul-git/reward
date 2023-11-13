<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public const CREATED = 1;
    public const EXCHANGED = 2;
}
