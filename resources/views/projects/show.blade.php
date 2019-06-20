@extends('layouts.app')

@section('content')

<header class="flex items-center mb-8">

    <div class="flex justify-between items-end w-full">
        <p class="text-gray-600 no-underline text-normal">
            <a href="/projects" class="text-gray-600 no-underline text-normal">My Projects</a> / {{ $project->title }}
        </p>
        <a href="/projects/create" class="button">Add Project</a>
    </div>

</header>

<main>
    <div class="lg:flex -mx-3">

        {{-- left side --}}
        <div class="lg:w-3/4 px-3 mb-6">

            <div class="mb-8">
                <h2 class="text-gray-600 no-underline text-xl mb-3">Tasks</h2>

                {{-- tasks --}}
                @foreach($project->tasks as $task)
                    <div class="card mb-3">{{ $task->body }}</div>
                @endforeach
                <div class="card mb-3">Task</div>
                <div class="card mb-3">Task</div>
                <div class="card mb-3">Task</div>
                <div class="card">Task</div>
            </div>
    
            <div class="mb-8">
                <h2 class="text-gray-600 no-underline text-xl mb-3">General Notes</h2>
    
                {{-- general notes --}}
                <textarea class="card w-full" style="min-height: 200px;">Lorem ipsum</textarea>
            </div>

        </div>

        {{-- right side --}}
        <div class="lg:w-1/4 px-3">

            @include('projects.card')

        </div>

    </div>
</main>



@endsection