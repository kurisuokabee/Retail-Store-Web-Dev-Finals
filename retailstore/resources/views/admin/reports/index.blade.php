<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
</head>
<body>
<h1>Reports</h1>

<p>
    <a href="{{ route('admin.dashboard') }}">
        <button type="button">Back to Dashboard</button>
    </a>
</p>

<h2>Sales Per Day</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Date</th>
            <th>Total Sales</th>
        </tr>
    </thead>
    <tbody>
        @forelse($salesPerDay as $day)
        <tr>
            <td>{{ $day->date }}</td>
            <td>{{ $day->total_sales }}</td>
        </tr>
        @empty
        <tr><td colspan="2">No sales data.</td></tr>
        @endforelse
    </tbody>
</table>

<h2>Orders Per Status</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Status</th>
            <th>Total Orders</th>
        </tr>
    </thead>
    <tbody>
        @forelse($ordersPerStatus as $status)
        <tr>
            <td>{{ ucfirst($status->order_status) }}</td>
            <td>{{ $status->total_orders }}</td>
        </tr>
        @empty
        <tr><td colspan="2">No orders data.</td></tr>
        @endforelse
    </tbody>
</table>

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
        @forelse($inventorySummary as $product)
        <tr>
            <td>{{ $product->product_name }}</td>
            <td>{{ $product->inventory->stock_quantity ?? 'N/A' }}</td>
            <td>{{ $product->inventory->reorder_level ?? 'N/A' }}</td>
            <td>{{ $product->inventory->max_stock_level ?? 'N/A' }}</td>
        </tr>
        @empty
        <tr><td colspan="4">No products found.</td></tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
