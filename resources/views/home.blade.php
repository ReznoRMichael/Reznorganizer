@extends('layouts.app')

@section('content')

<div class="flex text-center justify-center">
    <div class="w-full">
        <div class="card mb-5">
            <h2 class="card-header text-2xl font-normal mb-5">Welcome to your own personal Organizer!</h2>

            <div class="card-body">
                {{-- @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif --}}

                You are currently logged in as <strong>{{ ucwords(Auth::user()->name) }}</strong> ({{ Auth::user()->email }})
            </div>

        </div>

        <div class="card flex flex-col">
            <h3 class="card-header text-lg font-normal mb-5">Click here to add, view and manage your entries:</h2>

            <a class="mx-auto button" href="{{ action('ProjectsController@index') }}">Your Entries</a>

            <h2 class="card-header text-2xl font-normal my-5">Currently logged in users can:</h2>
            
            <ul class="list-disc list-inside mx-auto text-left">
                <li>Create/Edit/Delete new entries with short descriptions</li>
                <li>Add/Edit/Delete tasks inside entries</li>
                <li>Mark tasks as completed or not completed</li>
                <li>Add additional notes to entries</li>
                <li>View update history for each entry</li>
                <li>Invite other registered users to their entries</li>
                <li>Change themes on the fly (light or dark)</li>
            </ul>
        </div>
    </div>
</div>
@endsection
