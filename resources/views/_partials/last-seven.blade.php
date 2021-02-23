@if($lastSeven->count() > 0)
    <h1 class="text-3xl text-center mt-8 mb-2 text-stone-500">Last 7 days</h1>
    <table class="rounded-full border-collapse w-5/6 mx-auto text-stone-500">
        <thead>
            <tr>
                <th class="res-table-header lg:table-cell rounded-tl-lg">Date</th>
                <th class="res-table-header lg:table-cell">Airline</th>
                <th class="res-table-header lg:table-cell">Aircraft</th>
                <th class="res-table-header lg:table-cell">Departure</th>
                <th class="res-table-header lg:table-cell">Arrival</th>
                <th class="res-table-header lg:table-cell">Altitude</th>
                <th class="res-table-header lg:table-cell rounded-tr-lg">Users</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lastSeven as $day)
                <tr class="lg:hover:bg-gray-100 lg:table-row lg:flex-row lg:flex-no-wrap mb-10 lg:mb-0 res-table-row">
                    <td class="lg:w-auto lg:table-cell lg:static res-table-cell">
                        <span class="lg:hidden res-table-tag">Date</span>
                        {{ $day->date->toFormattedDateString() }}
                    </td>
                    <td class="lg:w-auto lg:table-cell lg:static res-table-cell">
                        <span class="lg:hidden res-table-tag bg-gray-400">Airline</span>
                        {{ $day->most_popular_airline }}
                    </td>
                    <td class="lg:w-auto lg:table-cell lg:static res-table-cell">
                        <span class="lg:hidden res-table-tag">Aircraft</span>
                        {{ $day->most_popular_aircraft }}
                    </td>
                    <td class="lg:w-auto lg:table-cell lg:static res-table-cell">
                        <span class="lg:hidden res-table-tag">Departure</span>
                        {{ $day->most_popular_departure }}
                    </td>
                    <td class="lg:w-auto lg:table-cell lg:static res-table-cell">
                        <span class="lg:hidden res-table-tag">Arrival</span>
                        {{ $day->most_popular_arrival }}
                    </td>
                    <td class="lg:w-auto lg:table-cell lg:static res-table-cell">
                        <span class="lg:hidden res-table-tag">Altitude</span>
                        {{ number_format($day->most_common_altitude) }}FT
                    </td>
                    <td class="lg:w-auto lg:table-cell lg:static res-table-cell">
                        <span class="lg:hidden res-table-tag">Users</span>
                        {{ number_format($day->max_connected_users) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
