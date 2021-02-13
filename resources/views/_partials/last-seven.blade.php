<div class="invisible md:visible">
    @if($lastSeven->count() > 0)
            <h1 class="text-3xl text-center mt-12 mb-2 text-stone-500">Last 7 days</h1>
            <table class="rounded-t-lg m-5 w-5/6 mx-auto bg-havelock-500 text-stone-500">
                <tr class="text-left border-b-2">
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Airline</th>
                    <th class="px-4 py-3">Aircraft</th>
                    <th class="px-4 py-3">Departure</th>
                    <th class="px-4 py-3">Arrival</th>
                    <th class="px-4 py-3">Altitude</th>
                    <th class="px-4 py-3">Users</th>
                </tr>

                @foreach($lastSeven as $day)
                    <tr class="bg-gray-100 border-b border-gray-200">
                        <td class="px-4 py-3">{{ $day->date->toFormattedDateString() }}</td>
                        <td class="px-4 py-3">{{ $day->most_popular_airline }}</td>
                        <td class="px-4 py-3">{{ $day->most_popular_aircraft }}</td>
                        <td class="px-4 py-3">{{ $day->most_popular_departure }}</td>
                        <td class="px-4 py-3">{{ $day->most_popular_arrival }}</td>
                        <td class="px-4 py-3">{{ number_format($day->most_common_altitude) }}FT</td>
                        <td class="px-4 py-3">{{ number_format($day->max_connected_users) }}</td>
                    </tr>
                @endforeach
        </table>
    @endif
</div>
