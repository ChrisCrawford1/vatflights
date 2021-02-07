<?php

namespace App\Vatsim\Helpers;

class Aircraft
{
    public const REGEX_MATCH = '/[^\/]*\/([^\/]*)/';

    /**
     * This regex match is based on the common representations of aircraft
     * that has been seen from the network data that pilots file. This is
     * something to be improved upon later as this is temporary to prevent
     * the database containing massive equipment code items in type field.
     *
     * @param string $type
     *
     * @return string
     */
    public static function findICAO(string $type): string
    {
        preg_match(self::REGEX_MATCH, $type, $possibleMatches);

        if ($possibleMatches) {
            // In the case the Aircraft is listed like - H/B78X/L
            if (strlen($possibleMatches[1]) === 4) {
                return $possibleMatches[1];
            }

            // In the case the Aircraft is listed like - B77W/H-SDE1E2E3FGHIJ2J3J4J5M1RWXY/LB1D1
            if ($foundICAO = substr($possibleMatches[0], 0, strpos($possibleMatches[0], '/'))) {
                return $foundICAO;
            }
        }

        return $type;
    }
}
