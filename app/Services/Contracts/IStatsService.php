<?php

namespace App\Services\Contracts;

interface IStatsService
{
    /**
     * @param string $dataType
     * @param int $limit
     *
     * @return object|null
     */
    public function getMostPopularFromDataType(string $dataType, int $limit = 1): object|null;

    /**
     * @param string $noun
     * @param int $isComplete
     * @param int $limit
     *
     * @return object|null
     */
    public function getMostPopularAirfield(string $noun, int $isComplete, int $limit = 1): object|null;

    /**
     * @return object|null
     */
    public function getMostPopularAirline(): ?object;
}
