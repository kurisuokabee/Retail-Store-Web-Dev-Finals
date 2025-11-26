<div>
    <div>
        <a href="{{ route('products.browse') }}">Continue Shopping</a>
    </div>
    
    <h1>Order History</h1>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @forelse ($orders as $order)
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
            <h3>Order #{{ $order->order_id }}</h3>
            <p>Order Date: {{ $order->order_date->format('M d, Y') }}</p>
            <p>Status: {{ ucfirst($order->order_status) }}</p>
            <p>Payment Status: {{ ucfirst($order->payment_status) }}</p>
            <p>Total: ${{ number_format($order->total_amount, 2) }}</p>
            <p>Payment Method: {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
            <p>Shipping Address: {{ $order->shipping_address }}</p>

            <h4>Items:</h4>
            <table border="1" cellpadding="5" style="width: 100%;">
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Subtotal</th>
                </tr>
                @foreach ($order->orderDetails as $detail)
                    <tr>
                        <td>{{ $detail->product->product_name }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>${{ number_format($detail->unit_price, 2) }}</td>
                        <td>${{ number_format($detail->unit_price * $detail->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </table>

            <a href="{{ route('orders.show', $order->order_id) }}">View Details</a>
        </div>
    @empty
        <p>No orders found.</p>
    @endforelse

    {{ $orders->links() }}

    
</div>
