<div>
    <!-- Continue shopping link -->
    <div style="margin-bottom: 20px;">
        <a href="{{ route('products.browse') }}">← Continue Shopping</a>
    </div>

    <h1>Order History</h1>

    <!-- Success message -->
    @if (session('success'))
        <div style="color: green; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Orders listing -->
    @forelse ($orders as $order)
        <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 5px;">
            <h3>Order #{{ $order->order_id }}</h3>
            <p><strong>Order Date:</strong> {{ $order->order_date->format('M d, Y') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->order_status) }}</p>
            <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
            <p><strong>Total:</strong> ${{ number_format($order->total_amount, 2) }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
            <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>

            <!-- Order items -->
            <h4>Items:</h4>
            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $detail)
                        <tr>
                            <td>{{ $detail->product->product_name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>${{ number_format($detail->unit_price, 2) }}</td>
                            <td>${{ number_format($detail->unit_price * $detail->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 10px;">
                <a href="{{ route('orders.show', $order->order_id) }}">View Details</a>
            </div>
        </div>
    @empty
        <p>No orders found.</p>
    @endforelse

    <!-- Pagination -->
    <div style="margin-top: 20px;">
        {{ $orders->links() }}
    </div>
</div>
