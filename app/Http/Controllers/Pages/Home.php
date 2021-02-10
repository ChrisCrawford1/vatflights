<?php

namespace App\Http\Controllers\Pages;

use App\Models\DailyStats;
use Carbon\Carbon;
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

        $lastSevenDays = DailyStats::whereBetween(
            'created_at',
            [
                Carbon::today()->subDays(7),
                Carbon::now()
            ]
        )->get();

        return view('pages.home')->with(
            [
                'stats' => $todaysStats,
                'lastSeven' => $lastSevenDays
            ]
        );
    }
}
