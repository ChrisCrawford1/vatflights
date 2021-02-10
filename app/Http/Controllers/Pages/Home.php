<?php

namespace App\Http\Controllers\Pages;

use App\Models\DailyStats;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;

class Home extends Controller
{
    /**
     * @param Request $request
     *
     * @return View
     */
    public function __invoke(Request $request): View
    {
        $todaysStats = DailyStats::today()
            ->first();

        return view('pages.home')->with(
            [
                'stats' => $todaysStats,
            ]
        );
    }
}
