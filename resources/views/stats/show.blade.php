@extends('layouts.app')

@section('title')
    Statistics
@endsection

@section('content')
    <div class="container mx-auto mt-8 mb-8">
        <h1 class="md:text-5xl text-xl text-center text-stone-500 mb-8">Top 10's for {{ $date }}</h1>

        <div class="mt-14">
            <div class="grid gap-4 mb-6 md:grid-cols-2 xl:grid-cols-3 text-center">
                <ul>
                    <li class="text-lg bg-havelock-500 text-quill-400 rounded-t-lg w-1/2 mx-auto">Departures</li>
                    @if(count($departures) > 0)
                        @foreach($departures as $departure)
                            <li class="w-1/2 mx-auto py-2 text-stone-500 bg-white hover:bg-gray-100">
                                {{ $departure->departure }} <small>({{ $departure->count }})</small>
                            </li>
                        @endforeach
                    @else
                        <li>No Data Available</li>
                    @endif
                </ul>

                <ul>
                    <li class="text-lg bg-havelock-500 text-quill-400 rounded-t-lg w-1/2 mx-auto">Arrivals</li>
                    @if(count($arrivals) > 0)
                        @foreach($arrivals as $arrival)
                            <li class="w-1/2 mx-auto py-2 text-stone-500 bg-white hover:bg-gray-100">
                                {{ $arrival->arrival }} <small>({{ $arrival->count }})</small>
                            </li>
                        @endforeach
                    @else
                        <li>No Data Available</li>
                    @endif
                </ul>

                <ul>
                    <li class="text-lg bg-havelock-500 text-quill-400 rounded-t-lg w-1/2 mx-auto">Aircraft</li>
                    @if(count($aircraft) > 0)
                        @foreach($aircraft as $acft)
                            <li class="w-1/2 mx-auto py-2 text-stone-500 bg-white hover:bg-gray-100">
                                {{ $acft->aircraft_type }} <small>({{ $acft->count }})</small>
                            </li>
                        @endforeach
                    @else
                        <li>No Data Available</li>
                    @endif
                </ul>

                <ul>
                <li class="text-lg bg-havelock-500 text-quill-400 rounded-t-lg w-1/2 mx-auto mt-4">Altitudes</li>
                @if(count($altitudes) > 0)
                        @foreach($altitudes as $altitude)
                            <li class="w-1/2 mx-auto py-2 text-stone-500 bg-white hover:bg-gray-100">
                                {{ $altitude->planned_altitude }} <small>({{ $altitude->count }})</small>
                            </li>
                        @endforeach
                    @else
                        <li>No Data Available</li>
                    @endif
                </ul>

                <ul>
                    <li class="text-lg bg-havelock-500 text-quill-400 rounded-t-lg w-1/2 mx-auto mt-4">Airlines</li>
                    @if(count($airlines) > 0)
                        @foreach($airlines as $airline)
                            <li class="w-1/2 mx-auto py-2 text-stone-500 bg-white hover:bg-gray-100">
                                {{ $airline->name }} <small>({{ $airline->count }})</small>
                            </li>
                        @endforeach
                    @else
                        <li>No Data Available</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection
