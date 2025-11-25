<div>
    <!-- We must ship. - Taylor Otwell -->
    <h1>Dashboard</h1>
    <p>Welcome to your dashboard!</p>
    
    <div style="margin: 20px 0;">
        <h2>Quick Links</h2>
        <ul>
            <li><a href="{{ route('products.browse') }}">Browse Products</a></li>
            <li><a href="{{ route('orders.history') }}">View Order History</a></li>
            <li><a href="{{ route('customers.show', Auth::user()->customer_id) }}">View Your Details</a></li>
        </ul>
    </div>

    <form method="POST" action="{{ route('auth.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>

