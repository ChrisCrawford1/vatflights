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
            <h1 class="text-3xl text-center mt-8 mb-2 text-stone-500">Flights Recorded</h1>
                <table class="rounded-t-lg m-5 mx-auto bg-havelock-500 text-stone-500">
                    <tr class="text-left border-b-2">
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Aircraft</th>
                        <th class="px-4 py-3">Departure</th>
                        <th class="px-4 py-3">Arrival</th>
                        <th class="px-4 py-3">Alternate</th>
                        <th class="px-4 py-3">Altitude</th>
                        <th class="px-4 py-3">Squawk</th>
                    </tr>

                    @foreach($flights as $flight)
                        <tr class="bg-gray-100 border-b border-gray-200">
                            <td class="px-4 py-3">{{ $flight->created_at->toFormattedDateString() }}</td>
                            <td class="px-4 py-3">{{ $flight->aircraft_type }}</td>
                            <td class="px-4 py-3">{{ $flight->departure }}</td>
                            <td class="px-4 py-3">{{ $flight->arrival }}</td>
                            <td class="px-4 py-3">
                                @if($flight->alternate === '' || $flight->alternate === null)
                                    N/A
                                @else
                                    {{ $flight->alternate }}
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ number_format($flight->planned_altitude) }}FT</td>
                            <td class="px-4 py-3">{{ $flight->transponder }}</td>
                        </tr>
                    @endforeach
                </table>
        </div>
    </div>
@endsection
