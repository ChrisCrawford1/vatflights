<?php

namespace App\Services\Contracts;

interface IStatsService
{
    /**
     * @param string $dataType
     * @param int $limit
     *
     * @return object
     */
    public function getMostPopularFromDataType(string $dataType, int $limit = 1): ?object;

    /**
     * @param string $noun
     * @param int $isComplete
     * @param int $limit
     *
     * @return object
     */
    public function getMostPopularAirfield(string $noun, int $isComplete, int $limit = 1): ?object;

    /**
     * @return object|null
     */
    public function getMostPopularAirline(): ?object;
}
