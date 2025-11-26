<div>
    <h1>Order Details</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px;">
        <h3>Order #{{ $order->order_id }}</h3>
        <p>Order Date: {{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y H:i') }}</p>
        <p>Status: {{ ucfirst($order->order_status) }}</p>
        <p>Payment Status: {{ ucfirst($order->payment_status) }}</p>
        <p>Total Amount: ${{ number_format($order->total_amount, 2) }}</p>
        <p>Payment Method: {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
        <p>Shipping Address: {{ $order->shipping_address }}</p>
    </div>

    <h2>Order Items</h2>
    <table border="1" cellpadding="10" style="width: 100%;">
        <thead>
            <tr>
                <th>Product</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderDetails as $detail)
                <tr>
                    <td>{{ $detail->product->product_name }}</td>
                    <td>{{ $detail->product->description }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>${{ number_format($detail->unit_price, 2) }}</td>
                    <td>${{ number_format($detail->unit_price * $detail->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="text-align: right; font-weight: bold; margin-top: 20px;">
        Order Total: ${{ number_format($order->total_amount, 2) }}
    </p>

    <p>
        <a href="{{ route('orders.history') }}">Back to Order History</a> |
        <a href="{{ route('products.browse') }}">Continue Shopping</a>
    </p>
</div>
