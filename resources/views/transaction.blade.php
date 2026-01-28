@extends('layouts.main')

@section('content')
<div class="max-w-screen-xl px-4 py-20 mx-auto sm:px-6 lg:px-8 font-mono">
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        <div class="bg-gray-100 px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">Transaction Details</h3>
        </div>
        
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-gray-500 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Transaction Hash:
                </div>
                <div class="md:col-span-2 break-all text-blue-600 font-bold">
                    {{ $hash }}
                </div>
            </div>

            <hr class="border-gray-100">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-gray-500 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Status:
                </div>
                <div class="md:col-span-2">
                    @if($status === 'Success')
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">
                            Success
                        </span>
                    @else
                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">
                            {{ $status }}
                        </span>
                    @endif
                </div>
            </div>
            
                <hr class="border-gray-100">
                
                <div class="pt-4">
                    <p class="text-sm text-gray-500 mb-2">Try checking other mock transactions:</p>
                    <a href="{{ url('/tx-check?hash=0x712a8b...fakehash...99') }}" class="text-blue-600 hover:underline text-sm mr-4">Sample Tx 1</a>
                    <a href="{{ url('/tx-check?hash=0x999b8c...fakehash...11') }}" class="text-blue-600 hover:underline text-sm">Sample Tx 2</a>
                </div>
        </div>
    </div>
</div>
@endsection