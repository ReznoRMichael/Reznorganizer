@extends('layouts.app')

@section('content')

<div class="lg:w-1/2 lg:mx-auto bg-card bg-white p-6 md:py-12 md:px-16 rounded shadow">

    <h1 class="text-2xl font-normal mb-10 text-center">You have the power of creation</h1>

    <form method="POST" action="/projects">

        @include('projects._form', [
            'buttonText' => 'Create Entry',
            'descriptionText' => '',
            'project' => new App\Project
        ])

    </form>

</div>

@endsection