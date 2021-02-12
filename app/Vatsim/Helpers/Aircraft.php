<?php

namespace App\Vatsim\Helpers;

use Illuminate\Support\Str;

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
                return substr($possibleMatches[1], 0, 4);
            }

            // In the case the Aircraft is listed like - B77W/H-SDE1E2E3FGHIJ2J3J4J5M1RWXY/LB1D1
            if ($foundICAO = substr($possibleMatches[0], 0, strpos($possibleMatches[0], '/'))) {
                return $foundICAO;
            }
        }
        // In the case it doesnt match but is something like A320-214
        if (strlen($type) > 4) {
            return substr($type, 0, 4);
        }

        return $type;
    }

    /**
     * @param string $altitude
     *
     * @return string
     */
    public static function normaliseAltitude(string $altitude): string
    {
        switch ($altitude) {
            // FL050
            case Str::startsWith($altitude, 'FL0'):
                return Str::substr($altitude, 3) . '00';

            // FL320
            case Str::startsWith($altitude, 'FL'):
                return Str::substr($altitude, 2) . '00';

            // F320
            case Str::startsWith($altitude, 'F'):
                return Str::substr($altitude, 1) . '00';

            // 320
            case (Str::length($altitude) === 3):
                if (Str::startsWith($altitude, '0')) {
                    return Str::substr($altitude, 1) . '00';
                }
                return $altitude . '00';

            // Fall through and return if its already in a good format i.e 32000
            default:
                return $altitude;
        }
    }
}
