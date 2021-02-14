@extends('layouts.app')

@section('title')
    {{ config('app.name') }} - About
@endsection

@section('content')
    <div class="container mx-auto mt-8">
        <div class="text-center sm:w-1/2 w-full mx-auto">
            <h1 class="text-3xl">What is VatFlights?</h1>
            <p class="text-stone-500 mt-2 ml-3 mr-3 text-base leading-relaxed">
                Quite simply I had a curiosity and want to see some general data in one place from the Vatsim network and while I have some private CLI tools to
                get this data and display it, I wanted to store it in some kind of persistent storage to view over a time period and to be able to do various searches over that
                data. Hence this idea came about.
            </p>
        </div>
        <div>
            @include('_partials.faqs')
        </div>
    </div>
@endsection
