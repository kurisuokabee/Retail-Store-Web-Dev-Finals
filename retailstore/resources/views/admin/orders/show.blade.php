<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
</head>
<body>
<h1>Order #{{ $order->order_id }} Details</h1>

<a href="{{ route('admin.orders.index') }}">Back to Orders</a>

<h3>Customer: {{ $order->customer->username ?? 'N/A' }}</h3>
<p>Order Date: {{ $order->order_date }}</p>
<p>Status: {{ $order->order_status }}</p>
<p>Payment: {{ $order->payment_status }}</p>
<p>Total Amount: {{ $order->total_amount }}</p>

<h3>Order Items:</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->orderDetails as $item)
        <tr>
            <td>{{ $item->product->product_name ?? 'N/A' }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->unit_price }}</td>
            <td>{{ $item->subtotal }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
