<x-app-layout>
    <div class="flex h-screen">
        <div class="bg-indigo-600 px-4 py-2 lg:w-1/4">
            <svg xmlns="http://www.w3.org/2000/svg" class="inline h-8 w-8 text-white lg:hidden" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <div class="hidden lg:block">
                <div class="my-2 mb-6">
                    <h1 class="text-2xl font-bold text-white">Dashboard</h1>
                </div>
                <ul>
                    <li @class([
                        'mb-2 rounded hover:bg-gray-800 hover:shadow',
                        'bg-gray-800 shadow' => request()->routeIs('dashboard'),
                    ])>
                        <a href="#" class="inline-block h-full w-full px-3 py-2 font-bold text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-mt-1 mr-2 inline-block h-6 w-6"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Home
                        </a>
                    </li>
                    <li @class([
                        'mb-2 rounded hover:bg-gray-800 hover:shadow',
                        'bg-gray-800 shadow' => request()->routeIs('tickets'),
                    ])>
                        <a href="#" class="inline-block h-full w-full px-3 py-2 font-bold text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="-mt-1 mr-2 inline-block h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                            </svg>
                            Tickets
                        </a>
                    </li>
                    <li @class([
                        'mb-2 rounded hover:bg-gray-800 hover:shadow',
                        'bg-gray-800 shadow' => request()->routeIs('users'),
                    ])>
                        <a href="#" class="inline-block h-full w-full px-3 py-2 font-bold text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="-mt-1 mr-2 inline-block h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                            Users
                        </a>
                    </li>
                    {{-- <li class="mb-2 rounded hover:bg-gray-800 hover:shadow">
                        <a href="#" class="inline-block h-full w-full px-3 py-2 font-bold text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-mt-1 mr-2 inline-block h-6 w-6"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Ticket Logs
                        </a>
                    </li> --}}
                    <li @class([
                        'mb-2 rounded hover:bg-gray-800 hover:shadow',
                        'bg-gray-800 shadow' => request()->routeIs('categories'),
                    ])>
                        <a href="#" class="inline-block h-full w-full px-3 py-2 font-bold text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="-mt-1 mr-2 inline-block h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3" />
                            </svg>
                            Categories
                        </a>
                    </li>
                    <li @class([
                        'mb-2 rounded hover:bg-gray-800 hover:shadow',
                        'bg-gray-800 shadow' => request()->routeIs('labels'),
                    ])>
                        <a href="#" class="inline-block h-full w-full px-3 py-2 font-bold text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="-mt-1 mr-2 inline-block h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                            </svg>
                            Labels
                        </a>
                    </li>
                    <hr class="my-4">
                    <li class="mb-2 mt-4 rounded hover:bg-gray-800 hover:shadow">
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                                class="inline-block h-full w-full px-3 py-2 font-bold text-white"
                                onclick="event.preventDefault();this.closest('form').submit();" tabindex="-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="-mt-1 mr-2 inline-block h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                </svg>
                                Logout
                            </a>
                        </form>
                    </li>
                </ul>
            </div>

        </div>
        <div class="w-full bg-gray-200 px-4 py-2 lg:w-full">
            <div class="container mx-10 mt-12">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-app-layout>
