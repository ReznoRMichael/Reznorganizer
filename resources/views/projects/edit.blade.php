@extends('layouts.app')

@section('content')

<div class="lg:w-1/2 lg:mx-auto bg-card bg-white p-6 md:py-12 md:px-16 rounded shadow">

    <h1 class="text-2xl font-normal mb-10 text-center">Edit your entry</h1>

    <form method="POST" action="{{ $project->path() }}">
        @method('PATCH')

        @include('projects._form', [
            'buttonText' => 'Update Entry',
            'descriptionText' => $project->description
        ])

    </form>

</div>

@endsection