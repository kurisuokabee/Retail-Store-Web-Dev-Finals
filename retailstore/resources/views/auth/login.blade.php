<div>
    <!-- Waste no more time arguing what a good man should be, be one. - Marcus Aurelius -->
    <h1>Login</h1>
    @if ($errors->any())
        <div style="color: red; margin-bottom: 20px;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('auth.login') }}">
        @csrf
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required autofocus>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Log In</button>
    </form>
</div>
