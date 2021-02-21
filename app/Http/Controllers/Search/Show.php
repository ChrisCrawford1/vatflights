<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Airline;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class Show extends Controller
{
    /**
     * @param Request $request
     *
     * @return View
     */
    public function __invoke(Request $request): View
    {
        return view('search.show')->with(
            [
                'airlines' => Airline::select('uuid', 'name', 'country')
                    ->orderBy('name')
                    ->paginate(50),
            ]
        );
    }
}
