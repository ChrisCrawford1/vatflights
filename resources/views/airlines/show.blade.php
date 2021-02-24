@extends('layouts.app')

@section('title')
    {{ $airline->name }}
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="text-center sm:w-1/2 w-full mx-auto mt-4">
            <h1 class="text-3xl"> {{ $airline->name }}</h1>
            @if($airline->alias)
                <small class="text-base leading-relaxed">
                    <i>"{{ $airline->alias }}"</i>
                </small>
            @endif
            <div class="flex flex-col justify-center">
                <div class="">
                    <p class="text-xl">{{ $airline->country }} </p>
                </div>
                <div class="">
                    <img src="{{ $flag }}" height="20" width="60" class="justify-center mx-auto">
                </div>
            </div>
            <div class="flex flex-col justify-center mx-auto">
                <div class="">
                    <span class="text-stone-500 mt-2 ml-3 mr-3 text-base leading-relaxed">
                        ICAO: {{ $airline->icao }}
                    </span>
                </div>
                @if($airline->callsign)
                    <div class="">
                        <span class="text-stone-500 mt-2 ml-3 mr-3 text-base leading-relaxed">
                            Callsign: <i>{{ $airline->callsign }}</i>
                        </span>
                    </div>
                @endif
            </div>
        </div>
        @if($callsigns->count() > 0)
            <table class="rounded-full border-collapse w-5/6 sm:w-1/2 mx-auto text-stone-500 mt-3 mb-3">
                <thead>
                <tr>
                    <th class="res-table-header lg:table-cell rounded-tl-lg">Callsign</th>
                    <th class="res-table-header lg:table-cell rounded-tr-lg">First Seen</th>
                </tr>
                </thead>
                <tbody>
                @foreach($callsigns as $callsign)
                    <tr class="lg:hover:bg-gray-100 lg:table-row lg:flex-row lg:flex-no-wrap mb-10 lg:mb-0 res-table-row">
                        <td class="lg:w-auto lg:table-cell lg:static res-table-cell">
                            <span class="lg:hidden res-table-tag">Callsign</span>
                            <a href="{{ route('callsign.show', $callsign->uuid) }}" class="text-stone-500 hover:text-blue-200">{{ $callsign->callsign }}</a>
                        </td>
                        <td class="lg:w-auto lg:table-cell lg:static res-table-cell">
                            <span class="lg:hidden res-table-tag bg-gray-400">First Seen</span>
                            {{ $callsign->created_at->toFormattedDateString() }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $callsigns->links() }}
        @else
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mx-auto w-1/2" role="alert">
                <p class="font-bold">No Callsigns</p>
                <p>It looks like we haven't seen any callsigns for {{ $airline->name }} yet, check back later!</p>
            </div>
        @endif
    </div>
@endsection
