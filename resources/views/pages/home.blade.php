@extends('layouts.app')

@section('title')
    {{ config('app.name') }}
@endsection
@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="md:text-5xl text-3xl text-center text-gray-200 mb-8">VatFlights</h1>
        <p class="text-center">A place to get general statistics about flights taking place on the <a href="https://www.vatsim.net/" class="text-blue-400">Vatsim Network</a></p>

        <div class="mt-8">
            <h1 class="text-3xl text-center mb-4">Today's Statistics</h1>
            <div class="grid gap-4 mb-6 md:grid-cols-2 xl:grid-cols-4">
            @component('components.stat-card')
                @slot('icon')
                    <i class="fas fa-plane text-2xl"></i>
                @endslot
                @slot('statName')
                    Most Popular Aircraft
                @endslot

                @slot('statValue')
                    {{ $stats['most_popular_aircraft'] }}
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
                    {{$stats['most_popular_arrival']}} ({{ $stats['arrival_count'] }})
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
        </div>
        </div>

    </div>
@endsection
