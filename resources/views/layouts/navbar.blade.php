<nav class="bg-white border-b border-gray-200 py-4 font-mono sticky top-0 z-50">
    <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto">
        <a href="{{ url('/') }}" class="flex items-center group">
            <span class="self-center text-xl font-bold whitespace-nowrap tracking-tight">
                Block<span class="text-indigo-600">Explorer</span>
            </span>
        </a>

        @guest
            <div class="flex items-center lg:order-2 ml-auto space-x-2">
                <a href="{{ url('/login') }}"
                   class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 focus:outline-none shadow-lg shadow-indigo-500/30 transition-all flex items-center">
                    <svg class="w-4 h-4 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    Login
                </a>

                <a href="{{ url('/register') }}"
                   class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 focus:outline-none shadow-lg shadow-indigo-500/30 transition-all flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    Register
                </a>

                <button data-collapse-toggle="mobile-menu-2" type="button"
                        class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                        aria-controls="mobile-menu-2" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        @endguest

        @auth
        <div class="items-center justify-between w-full lg:flex lg:w-auto lg:order-1 hidden" id="mobile-menu-2">
            <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">

                <li>
                    <a href="{{ url('/') }}"
                        class="block py-2 pl-3 pr-4 border-b border-gray-100 lg:border-0 lg:p-0 transition-colors
                        {{ Request::is('/') ? 'text-indigo-600 font-extrabold lg:text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                        Dashboard
                    </a>
                </li>

                <li>
                    <span class="block py-2 pl-3 pr-4 text-xs text-gray-400 uppercase tracking-wider lg:hidden">Markets</span>
                </li>

                <li>
                    <a href="{{ url('/token/BTC') }}"
                        class="block py-2 pl-3 pr-4 border-b border-gray-100 lg:border-0 lg:p-0 transition-colors
                        {{ Request::is('token/BTC') ? 'text-indigo-600 font-extrabold lg:text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                        Bitcoin <span class="text-xs text-gray-400 ml-1 font-normal">(Path)</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/token/ETH') }}"
                        class="block py-2 pl-3 pr-4 border-b border-gray-100 lg:border-0 lg:p-0 transition-colors
                        {{ Request::is('token/ETH') ? 'text-indigo-600 font-extrabold lg:text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                        Ethereum <span class="text-xs text-gray-400 ml-1 font-normal">(Path)</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/tx-check?hash=Example') }}"
                        class="block py-2 pl-3 pr-4 border-b border-gray-100 lg:border-0 lg:p-0 transition-colors
                        {{ Request::is('tx-check*') ? 'text-indigo-600 font-extrabold lg:text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                        Scanner <span class="text-xs text-gray-400 ml-1 font-normal">(Query)</span>
                    </a>
                </li>

                <form action="{{route('logout')}}" method="POST">
                    @csrf
                    <button type="submit">
                        Logout
                    </button>
                </form>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>
