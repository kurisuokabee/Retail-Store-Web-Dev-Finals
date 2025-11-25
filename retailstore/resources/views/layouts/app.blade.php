<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retail Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        nav {
            background-color: #333;
            padding: 10px 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
        }
        nav a:hover {
            text-decoration: underline;
        }
        main {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        input, textarea, select {
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <nav>
        @auth
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('products.browse') }}">Products</a>
            <a href="{{ route('orders.history') }}">Orders</a>
            <a href="{{ route('customers.show', Auth::user()->customer_id) }}">My Profile</a>
            @php $cartCount = count(session('cart', [])); @endphp
            <a href="{{ route('orders.checkout') }}">Cart ({{ $cartCount }})</a>
            <form method="POST" action="{{ route('auth.logout') }}" style="display:inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </nav>

    <main>
        @yield('content')
    </main>

    <footer style="text-align: center; margin-top: 40px; padding: 20px; color: #666;">
        <p>&copy; 2025 Retail Store. All rights reserved.</p>
    </footer>
</body>
</html>
