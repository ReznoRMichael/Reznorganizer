@extends('layouts.app')

@section('content')

<div class="flex text-center justify-center">
    <div class="w-full">
        <div class="card">
            <h2 class="card-header text-2xl font-normal mb-5">Dashboard</h2>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                Logged in as <strong>{{ ucwords(Auth::user()->name) }}</strong> ({{ Auth::user()->email }})
            </div>
        </div>
    </div>
</div>
@endsection
