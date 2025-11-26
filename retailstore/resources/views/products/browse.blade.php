<body>
    <nav>
        @auth
            <a href="{{ route('orders.history') }}">My Orders</a>
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
        <div>
            <h1>Browse Products</h1>

            @if ($errors->any())
                <div style="color: red;">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div style="color: green;">
                    {{ session('success') }}
                </div>
            @endif

            <div>
                <h3>Filter by Category:</h3>
                <ul>
                    <li><a href="{{ route('products.browse') }}">All Products</a></li>
                    @foreach ($categories as $category)
                        <li>
                            <a href="{{ route('products.filterByCategory', $category->category_id) }}">
                                {{ $category->category_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
                <tr>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                        <td>${{ number_format($product->unit_price, 2) }}</td>
                        <td>{{ $product->inventory->stock_quantity ?? 0 }}</td>
                        <td><a href="{{ route('products.details', $product->product_id) }}">View Details</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No products available</td>
                    </tr>
                @endforelse
            </table>

        </div>
    </main>

</body>
