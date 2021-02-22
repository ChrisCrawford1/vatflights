<?php

namespace App\Http\Controllers\Callsigns;

use App\Http\Controllers\Controller;
use App\Models\Callsign;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class Show extends Controller
{
    /**
     * @param Request $request
     * @param Callsign $callsign
     *
     * @return View
     */
    public function __invoke(Request $request, Callsign $callsign): View
    {
        return view('callsigns.show')->with(
            [
                'flights' => $callsign->flights()->paginate(20),
                'flightCount' => $callsign->flights()->count(),
                'airlineName' => $callsign->airline()->first()->name,
                'callsign' => $callsign->callsign,
            ]
        );
    }
}
