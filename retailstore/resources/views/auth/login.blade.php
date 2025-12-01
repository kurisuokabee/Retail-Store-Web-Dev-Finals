@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div>
    <!-- Main heading of the login page -->
    <h1>Retail Store Login</h1>

    <!-- Display validation errors if there are any from the backend -->
    @if ($errors->any())
        <div style="color: red; margin-bottom: 20px;">
            <!-- Loop through all errors and display each in a paragraph -->
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Login form for users -->
    <form method="POST" action="{{ route('auth.login') }}">
        <!-- CSRF token for security -->
        @csrf

        <!-- Email input field -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required autofocus>
        <br>

        <!-- Password input field -->
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>

        <!-- Submit button for login -->
        <button type="submit">Log In</button>
    </form> 

    <br>

    <!-- Button to go to user registration page -->
    <form action="{{ route('auth.register') }}" method="GET">
        <button type="submit">Register Account</button>
    </form>

    <!-- Button to go to admin login page -->
    <form action="{{ route('admin.login') }}" method="GET">
        <button type="submit">Admin Login</button>
    </form>
</div>
@endsection
