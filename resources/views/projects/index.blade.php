@extends('layouts.app')

@section('content')

<header class="flex items-center">

    <div class="flex justify-between items-end w-full">
        <h2 class="text-default-alt no-underline text-normal">My Entries</h2>
        <a href="{{ action('ProjectsController@create') }}" class="button" @click.prevent="$modal.show('create-project-modal')">Add New Entry</a>
    </div>

</header>

<main class="lg:flex lg:flex-wrap -mx-3 p-4 md:py-4">

    @forelse($projects as $project)

    <div class="lg:w-1/2 xl:w-1/3 p-3">
        @include('projects.card')
    </div>

    @empty
        <div class="mx-auto text-default-alt">
            It's quite empty here. Want to <a href="{{ action('ProjectsController@create') }}"
            @click.prevent="$modal.show('create-project-modal')"><b>add a new entry</b></a>?
        </div>
    @endforelse

</main>

<create-project-modal></create-project-modal>

@endsection