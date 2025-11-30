<!DOCTYPE html>
<html>
<head>
    <!-- Sets the title of the page shown in the browser tab -->
    <title>Orders</title>
</head>
<body>
    <!-- Main heading of the page -->
    <h1>Orders</h1>

    <p>
        <!-- Button to go back to the admin dashboard -->
        <a href="{{ route('admin.dashboard') }}">
            <button type="button">Back to Dashboard</button>
        </a>
    </p>

    <!-- Display success message if a session variable exists -->
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <!-- Table displaying all orders -->
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <!-- Table headers -->
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
            <!-- Loop through orders; show message if none exist -->
            @forelse($orders as $order)
            <tr>
                <!-- Order data -->
                <td>{{ $order->order_id }}</td>
                <!-- Display customer username; fallback to 'N/A' if customer is missing -->
                <td>{{ $order->customer->username ?? 'N/A' }}</td>
                <td>{{ $order->order_date }}</td>
                <td>{{ $order->order_status }}</td>
                <td>{{ $order->payment_status }}</td>
                <td>{{ $order->total_amount }}</td>
                <td>
                    <!-- View order link -->
                    <a href="{{ route('admin.orders.show', $order->order_id) }}">View</a> |
                    <!-- Update order link -->
                    <a href="{{ route('admin.orders.edit', $order->order_id) }}">Update</a> |
                    <!-- Delete order form -->
                    <form action="{{ route('admin.orders.destroy', $order->order_id) }}" method="POST" style="display:inline;">
                        <!-- CSRF token for security -->
                        @csrf
                        <!-- Use DELETE HTTP method for deleting the resource -->
                        @method('DELETE')
                        <!-- Delete button with confirmation prompt -->
                        <button type="submit" onclick="return confirm('Delete this order?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <!-- Message when no orders exist -->
            <tr>
                <td colspan="7">No orders found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
