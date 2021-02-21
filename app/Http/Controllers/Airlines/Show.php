<?php

namespace App\Http\Controllers\Airlines;

use App\Http\Controllers\Controller;
use App\Models\Airline;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;

class Show extends Controller
{
    /**
     * @param Request $request
     * @param Airline $airline
     *
     * @return View
     */
    public function __invoke(Request $request, Airline $airline): View
    {
        $country = Countries::where('name.common', $airline->country)->first();
        $svgFlagAsset = !$country->isEmpty() ? asset("/pragmarx/countries/flag/file/{$country->iso_a3}.svg") : null;

        return view('airlines.show')->with(
            [
                'airline' => $airline,
                'callsigns' => $airline->callsigns()->orderByDesc('created_at')->paginate(20),
                'flag' => $svgFlagAsset ??= '',
            ]
        );
    }
}
