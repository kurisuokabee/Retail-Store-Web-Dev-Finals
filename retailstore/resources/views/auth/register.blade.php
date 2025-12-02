@extends('layouts.app')

@section('title', 'Budega Philippines | Register')

@section('content')

    <!-- Force-load login.css so register uses the same auth styling as login -->
    @php
        $publicCssPath = public_path('css/login.css');
        $resourceCssPath = resource_path('css/login.css');
    @endphp

    @if (file_exists($publicCssPath))
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/login.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
        <style>
            {!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}
        </style>
    @endif

    <!-- Header / Navigation -->
    <header>
        @include('components.navbar')
    </header>

    <main class="auth-page">
        <div class="auth-card">
            <div class="auth-brand">
                <h1>Create your account</h1>
                <p class="auth-sub">Sign up to start shopping</p>
            </div>

            <!-- Validation errors -->
            @if ($errors->any())
                <div class="alert alert-error auth-errors" role="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('auth.register') }}" class="auth-form" novalidate>
                @csrf

                <label for="username" class="label">Name</label>
                <input class="form-input" type="text" id="username" name="username" required autofocus value="{{ old('username') }}">

                <label for="email" class="label">Email</label>
                <input class="form-input" type="email" id="email" name="email" required value="{{ old('email') }}">

                <label for="password" class="label">Password</label>
                <input class="form-input" type="password" id="password" name="password" required>

                <label for="password_confirmation" class="label">Confirm Password</label>
                <input class="form-input" type="password" id="password_confirmation" name="password_confirmation" required>

                <div class="auth-actions">
                    <button type="submit" class="btn btn-primary">Register</button>

                    <div class="auth-links">
                        <a href="{{ route('login') }}" class="btn btn-ghost small">Back to Login</a>
                    </div>
                </div>
            </form>
        </div>
    </main>

@endsection
