<!DOCTYPE html>
<html>
<head>
    <title>Inventory</title>
</head>
<body>
<h1>Inventory</h1>

<p>
    <a href="{{ route('admin.dashboard') }}">
        <button type="button">Back to Dashboard</button>
    </a>
</p>

<a href="{{ route('admin.inventory.create') }}">Add Inventory</a>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>Stock Quantity</th>
            <th>Reorder Level</th>
            <th>Max Stock Level</th>
            <th>Last Restocked</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($inventories as $inventory)
        <tr>
            <td>{{ $inventory->inventory_id }}</td>
            <td>{{ $inventory->product->product_name ?? 'N/A' }}</td>
            <td>{{ $inventory->stock_quantity }}</td>
            <td>{{ $inventory->reorder_level }}</td>
            <td>{{ $inventory->max_stock_level }}</td>
            <td>{{ $inventory->last_restocked }}</td>
            <td>
                <a href="{{ route('admin.inventory.edit', $inventory->inventory_id) }}">Edit</a> |
                <form action="{{ route('admin.inventory.destroy', $inventory->inventory_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">No inventory records found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
</body>
</html>
