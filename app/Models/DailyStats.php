<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyStats extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeToday(Builder $query)
    {
        return $query->where('date', '=', Carbon::today());
    }
}
