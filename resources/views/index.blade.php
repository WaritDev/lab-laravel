@extends('layouts.main')

@section('content')
<section class="h-screen bg-white font-mono">
    <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12">

        <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl">
            Explore the <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-600">Blockchain</span> Universe
        </h1>

        <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48">
            @auth

            @endauth Real-time data, transparency, and seamless transactions. Track tokens, verify hashes, and connect with the future of decentralized finance.
        </p>

        <div class="grid md:grid-cols-3 gap-6 text-left max-w-5xl mx-auto">

            <a href="{{ url('/token/BTC') }}" class="group block p-6 bg-white border border-gray-200 rounded-xl shadow hover:bg-gray-50 transition-all hover:-translate-y-1">
                <div class="w-10 h-10 mb-4 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">Market Data</h5>
                <p class="font-normal text-gray-700 text-sm">View real-time prices for BTC, ETH, and SOL. <br><span class="text-xs text-gray-400">(Path Param Demo)</span></p>
            </a>

            <a href="{{ url('/tx-check?hash=0xSampleHash') }}" class="group block p-6 bg-white border border-gray-200 rounded-xl shadow hover:bg-gray-50 transition-all hover:-translate-y-1">
                <div class="w-10 h-10 mb-4 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">TX Scanner</h5>
                <p class="font-normal text-gray-700 text-sm">Verify transaction status by hash address. <br><span class="text-xs text-gray-400">(Query Param Demo)</span></p>
            </a>

            <a href="{{ url('/contact') }}" class="group block p-6 bg-white border border-gray-200 rounded-xl shadow hover:bg-gray-50 transition-all hover:-translate-y-1">
                <div class="w-10 h-10 mb-4 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                </div>
                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">Developers</h5>
                <p class="font-normal text-gray-700 text-sm">Meet the team behind the Landwind Chain. <br><span class="text-xs text-gray-400">(Contact Page)</span></p>
            </a>
        </div>

    </div>
</section>
@endsection
