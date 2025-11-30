<div>
    <!-- Main heading for the registration page -->
    <h1>Register</h1>

    <!-- Display validation errors if any exist from the backend -->
    @if ($errors->any())
        <div style="color: red; margin-bottom: 20px;">
            <!-- Loop through all errors and display each in a paragraph -->
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Registration form -->
    <form method="POST" action="{{ route('auth.register') }}">
        <!-- CSRF token for security to prevent cross-site request forgery -->
        @csrf

        <!-- Username input field -->
        <div>
            <label for="username">Name:</label>
            <input type="text" id="name" name="username" required autofocus>
        </div>

        <!-- Email input field -->
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <!-- Password input field -->
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <!-- Confirm password input field -->
        <div>
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <!-- Submit button to register the account -->
        <div>
            <button type="submit">Register</button>
        </div>
    </form>

    <!-- Button to go back to the login page -->
    <button onclick="location.href='{{ route('login') }}'">Back to Login</button>
</div>
