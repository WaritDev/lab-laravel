@extends('layouts.main')

@section('content')
    <h1 class="text-4xl ml-10"> Artist List</h1>

    @can('create', \App\Models\Artist::class)
        <div class="mx-10 my-5">
            <a href="{{route('artists.create')}}" class="border-2 border-b-indigo-600 px-4 py-2 bg-amber-100">
                + Artist
            </a>
        </div>
    @endcan
    <ul class="mx-10">
        @foreach($artists as $artist)
            <li class="border border-b-gray-500 p-2">
                {{ $loop -> iteration }}
                <a href="{{route('artists.show',['artist' => $artist])}}">
                    {{ $artist -> name }}
                </a>
            </li>
        @endforeach
    </ul>

@endsection
