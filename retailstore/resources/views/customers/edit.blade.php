@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
<div>
    <!-- Main heading for the edit customer page -->
    <h1>Edit Customer</h1>

    <!-- Display validation errors if any exist from the backend -->
    @if ($errors->any())
        <div style="color: red; margin-bottom: 20px;">
            <!-- Loop through all errors and display each in a paragraph -->
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Edit customer form -->
    <form action="{{ route('customers.update', $customer->customer_id) }}" method="POST">
        <!-- CSRF token for security -->
        @csrf
        <!-- Specify PUT method for updating resources -->
        @method('PUT')

        <!-- Username input field -->
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"
               value="{{ old('username', $customer->username) }}" required>
        <br>

        <!-- Email input field -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"
               value="{{ old('email', $customer->email) }}" required>
        <br>

        <!-- Password input field (optional, only update if filled) -->
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"
               placeholder="Enter new password">
        <br>

        <!-- First name input field -->
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name"
               value="{{ old('first_name', $customer->first_name) }}" required>
        <br>

        <!-- Last name input field -->
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name"
               value="{{ old('last_name', $customer->last_name) }}" required>
        <br>

        <!-- Date of birth input field -->
        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth"
               value="{{ old('date_of_birth', $customer->date_of_birth) }}">
        <br>

        <!-- Phone input field -->
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone"
               value="{{ old('phone', $customer->phone) }}">
        <br>

        <!-- Address textarea -->
        <label for="address">Address:</label>
        <textarea id="address" name="address" rows="4" cols="40">{{ old('address', $customer->address) }}</textarea>
        <br>

        <!-- Submit button to save changes -->
        <button type="submit">Save Changes</button>
    </form>

    <!-- Button to go back to the previous page -->
    <button onclick="window.history.back()">Back</button>
</div>
@endsection
