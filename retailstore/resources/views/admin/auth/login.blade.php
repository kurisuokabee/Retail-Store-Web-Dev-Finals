@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')

    <!-- Force-load login.css so admin login matches the site's auth styling -->
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
                <h1>Admin Portal</h1>
                <p class="auth-sub">Sign in to manage the store</p>
            </div>

            <!-- Validation errors -->
            @if ($errors->any())
                <div class="alert alert-error auth-errors" role="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="auth-form" novalidate>
                @csrf

                <label for="email" class="label">Email</label>
                <input class="form-input" type="email" id="email" name="email" required autofocus value="{{ old('email') }}">

                <label for="password" class="label">Password</label>
                <input class="form-input" type="password" id="password" name="password" required>

                <div class="auth-actions">
                    <button type="submit" class="btn btn-primary">Log In</button>

                    <div class="auth-links">
                        <a href="{{ url('/') }}" class="btn btn-ghost small">Back</a>
                        {{-- optional: link to user login if desired --}}
                        {{-- <a href="{{ route('login') }}" class="btn btn-ghost small">User Login</a> --}}
                    </div>
                </div>
            </form>
        </div>
    </main>

@endsection
