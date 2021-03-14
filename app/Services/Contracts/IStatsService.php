<?php

namespace App\Services\Contracts;

use Illuminate\Support\Collection;

interface IStatsService
{
    /**
     * @param string $dataType
     * @param int $limit
     * @param array $dates
     *
     * @return Collection
     */
    public function getMostPopularFromDataType(string $dataType, int $limit = 1, array $dates = []): Collection;

    /**
     * @param string $noun
     * @param int $isComplete
     * @param int $limit
     * @param string $date
     *
     * @return Collection
     */
    public function getMostPopularAirfield(string $noun, int $isComplete, int $limit = 1, string $date = ''): Collection;

    /**
     * @param int $limit
     * @param array $dates
     *
     * @return Collection
     */
    public function getMostPopularAirline(int $limit = 1, array $dates = []): Collection;
}
