<?php

namespace App\Services;

use App\Models\Flight;
use App\Services\Contracts\IStatsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FlightStatisticsDataService implements IStatsService
{
    /**
     * @param string $dataType
     * @param int $limit
     *
     * @return object
     */
    public function getMostPopularFromDataType(string $dataType, int $limit = 1): ?object
    {
        return DB::table('flights')
            ->select(DB::raw("$dataType, count(*) as count"))
            ->whereBetween(
                'created_at',
                [
                    Carbon::today()->setTime('00', '00', '01'),
                    Carbon::today()->setTime('23', '59', '59'),
                ]
            )
            ->groupBy("$dataType")
            ->orderByDesc("count")
            ->limit($limit)
            ->first();
    }

    /**
     * @param string $noun
     * @param int $isComplete
     * @param int $limit
     *
     * @return object
     */
    public function getMostPopularAirfield(string $noun, int $isComplete, int $limit = 1): ?object
    {
        return DB::table('flights')
            ->select(DB::raw("$noun, count(*) as count"))
            ->whereRaw("complete = $isComplete")
            ->whereBetween(
                'created_at',
                [
                     Carbon::today()->setTime('00', '00', '01'),
                     Carbon::today()->setTime('23', '59', '59'),
                ]
            )
            ->groupBy("$noun")
            ->orderByDesc("count")
            ->limit(1)
            ->first();
    }
}
