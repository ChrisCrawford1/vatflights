<?php

namespace App\Console\Commands;

use App\Models\DailyStats;
use App\Services\Contracts\IStatsService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProcessPopularStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vatflights:process:popular';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the popular daily stats.';

    /**
     * @var IStatsService
     */
    private IStatsService $statsService;

    /**
     * Create a new command instance.
     *
     * @param IStatsService $flightStatsService
     */
    public function __construct(IStatsService $flightStatsService)
    {
        parent::__construct();
        $this->statsService = $flightStatsService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dates = [
            Carbon::today()->setTime('00', '00', '01'),
            Carbon::today()->setTime('23', '59', '59'),
        ];


        $mostPopularAircraft = $this->statsService->getMostPopularFromDataType('aircraft_type')->first();
        $mostPopularAltitude = $this->statsService->getMostPopularFromDataType('planned_altitude')->first();
        $mostPopularDeparture = $this->statsService->getMostPopularFromDataType('departure')->first();
        $mostPopularArrival = $this->statsService->getMostPopularAirfield('arrival', (int) true)->first();
        $mostPopularAirline = $this->statsService->getMostPopularAirline()->first();

        DailyStats::today()
            ->update(
                [
                    'most_popular_aircraft' => $mostPopularAircraft->aircraft_type ?? null,
                    'aircraft_uses' => $mostPopularAircraft->count ?? 0,
                    'most_common_altitude' => $mostPopularAltitude->planned_altitude,
                    'most_popular_departure' => $mostPopularDeparture->departure,
                    'departure_count' => $mostPopularDeparture->count,
                    'most_popular_arrival' => $mostPopularArrival->arrival ?? null,
                    'arrival_count' => $mostPopularArrival->count ?? null,
                    'most_popular_airline' => $mostPopularAirline->name ?? null,
                    'callsign_uses' => $mostPopularAirline->count ?? null,
                ]
            );

        return 1;
    }
}
