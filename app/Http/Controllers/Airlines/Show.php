<?php

namespace App\Http\Controllers\Airlines;

use App\Http\Controllers\Controller;
use App\Models\Airline;
use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;

class Show extends Controller
{
    public function __invoke(Request $request, Airline $airline)
    {
        $country = Countries::where('name.common', $airline->country)->first();

        return view('airlines.show')->with(
            [
                'airline' => $airline,
                'callsigns' => $airline->callsigns()->paginate(20),
                'flag' => asset("/pragmarx/countries/flag/file/{$country->iso_a3}.svg")
            ]
        );
    }
}
