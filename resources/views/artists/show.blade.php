@extends('layouts.main')

@section('content')
    <section class="mx-10">
        <h1 class="font-bold">Artist: {{$artist->name}}</h1>
        <p>
            Image: {{ $artist->image_path }}
        </p>
    </section>

    <section class="flex mx-10">
        @can('update', $artist)
            <a href="{{route('artists.edit', ['artist' => $artist])}}"
               class="px-4 py-2 inline-block border rounded-md border-gray-500">
                Edit Artist
            </a>
        @endcan

        @can('delete', $artist)
            <form onsubmit="return confirm('Are you sure to delete, this action can not be restore?')"
                action="{{route('artists.destroy', ['artist' => $artist])}}" method="POST">
                @csrf
                @method('DELETE')

                <button class="px-4 py-2 inline-block border rounded-md border-gray-500">
                    Delete Artist
                </button>
            </form>
        @endcan
    </section>

    <section class="mx-10 my-8">
        <ul>
            @foreach($artist->songs as $song)
                <li class="border border-amber-500 p-2">
                    {{ $song->title }}
                    ({{ $song->duration }} s.)
                </li>

            @endforeach
        </ul>
    </section>

    <pre>{{$artist}}</pre>
@endsection
