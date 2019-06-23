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
<body class="bg-gray-200">
    <div id="app">
        <nav class="bg-white">
            <div class="container mx-auto">

                <div class="flex justify-between items-center py-4">
                    
                    <h1 class="text-lg">
                        <a class="flex navbar-brand items-center" href="{{ url('/projects') }}">
                            <img src="/svg/reznorganizer-logo.svg" alt="{{ config('app.name') }}" title="{{ config('app.name') }}" class="mr-2">
                            @guest
                                <strong><p class="reznor-logo">rezno[R]<span class="text-orange-600">ganizer</span></p></strong>
                            @else
                                <strong><p class="reznor-logo">{{ strtolower(Auth::user()->name) }}[S]<span class="text-orange-600">organizer</span></p></strong>
                            @endguest
                        </a>
                    </h1>
    
                    <div>
                        <!-- Right Side Of Navbar -->
                        <ul>
                            <!-- Authentication Links -->
                            @guest
                                <li>
                                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li>
                                        <a href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li>
                                    <a href="{{ route('projects.index') }}">
                                        {{ Auth::user()->name }}
                                    </a>
    
                                    <div>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
    
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
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
