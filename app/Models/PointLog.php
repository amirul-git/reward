<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointLog extends Model
{
    use HasFactory;

    protected $fillable = ['point_id', 'point_status_id', 'amount', 'actor_id', 'actor_name'];

    public function pointStatus()
    {
        return $this->belongsTo(PointStatus::class);
    }

    public function point()
    {
        return $this->belongsTo(Point::class);
    }

    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }
}
