<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Vatsim JSON Url
    |--------------------------------------------------------------------------
    |
    | This value is the publicly accessible URL for the JSON file updated
    | every minute or so with current connections to the network in the
    | form of General, Pilots, Controllers, ATIS, Servers etc...
    |
    */

    'json-data-url' => env('VATSIM_JSON_DATA_URL', ''),
];
