@extends('layouts.main')

@section('content')
    <section class="mx-10">
        <h1 class="text-3xl">
            Edit Artist
        </h1>

        <form action="{{route('artists.update', ['artist' => $artist])}}" method="POST" class="p-4 bg-indigo-100">
            @csrf
            @method('PUT')
            <div>
                <label for="name">
                    Artist Name
                </label>
                @error('name')
                <p class="text-red-500 text-sm">
                    {{ $message }}
                </p>
                @enderror
                <input type="text" name="name" id="name" class="border border-amber-400 p-2 "
                       value="{{old('name',$artist->name)}}">
            </div>
            <div class="mt-4 center">
                <button type="submit" class="border px-4 py-2 bg-amber-200 cursor-pointer">
                    Update
                </button>
            </div>
        </form>
    </section>
@endsection
