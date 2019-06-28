@extends('layouts.app')

@section('content')

<header class="flex items-center mb-8">

    <div class="flex flex-col md:flex-row justify-between items-end w-full">
        <p class="text-default-alt font-normal">
            <a href="{{ action('ProjectsController@index') }}" class="text-default-alt no-underline font-normal hover:text-accent">My Entries</a> / {{ $project->title }}
        </p>

        <div class="flex items-center mt-3 md:mt-0">

            @foreach($project->members as $member)
            <img
                src="{{ gravatarUrl($member->email) }}"
                alt="{{ $member->name }}'s avatar"
                title="{{ ucwords($member->name) }} (invited)"
                class="rounded-full w-10 mr-2 border-solid border-2 border-rtgray">
            @endforeach

            <img
                src="{{ gravatarUrl($project->owner->email) }}"
                alt="{{ $project->owner->name }}'s avatar"
                title="{{ ucwords($project->owner->name) }} (owner)"
                class="rounded-full w-10 mr-2 border-solid border-2 border-accent">

            <a href="{{ $project->path().'/edit' }}" class="button ml-6">Edit Entry</a>

        </div>
    </div>

</header>

<main>
    <div class="lg:flex -mx-3">

        {{-- left side --}}
        <div class="lg:w-3/4 px-3 mb-6">

            <div class="mb-8">
                <h2 class="text-default-alt no-underline text-xl mb-3">Task List</h2>

                {{-- tasks --}}
                @foreach($project->tasks as $task)
                    <div class="card mb-3">
                        <form action="{{ $task->path() }}" method="post">
                            @method('PATCH')
                            @csrf
                            <div class="flex items-center">
                            <input type="text" name="body" value="{{ $task->body }}"
                                class="w-full bg-card {{ $task->completed ? 'text-default-muted line-through' : '' }}">
                                <div class="checkbox">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="completed"
                                            onchange="this.form.submit();" {{ $task->completed ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
                    <form action="{{ $project->path().'/tasks' }}" method="post">
                        @csrf
                        <input type="text" name="body" class="card bg-card mb-3 w-full" placeholder="Type a task name and press Enter to save...">
                    </form>
            </div>
    
            <div class="mb-8">
                <h2 class="text-default-alt no-underline text-xl mb-3">Additional info</h2>
    
                {{-- general notes --}}
                <form action="{{ $project->path() }}" method="post">
                    @method('PATCH')
                    @csrf
                    <textarea name="notes" class="card w-full mb-4" style="min-height: 200px;" placeholder="Add more information here...">{{ $project->notes }}</textarea>
                    <button type="submit" class="button">Save Notes</button>

                    @include('_errors')

                </form>
            </div>

        </div>

        {{-- right side --}}
        <div class="lg:w-1/4 px-3 lg:mt-10">

            @include('projects.card')
            @include('projects.activity.card')

            @can('manage', $project)
            @include('projects.invite')
            @endcan

        </div>

    </div>
</main>



@endsection