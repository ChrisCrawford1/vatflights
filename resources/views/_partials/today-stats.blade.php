<h1 class="text-3xl text-center mt-12 mb-2 text-stone-500">Today's Statistics</h1>
<div class="grid gap-4 mb-6 md:grid-cols-2 xl:grid-cols-3">
    @component('components.stat-card')
        @slot('icon')
            <i class="fas fa-briefcase text-2xl"></i>
        @endslot
        @slot('statName')
            Most Popular Airline
        @endslot

        @slot('statValue')
            {{ $stats['most_popular_airline'] }} ({{ $stats['callsign_uses'] }})
        @endslot
    @endcomponent
    @component('components.stat-card')
        @slot('icon')
            <i class="fas fa-plane text-2xl"></i>
        @endslot
        @slot('statName')
            Most Popular Aircraft
        @endslot

        @slot('statValue')
            {{ $stats['most_popular_aircraft'] }} ({{ $stats['aircraft_uses'] }})
        @endslot
    @endcomponent
    @component('components.stat-card')
        @slot('icon')
            <i class="fas fa-plane-departure text-2xl"></i>
        @endslot
        @slot('statName')
            Most Popular Departure
        @endslot

        @slot('statValue')
            {{ $stats['most_popular_departure'] }} ({{$stats['departure_count']}})
        @endslot
    @endcomponent
    @component('components.stat-card')
        @slot('icon')
            <i class="fas fa-plane-arrival text-2xl"></i>
        @endslot
        @slot('statName')
            Most Popular Arrival
        @endslot

        @slot('statValue')
            {{$stats['most_popular_arrival'] ?? '????'}} ({{ $stats['arrival_count'] ?? '????' }})
        @endslot
    @endcomponent
    @component('components.stat-card')
        @slot('icon')
            <i class="fas fa-location-arrow text-2xl"></i>
        @endslot
        @slot('statName')
            Most Popular Altitude
        @endslot

        @slot('statValue')
            {{ number_format($stats['most_common_altitude']) }} FT
        @endslot
    @endcomponent
        @component('components.stat-card')
            @slot('icon')
                <i class="fas fa-users text-2xl"></i>
            @endslot
            @slot('statName')
                Max Connected Users
            @endslot

            @slot('statValue')
                {{ $stats['max_connected_users'] }}
            @endslot
        @endcomponent
</div>
