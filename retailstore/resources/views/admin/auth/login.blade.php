<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
</head>
<body>
    <h1>Admin Login</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.login.submit') }}" method="POST">
        @csrf
        <p>
            <label for="email">Email:</label><br>
            <input type="email" name="email" id="email" required>
        </p>

        <p>
            <label for="password">Password:</label><br>
            <input type="password" name="password" id="password" required>
        </p>

        <p>
            <button type="submit">Login</button>
        </p>
    </form>

    <br>
    <a href="{{ url('/') }}"><button type="button">Back</button></a>
</body>
</html>
