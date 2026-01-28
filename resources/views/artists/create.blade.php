@extends('layouts.main')

@section('content')
    <section class="mx-10">
        <h1 class="text-3xl">
            Add New Artist
        </h1>

        <form action="{{route('artists.store')}}" method="POST" class="p-4 bg-indigo-100">
            @csrf
            <div>
                <label for="name">
                    Artist Name
                </label>
                @error('name')
                <p class="text-red-500 text-sm">
                    {{ $message }}
                </p>
                @enderror
                <input type="text" name="name" id="name" class="border border-amber-400 p-2"
                value="{{ old('name', '') }}">
            </div>
            <div class="mt-4 center">
                <button type="submit" class="border px-4 py-2 bg-amber-200 cursor-pointer">
                    Add Artist
                </button>
            </div>
        </form>

            <div class="mb-5">
                <label for="image" class="block mb-2 font-bold text-gray-600">Image</label>
                @error('image')
                <p class="text-red-500 text-sm">
                    {{ $message }}
                </p>
                @enderror
                <input type="file" id="image" name="image" autocomplete="off"
                       value="{{ old('image', '') }}"
                       class="border border-gray-300 shadow p-3 w-full rounded
                      @error('image') border-red-400 @enderror" />
            </div>

            <button type="submit" class="block mx-auto bg-blue-500 text-white font-bold px-4 py-2 rounded-lg">
                Submit
            </button>
        </form>
    </section>
@endsection
