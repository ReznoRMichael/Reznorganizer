@extends('layouts.app')

@section('content')

<header class="flex items-center">

    <div class="flex justify-between items-end w-full">
        <h2 class="text-gray-600 no-underline text-normal">My Entries</h2>
        <a href="/projects/create" class="button rt-orange">Add New Entry</a>
    </div>

</header>

<main class="lg:flex lg:flex-wrap -mx-3 py-4">

    @forelse($projects as $project)

    <div class="lg:w-1/3 p-3">
        @include('projects.card')
    </div>

    @empty
        <div class="text-gray-500">It's quite empty here. Want to add an entry?</div>
    @endforelse

</main>

@endsection