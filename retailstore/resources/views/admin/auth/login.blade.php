<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Sets the character encoding for the document to UTF-8 -->
    <meta charset="UTF-8">
    
    <!-- Sets the title of the page shown in the browser tab -->
    <title>Admin Login</title>
</head>
<body>
    <!-- Main heading of the page -->
    <h1>Admin Login</h1>

    <!-- Check if there are any validation errors from the backend -->
    @if ($errors->any())
        <!-- Display errors in a red-colored box -->
        <div style="color: red;">
            <ul>
                <!-- Loop through all errors and display each one in a list item -->
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form to submit admin login credentials -->
    <form action="{{ route('admin.login.submit') }}" method="POST">
        <!-- CSRF token for security, prevents cross-site request forgery -->
        @csrf
        
        <p>
            <!-- Label for email input -->
            <label for="email">Email:</label><br>
            <!-- Email input field; required to be filled before submission -->
            <input type="email" name="email" id="email" required>
        </p>

        <p>
            <!-- Label for password input -->
            <label for="password">Password:</label><br>
            <!-- Password input field; required to be filled before submission -->
            <input type="password" name="password" id="password" required>
        </p>

        <p>
            <!-- Submit button for the form -->
            <button type="submit">Login</button>
        </p>
    </form>

    <br>
    <!-- Button to go back to the homepage -->
    <a href="{{ url('/') }}"><button type="button">Back</button></a>
</body>
</html>
