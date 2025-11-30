<!DOCTYPE html>
<html>
<head>
    <!-- Sets the title of the page shown in the browser tab -->
    <title>Reports</title>
</head>
<body>
    <!-- Main heading of the page -->
    <h1>Reports</h1>

    <p>
        <!-- Button to go back to the admin dashboard -->
        <a href="{{ route('admin.dashboard') }}">
            <button type="button">Back to Dashboard</button>
        </a>
    </p>

    <!-- Section: Sales Per Day -->
    <h2>Sales Per Day</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <!-- Table headers -->
                <th>Date</th>
                <th>Total Sales</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through sales per day data -->
            @forelse($salesPerDay as $day)
            <tr>
                <td>{{ $day->date }}</td>
                <td>{{ $day->total_sales }}</td>
            </tr>
            @empty
            <!-- Display message if no sales data exists -->
            <tr><td colspan="2">No sales data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Section: Orders Per Status -->
    <h2>Orders Per Status</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Status</th>
                <th>Total Orders</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through orders grouped by status -->
            @forelse($ordersPerStatus as $status)
            <tr>
                <!-- Capitalize first letter of status -->
                <td>{{ ucfirst($status->order_status) }}</td>
                <td>{{ $status->total_orders }}</td>
            </tr>
            @empty
            <!-- Display message if no order data exists -->
            <tr><td colspan="2">No orders data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Section: Inventory Summary -->
    <h2>Inventory Summary</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Product</th>
                <th>Stock Quantity</th>
                <th>Reorder Level</th>
                <th>Max Stock Level</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through products and their inventory info -->
            @forelse($inventorySummary as $product)
            <tr>
                <td>{{ $product->product_name }}</td>
                <!-- Display inventory info; fallback to 'N/A' if missing -->
                <td>{{ $product->inventory->stock_quantity ?? 'N/A' }}</td>
                <td>{{ $product->inventory->reorder_level ?? 'N/A' }}</td>
                <td>{{ $product->inventory->max_stock_level ?? 'N/A' }}</td>
            </tr>
            @empty
            <!-- Display message if no products exist -->
            <tr><td colspan="4">No products found.</td></tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
