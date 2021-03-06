@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('login') }}"
          class="lg:w-1/2 lg:mx-auto bg-card bg-white py-12 px-16 rounded shadow">
        @csrf

        <h1 class="text-2xl font-normal mb-10 text-center">Login</h1>

        <div class="field mb-6">
            <label class="label text-sm mb-2 block" for="email">Email Address</label>

            <div class="control">
                <input id="email"
                       type="email"
                       class="input bg-transparent border border-rtgray rounded p-2 text-xs w-full{{ $errors->has('email') ? ' is-invalid' : '' }}"
                       name="email"
                       value="{{ old('email') }}"
                       required>
            </div>
        </div>

        <div class="field mb-6">
            <label class="label text-sm mb-2 block" for="password">Password</label>

            <div class="control">
                <input id="password"
                       type="password"
                       class="input bg-transparent border border-rtgray rounded p-2 text-xs w-full{{ $errors->has('password') ? ' is-invalid' : '' }}"
                       name="password"
                       required>
            </div>
        </div>

        <div class="field mb-6">
            <div class="control flex justify-center items-center">
                {{-- <input class="form-check-input mr-2"
                       type="checkbox"
                       name="remember"
                       id="remember"
                        {{ old('remember') ? 'checked' : '' }}>

                <label class="text-sm" for="remember">
                    Remember Me
                </label> --}}

                <div class="checkbox">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                            <span class="checkmark" style="top:0; left:-6px;"></span>
                            <p style="font-size:1rem;">Remember Me</p>
                    </label>
                </div>
                
            </div>
        </div>

        <div>
            <div class="flex flex-col">
                <button type="submit" class="button mx-auto mb-5">
                    Login
                </button>

                @if (Route::has('password.request'))
                    <a class="text-sm mx-auto" href="{{ route('password.request') }}">
                        Forgot Your Password?
                    </a>
                @endif
            </div>
        </div>

        @include('_errors')

    </form>
@endsection
