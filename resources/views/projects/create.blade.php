@extends('layouts.app')

@section('content')

<div class="lg:w-1/2 lg:mx-auto bg-card bg-white p-6 md:py-12 md:px-16 rounded shadow">

    <h1 class="text-2xl font-normal mb-10 text-center">Just do it!</h1>

    <form method="POST" action="/projects">
        @csrf
        
        <div class="mb-5">
            <label for="title">Title</label>
            <input type="text" class="w-full" name="title" aria-describedby="helpId" placeholder="Title">
            <small id="helpId" class="">Enter the project name</small>
        </div>

        <div class="">
            <label for="description">Description</label>
            <textarea class="w-full" name="description" rows="3"></textarea>
        </div>

        <button type="submit" class="button">Create Project</button>

    </form>

    <a class="button" href="/projects">Go Back</a>

</div>

@endsection