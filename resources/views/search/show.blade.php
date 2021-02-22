@extends('layouts.app')

@section('title')
    {{ config('app.name') }} - Search
@endsection

@section('content')
    <div class="container mx-auto mt-8">
        <div class="text-center sm:w-1/2 w-full mx-auto">
            <h1 class="text-3xl mb-1">Tracked Airlines</h1>
            <p class="text-stone-500 mt-2 ml-3 mr-3 text-base leading-relaxed mb-4">
                Currently tracked airline are listed below.
            </p>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mx-auto mb-8">
                @foreach($airlines as $airline)
                    <div class="flex flex-col bg-havelock-500 rounded-md py-2 px-2">
                        <span>
                            <a href="{{ route('airlines.show', $airline->uuid) }}" class="text-quill-500 hover:text-blue-200">
                                {{ $airline->name }}
                            </a>
                        </span>
                    </div>
                @endforeach
                </div>
            {{ $airlines->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection
