@extends('layouts.app')

@section('content')

        <h1>Create a Project</h1>

        <form method="POST" action="/projects">
            @csrf
            
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="title" aria-describedby="helpId" placeholder="Title">
                <small id="helpId" class="form-text text-muted">Enter the project name</small>
            </div>
    
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
            </div>
    
            <button type="submit" class="button">Create Project</button>
    
        </form>

        <a class="button" href="/projects">Go Back</a>

@endsection