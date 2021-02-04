<?php

namespace App\Providers;

use App\Models\Callsign;
use App\Models\DailyStats;
use App\Models\Flight;
use App\Observers\CallsignObserver;
use App\Observers\DailyStatsObserver;
use App\Observers\FlightObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Callsign::observe(CallsignObserver::class);
        Flight::observe(FlightObserver::class);
        DailyStats::observe(DailyStatsObserver::class);
    }
}
