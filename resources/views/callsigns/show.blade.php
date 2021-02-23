@extends('layouts.app')

@section('title')
    {{ $airlineName }}
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="text-center xs:w-1/2 w-full mx-auto mt-4">
            <h1 class="text-3xl"> {{ $airlineName }}</h1>
            <h1 class="text-xl"><i>{{ $callsign }}</i></h1>
            <p class="text-stone-500 mt-2 ml-3 mr-3 text-base leading-relaxed">
                Has been seen {{ $flightCount }} times so far.
            </p>
            <h1 class="text-3xl text-center mt-8 mb-2 text-stone-500 mb-2">Flights Recorded</h1>

            <table class="rounded-full border-collapse w-2/3 mx-auto text-stone-500">
                <thead>
                <tr>
                    <th class="res-table-header lg:table-cell rounded-tl-lg">Date</th>
                    <th class="res-table-header lg:table-cell">Aircraft</th>
                    <th class="res-table-header lg:table-cell">Departure</th>
                    <th class="res-table-header lg:table-cell">Arrival</th>
                    <th class="res-table-header lg:table-cell">Alternate</th>
                    <th class="res-table-header lg:table-cell">Altitude</th>
                    <th class="res-table-header lg:table-cell rounded-tr-lg">Squawk</th>
                </tr>
                </thead>
                <tbody>
                @foreach($flights as $flight)
                    <tr class="lg:hover:bg-gray-100 lg:table-row lg:flex-row lg:flex-no-wrap mb-10 lg:mb-0 res-table-row">
                        <td class="lg:w-auto lg:table-cell lg:static res-table-cell">
                            <span class="lg:hidden res-table-tag">Date</span>
                            {{ $flight->created_at->toFormattedDateString() }}
                        </td>
                        <td class="lg:w-auto lg:table-cell lg:static res-table-cell">
                            <span class="lg:hidden res-table-tag">Aircraft</span>
                            {{ $flight->aircraft_type }}
                        </td>
                        <td class="lg:w-auto lg:table-cell lg:static res-table-cell">
                            <span class="lg:hidden res-table-tag">Departure</span>
                            {{ $flight->departure }}
                        </td>
                        <td class="lg:w-auto lg:table-cell lg:static res-table-cell">
                            <span class="lg:hidden res-table-tag">Arrival</span>
                            {{ $flight->arrival }}
                        </td>
                        <td class="lg:w-auto lg:table-cell lg:static res-table-cell">
                            <span class="lg:hidden res-table-tag">Alternate</span>
                            @if($flight->alternate === '' || $flight->alternate === null)
                                N/A
                            @else
                                {{ $flight->alternate }}
                            @endif
                        </td>
                        <td class="lg:w-auto lg:table-cell lg:static res-table-cell">
                            <span class="lg:hidden res-table-tag">Altitude</span>
                            {{ number_format($flight->planned_altitude) }}FT
                        </td>
                        <td class="lg:w-auto lg:table-cell lg:static res-table-cell">
                            <span class="lg:hidden res-table-tag">Squawk</span>
                            {{ $flight->transponder }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
