<?php

namespace Tests\Helpers\Data;

class TestVatsimData
{
    private array $jsonData =
        [
            'general' => [
                'version' => 3,
                'reload' => 1,
                'update' => '20210205075956',
                'update_timestamp' => '2021-02-05T07:59:56.9504851Z',
                'connected_clients' => 1,
                'unique_users' => 1
            ],
            'pilots' => [
                [
                    "cid" => 2223315,
                    "name" => "Jane Doe",
                    "callsign" => "TAP325",
                    "server" => "USA-WEST",
                    "pilot_rating" => 0,
                    "latitude" => 22.2766,
                    "longitude" => 115.11116,
                    "altitude" => 18648,
                    "groundspeed" => 360,
                    "transponder" => "6244",
                    "heading" => 267,
                    "qnh_i_hg" => 30.02,
                    "qnh_mb" => 1017,
                    "flight_plan" => [
                        "flight_rules" => "I",
                        "aircraft" => "H/A319/L",
                        "departure" => "LPPT",
                        "arrival" => "LPMA",
                        "alternate" => "",
                        "cruise_tas" => "463",
                        "altitude" => "32000",
                        "deptime" => "0240",
                        "enroute_time" =>" 0447",
                        "fuel_time" => "0616",
                        "remarks" => "I am a test pilot",
                        "route" => "DCT DCT DCT DCT"
                    ],
                    "logon_time"=>"2021-02-04T18:58:17.0532113Z",
                    "last_updated"=>"2021-02-05T07:59:54.0044439Z"
                ],
            ]
    ];

    /**
     * @return string
     */
    public function getEncodedJsonData(): string
    {
        return json_encode($this->jsonData);
    }

    /**
     * @return array
     */
    public function getJsonData(): array
    {
        return $this->jsonData;
    }

}
