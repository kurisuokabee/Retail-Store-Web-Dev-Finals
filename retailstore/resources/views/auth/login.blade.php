@extends('layouts.app')

@section('title', 'Login')

@section('content')

    <!-- Force-load login.css like other pages -->
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
                <h1>Welcome!</h1>
                <p class="auth-sub">Sign in to your account</p>
            </div>

            <!-- Validation errors -->
            @if ($errors->any())
                <div class="alert alert-error auth-errors" role="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('auth.login') }}" class="auth-form" novalidate>
                @csrf

                <label for="email" class="label">Email</label>
                <input class="form-input" type="email" id="email" name="email" required autofocus value="{{ old('email') }}">

                <label for="password" class="label">Password</label>
                <input class="form-input" type="password" id="password" name="password" required>

                <div class="auth-actions">
                    <button type="submit" class="btn btn-primary">Log In</button>

                    <!-- keep Register/Admin navigation behavior but use links for semantics -->
                    <div class="auth-links">
                        {{-- <a href="{{ route('auth.register') }}" class="btn btn-ghost small">Register</a> --}}
                        <a href="{{ route('admin.login') }}" class="btn btn-ghost small">Admin Login</a>
                    </div>
                </div>
            </form>
        </div>
    </main>

@endsection
