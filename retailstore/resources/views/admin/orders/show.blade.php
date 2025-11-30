<!DOCTYPE html>
<html>
<head>
    <!-- Sets the title of the page shown in the browser tab -->
    <title>Order Details</title>
</head>
<body>
    <!-- Main heading displaying the order ID -->
    <h1>Order #{{ $order->order_id }} Details</h1>

    <!-- Link to go back to the orders list -->
    <a href="{{ route('admin.orders.index') }}">Back to Orders</a>

    <!-- Customer and order information -->
    <h3>Customer: {{ $order->customer->username ?? 'N/A' }}</h3>
    <p>Order Date: {{ $order->order_date }}</p>
    <p>Status: {{ $order->order_status }}</p>
    <p>Payment: {{ $order->payment_status }}</p>
    <p>Total Amount: {{ $order->total_amount }}</p>

    <!-- Section for order items -->
    <h3>Order Items:</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <!-- Table headers for order item details -->
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through each order item -->
            @foreach($order->orderDetails as $item)
            <tr>
                <!-- Display product name; fallback to 'N/A' if product is missing -->
                <td>{{ $item->product->product_name ?? 'N/A' }}</td>
                <!-- Quantity of the product ordered -->
                <td>{{ $item->quantity }}</td>
                <!-- Unit price of the product -->
                <td>{{ $item->unit_price }}</td>
                <!-- Subtotal for this product (quantity × unit price) -->
                <td>{{ $item->subtotal }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
