<div>
    <!-- Nothing worth having comes easy. - Theodore Roosevelt -->
    <h1>Register</h1>
    @if ($errors->any())
        <div style="color: red; margin-bottom: 20px;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('auth.register') }}">
        @csrf
        <div>
            <label for="username">Name:</label>
            <input type="text" id="name" name="username" required autofocus>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        <div>
            <button type="submit">Register</button>
        </div>
    </form>
    <button onclick="location.href='{{ route('login') }}'">Back to Login</button>
</div>
