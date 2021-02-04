<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Flight extends Model
{
    use HasFactory;

    public const UNKNOWN_PROPERTY = 'Unknown';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'logged_in_at' => 'datetime',
        'last_seen_at' => 'datetime',
    ];

    /**
     * @return bool
     */
    public function markFlightComplete(): bool
    {
        $this->complete = true;
        return $this->save();
    }

    /**
     * @return BelongsTo
     */
    public function callsign(): BelongsTo
    {
        return $this->belongsTo(Callsign::class);
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('complete', '=', 0);
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeComplete(Builder $query): Builder
    {
        return $query->where('complete', '=', 1);
    }

    /**
     * 20 Minutes is set manually because the cron will fetch every 5 so we wait
     * for four cycles of data just in case its a random disconnect or a crash
     * before the flight is considered to no longer be active on the network.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeFlightsToBeCompleted(Builder $query)
    {
        return $query->where('last_seen_at', '<', Carbon::now()->subMinutes(20));
    }
}
