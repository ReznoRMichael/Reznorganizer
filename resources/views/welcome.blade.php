<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('favicon.ico') }}" rel="shortcut icon">

        <title>{{ config('app.name', 'Laravel') }}</title>

    </head>
    <body class="theme-light bg-page text-default">
        <div id="app" class="flex items-center justify-center relative h-auto mt-10">
            
            <div class="content flex flex-col justify-center">
                <div class="flex justify-center">
                    <div class="flex flex-wrap md:flex-no-wrap flex-col md:flex-row items-center focus:outline-none text-normal md:text-3xl">
                        <img src="svg/reznorganizer-logo.svg" alt="{{ config('app.name') }}" title="{{ config('app.name') }}" class="mr-2 w-24 h-auto">
                            @guest
                                <p class="reznor-logo">rezno[R]<span class="text-accent">ganizer</span></p>
                            @else
                                <p class="reznor-logo flex flex-wrap md:flex-no-wrap flex-col md:flex-row">{{ strtolower( preg_replace('/\s*/m','',Auth::user()->name) ) }}[S]<span class="text-accent">organizer</span></p>
                            @endguest
                    </div>
                </div>

                <div class="mx-auto mt-8 mb-10 text-center w-full md:w-2/3">
                    <h1 class="text-3xl my-5">Organize your life today...</h1>
                    <h2 class="text-xl my-5">...to become a better person than yesterday</h2>
                    <p class="mb-3">
                        Only few people realize, how important doing <strong>checklists</strong> is in our lives. Our minds can easily get overwhelmed by even the simplest tasks that we think we know very well. Especially if we are tired, stressed or worried, even tasks that we are doing regularly every day can become chaotic. And therefore — make us feel lost, irritated, constantly tired.
                    </p>
                    <p class="mb-3">
                        Without first organizing our lives, we are easily getting nervous, burdened by daily reality and we loose the feeling of making any progress, which discourages us quickly, makes us loose hope and belief in our skills or future possibilities — which draws us slowly to procrastination and ultimately giving up or letting go as a long-term result.
                    </p>
                    <h2 class="text-xl my-5">
                        Why do you think every modern game is tracking your current progress and saving it automatically?
                    </h2>
                    <p class="mb-3">
                        Some games (like The Witcher 3) even briefly show you what happened in your last gaming session. Because <strong>we all forget easily</strong> even what we did yesterday. Without the habit of making simple lists (you can call them <em>"savegames"</em> if you wish), we loose track of whatever we are currently doing, what was its original purpose, the direction we were heading to. Our minds feel constantly overwhelmed by the amount of things/work that is left to do, instead of making them step by step. We cannot think clearly because of all this unorganized burden we are placing on our minds. We feel that we are slowly loosing control of our own lives. We get depressed.
                    </p>
                    <p class="mb-3">
                        There's a simple remedy which can help dealing with it: <strong>make checklists</strong>. Make them for everything. For all the daily or regular things you do every day or want to do in the future, like list for reading books, watching movies, playing games, shopping, recipes. Even for things that you are currently doing or learning, so that you may review what you've already did and/or learned at any time.
                    </p>
                    <p class="mb-3">
                        You'll be surprised, how quickly we humans forget about the things that we think are really simple to remember at the present moment. <b>Forgetting</b> is absolutely normal for any human being. It's <b>remembering</b> that is really hard. <strong>Never trust your memory.</strong> Write everything and everywhere so that your mind can find its peace — and that your life may become better as a result.
                    </p>
                </div>

                @if (Route::has('login'))
                    <div class="flex items-center justify-center mb-10">
                        @auth
                            <a class="button mx-3" href="{{ url('/home') }}">Home</a>
                            <a class="button mx-3" href="{{ action('ProjectsController@index') }}">Your Entries</a>
                        @else
                            <a class="button mx-3" href="{{ route('login') }}">Login</a>

                            @if (Route::has('register'))
                                <a class="button mx-3" href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif

            </div>
        </div>
    </body>
</html>
