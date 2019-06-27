<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css'/> --}}
</head>
<body class="theme-light bg-page text-default">
    <div id="app">
        <nav class="bg-header">
            <div class="container mx-auto">

                <div class="flex justify-between items-center py-4">
                    
                    <h1 class="text-lg">
                        <a class="flex flex-wrap md:flex-no-wrap flex-col md:flex-row items-center focus:outline-none ml-5 md:ml-0" href="{{ url('/projects') }}">
                            <img src="/svg/reznorganizer-logo.svg" alt="{{ config('app.name') }}" title="{{ config('app.name') }}" class="mr-2">
                            @guest
                                <strong><p class="reznor-logo">rezno[R]<span class="text-accent">ganizer</span></p></strong>
                            @else
                                <strong><p class="reznor-logo">{{ strtolower(Auth::user()->name) }}[S]<span class="text-accent">organizer</span></p></strong>
                            @endguest
                        </a>
                    </h1>
    
                    <div class="flex flex-col md:flex-row items-center mr-3 md:mr-0">
                        <!-- Right Side Of Navbar -->

                            <!-- Authentication Links -->
                            @guest
                                <div class="md:mr-4">
                                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                                </div>
                                @if (Route::has('register'))
                                    <div>
                                        <a href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </div>
                                @endif
                            @else
                                <theme-switcher></theme-switcher>

                                <dropdown align="right">
                                    <template v-slot:trigger>
                                        <button class="dropdown-button flex flex-col md:flex-row items-center md:mr-3"
                                            title="{{ ucwords(Auth::user()->name) }} ({{ Auth::user()->email }})">
                                            <img
                                                src="{{ gravatarUrl(Auth::user()->email) }}"
                                                alt="{{ Auth::user()->name }}'s avatar"
                                                class="rounded-full w-12 md:mr-2">
                                            <strong>{{ ucwords(Auth::user()->name) }}</strong>
                                        </button>
                                    </template>

                                    <template v-slot:default>
                                        <a href="{{ route('logout') }}" class="dropdown-item"
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                                    </template>
                                </dropdown>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>

                                {{-- <div class="text-right">
                                    <div class="flex flex-col flex-wrap md:flex-row md:items-center">
                                        <a href="{{ route('projects.index') }}"
                                            class="flex flex-col md:flex-row items-center md:mr-3"
                                            title="{{ ucwords(Auth::user()->name) }} ({{ Auth::user()->email }})">
                                            <img
                                                src="{{ gravatarUrl(Auth::user()->email) }}"
                                                alt="{{ Auth::user()->name }}'s avatar"
                                                class="rounded-full w-12 md:mr-2">
                                            <strong>{{ ucwords(Auth::user()->name) }}</strong>
                                        </a>

                                        <a href="{{ route('logout') }}"
                                            class="text-default-alt"
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
    
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>

                                </div> --}}
                            @endguest

                    </div>
                </div>

                
            </div>
        </nav>

        <main class="mx-auto container py-4">

            @yield('content')

        </main>
    </div>
</body>
</html>
