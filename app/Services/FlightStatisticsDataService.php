<?php

namespace App\Services;

use App\Services\Contracts\IStatsService;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class FlightStatisticsDataService implements IStatsService
{
    /**
     * @var Builder
     */
    private Builder $query;

    /**
     * FlightStatisticsDataService constructor.
     * @param array|null $dates
     */
    public function __construct(array $dates = null)
    {
        $this->query = DB::table('flights')
            ->whereBetween(
                'created_at',
                [
                    $dates['from'] ?? Carbon::today()->setTime('00', '00', '01'),
                    $dates['to'] ?? Carbon::today()->setTime('23', '59', '59'),
                ]
            );
    }

    /**
     * @param string $dataType
     * @param int $limit
     *
     * @return object
     */
    public function getMostPopularFromDataType(string $dataType, int $limit = 1): object
    {
        $value = $this->query
            ->select(DB::raw("$dataType, count(*) as count"))
            ->groupBy("$dataType")
            ->orderByDesc("count")
            ->limit($limit)
            ->first();

        $this->resetQuery();

        return $value;
    }

    /**
     * @param string $noun
     * @param bool $isComplete
     * @param int $limit
     *
     * @return object
     */
    public function getMostPopularAirfield(string $noun, int $isComplete, int $limit = 1): ?object
    {
        $airfield = $this->query
            ->select(DB::raw("$noun, count(*) as count"))
            ->whereRaw("complete = $isComplete")
            ->groupBy("$noun")
            ->orderByDesc("count")
            ->limit(1)
            ->first();

        $this->resetQuery();

        return $airfield;
    }

    private function resetQuery(): void
    {
        $this->query->columns = [];
        $this->query->wheres = [];
        $this->query->groups = [];
        $this->query->orders = [];
    }
}
