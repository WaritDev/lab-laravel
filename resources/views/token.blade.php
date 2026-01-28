@extends('layouts.main')

@section('content')
<div class="max-w-screen-xl px-4 py-20 mx-auto sm:px-6 lg:px-8 font-mono">
    <div class="max-w-2xl mx-auto bg-white border border-gray-200 rounded-xl shadow-lg p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-3xl font-bold text-gray-900">
                Token Details
            </h2>
            <span class="px-3 py-1 text-sm text-green-800 bg-green-100 rounded-full">
                Live Market
            </span>
        </div>

        <div class="border-t border-gray-200 pt-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Symbol</p>
                    <p class="text-2xl font-bold {{ $tokenData['color'] }}">{{ $symbol }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Current Price</p>
                    <p class="text-2xl font-bold text-gray-900">
                        ${{ $tokenData['price'] }}
                    </p>
                </div>
            </div>
            
            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-500">Asset Name</p>
                <p class="text-lg font-semibold text-gray-800">{{ $tokenData['name'] }}</p>
            </div>
        </div>
    </div>
</div>
@endsection