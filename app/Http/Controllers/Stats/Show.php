<?php

namespace App\Http\Controllers\Stats;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Services\Contracts\IStatsService;

class Show extends Controller
{
    /**
     * @var IStatsService
     */
    private IStatsService $statsService;

    public function __construct(IStatsService $statsService)
    {
        $this->statsService = $statsService;
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function __invoke(Request $request): View
    {
        $searchedDate = Carbon::parse($request->get('date'));

        if (!Carbon::today()->eq($searchedDate)) {
            $dates = [
                Carbon::parse($request->get('date'))
                    ->setTime('00', '00', '01'),
                Carbon::parse($request->get('date'))
                    ->setTime('23', '59', '59'),
            ];

            return view('stats.show')
                ->with(
                    $this->returnDataSet($dates)
                );
        }

        return view('stats.show')
            ->with(
                $this->returnDataSet()
            );
    }

    /**
     * @param array $dates
     *
     * @return array
     */
    private function returnDataSet(array $dates = []): array
    {
        $topFiveDepartures = $this->statsService
            ->getMostPopularFromDataType('departure', 10, $dates);
        $topFiveArrivals = $this->statsService
            ->getMostPopularAirfield('arrival', (int) true, 10, $dates[0]->setTime('00', '00', '00') ?? '');

        $topFiveAircraftTypes = $this->statsService
            ->getMostPopularFromDataType('aircraft_type', 10, $dates);
        $topFiveAltitudes = $this->statsService
            ->getMostPopularFromDataType('planned_altitude', 10, $dates);
        $topFiveAirlines = $this->statsService
            ->getMostPopularAirline(10, $dates);

        return  [
            'date' => $dates[0]->toDateString(),
            'departures' => $topFiveDepartures,
            'arrivals' => $topFiveArrivals,
            'aircraft' => $topFiveAircraftTypes,
            'altitudes' => $topFiveAltitudes,
            'airlines' => $topFiveAirlines,
        ];
    }
}
