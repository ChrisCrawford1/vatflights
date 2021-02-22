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
            <div class="">
                <table class="rounded-t-lg m-5 w-1/2 mx-auto bg-havelock-500 text-stone-500">
                    <tr class="text-left border-b-2">
                        <th class="px-4 py-3">Callsign</th>
                        <th class="px-4 py-3">First Seen</th>
                    </tr>

                    @foreach($callsigns as $callsign)
                        <tr class="bg-gray-100 border-b border-gray-200">
                            <td class="px-4 py-3">
                                <a href="{{ route('callsign.show', $callsign->uuid) }}" class="text-stone-500 hover:text-blue-200">{{ $callsign->callsign }}</a>
                            </td>
                            <td class="px-4 py-3">
                                {{ $callsign->created_at->toFormattedDateString() }}
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $callsigns->links() }}
            </div>
        @else
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mx-auto w-1/2" role="alert">
                <p class="font-bold">No Callsigns</p>
                <p>It looks like we haven't seen any callsigns for {{ $airline->name }} yet, check back later!</p>
            </div>
        @endif
    </div>
@endsection
