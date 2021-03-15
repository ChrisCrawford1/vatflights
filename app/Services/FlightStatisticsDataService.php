<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Services\Contracts\IStatsService;

class FlightStatisticsDataService implements IStatsService
{
    /**
     * @param string $dataType
     * @param int $limit
     * @param array $dates
     *
     * @return Collection
     */
    public function getMostPopularFromDataType(string $dataType, int $limit = 1, array $dates = []): Collection
    {
        $dates = $dates !== []
            ? $dates
            : [
                Carbon::today()->setTime('00', '00', '01'),
                Carbon::today()->setTime('23', '59', '59'),
            ];

        return DB::table('flights')
            ->select(DB::raw("$dataType, count(*) as count"))
            ->whereBetween('created_at', $dates)
            ->groupBy("$dataType")
            ->orderByDesc("count")
            ->limit($limit)
            ->get();
    }

    /**
     * @param string $noun
     * @param int $isComplete
     * @param int $limit
     * @param string $date
     *
     * @return Collection
     */
    public function getMostPopularAirfield(string $noun, int $isComplete, int $limit = 1, string $date = ''): Collection
    {
        return DB::table('flights')
            ->select(DB::raw("$noun, count(*) as count"))
            ->whereRaw("complete = $isComplete")
            ->whereDate('arrival_date', $date === '' ? Carbon::today() : $date)
            ->groupBy("$noun")
            ->orderByDesc("count")
            ->limit($limit)
            ->get();
    }

    /**
     * @param int $limit
     * @param array $dates
     *
     * @return Collection
     */
    public function getMostPopularAirline(int $limit = 1, array $dates = []): Collection
    {
        $dates = $dates !== []
            ? $dates
            : [
                Carbon::today()->setTime('00', '00', '01'),
                Carbon::today()->setTime('23', '59', '59'),
            ];

        return DB::table('flights')
            ->join('callsigns', 'callsign_id', '=', 'callsigns.id')
            ->join('airlines', 'callsigns.airline_id', '=', 'airlines.id')
            ->select(DB::raw('airlines.name, count(*) as count'))
            ->where('airlines.name', '!=', 'Unknown')
            ->whereBetween('flights.created_at', $dates)
            ->groupBy('airlines.name')
            ->orderByDesc('count')
            ->limit($limit)
            ->get();
    }
}
