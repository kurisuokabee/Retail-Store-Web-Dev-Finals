<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
</head>
<body>
<h1>Orders</h1>

<p>
    <a href="{{ route('admin.dashboard') }}">
        <button type="button">Back to Dashboard</button>
    </a>
</p>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Payment Status</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
        <tr>
            <td>{{ $order->order_id }}</td>
            <td>{{ $order->customer->username ?? 'N/A' }}</td>
            <td>{{ $order->order_date }}</td>
            <td>{{ $order->order_status }}</td>
            <td>{{ $order->payment_status }}</td>
            <td>{{ $order->total_amount }}</td>
            <td>
                <a href="{{ route('admin.orders.show', $order->order_id) }}">View</a> |
                <a href="{{ route('admin.orders.edit', $order->order_id) }}">Update</a> |
                <form action="{{ route('admin.orders.destroy', $order->order_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this order?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">No orders found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
</body>
</html>
