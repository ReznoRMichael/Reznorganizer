@extends('layouts.app')

@section('content')

<header class="flex items-center mb-8">

    <div class="flex justify-between items-end w-full">
        <p class="text-gray-600 no-underline text-normal">
            <a href="/projects" class="text-gray-600 no-underline text-normal">My Notes</a> / {{ $project->title }}
        </p>
        <a href="{{ $project->path().'/edit' }}" class="button">Edit Note</a>
    </div>

</header>

<main>
    <div class="lg:flex -mx-3">

        {{-- left side --}}
        <div class="lg:w-3/4 px-3 mb-6">

            <div class="mb-8">
                <h2 class="text-gray-600 no-underline text-xl mb-3">To Do List</h2>

                {{-- tasks --}}
                @foreach($project->tasks as $task)
                    <div class="card mb-3">
                        <form action="{{ $task->path() }}" method="post">
                            @method('PATCH')
                            @csrf
                            <div class="flex items-center">
                            <input type="text" name="body" value="{{ $task->body }}" class="w-full {{ $task->completed ? 'text-gray-400' : '' }}">
                                <input type="checkbox" name="completed" onchange="this.form.submit();" {{ $task->completed ? 'checked' : '' }}>
                            </div>
                        </form>
                    </div>
                @endforeach
                    <form action="{{ $project->path().'/tasks' }}" method="post">
                        @csrf
                        <input type="text" name="body" class="card mb-3 w-full" placeholder="Add a new task...">
                    </form>
            </div>
    
            <div class="mb-8">
                <h2 class="text-gray-600 no-underline text-xl mb-3">Additional info</h2>
    
                {{-- general notes --}}
                <form action="{{ $project->path() }}" method="post">
                    @method('PATCH')
                    @csrf
                    <textarea name="notes" class="card w-full mb-4" style="min-height: 200px;" placeholder="Add more information here...">{{ $project->notes }}</textarea>
                    <button type="submit" class="button">Save Note</button>

                    @include('projects._errors')

                </form>
            </div>

        </div>

        {{-- right side --}}
        <div class="lg:w-1/4 px-3 lg:mt-10">

            @include('projects.card')

            @include('projects.activity.card')

        </div>

    </div>
</main>



@endsection