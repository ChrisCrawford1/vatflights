@extends('layouts.app')

@section('title')
    {{ config('app.name') }}
@endsection
@section('content')
    <div class="container mx-auto mt-8">
            <h1 class="md:text-5xl text-3xl text-center text-stone-500 mb-8">VatFlights</h1>
            <p class="text-center text-stone-500">
                A place to get current and previous statistics about flights taking place on the
                <a href="https://www.vatsim.net/" class="hover:underline text-blue-500">Vatsim Network</a>.
            </p>
        <p class="text-center text-stone-500 mt-2">
            For more information about this project, check out the About page.
        </p>

        <div class="mt-8">
            @include('_partials.today-stats')
        </div>
    </div>
@endsection
