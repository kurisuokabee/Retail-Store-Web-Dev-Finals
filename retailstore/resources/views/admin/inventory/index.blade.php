@extends('layouts.app')

@section('title', 'Inventory')

@section('content')
    <!-- Main heading of the page -->
    <h1>Inventory</h1>

    <p>
        <!-- Button to go back to the admin dashboard -->
        <a href="{{ route('admin.dashboard') }}">
            <button type="button">Back to Dashboard</button>
        </a>
    </p>

    <!-- Link to add a new inventory record -->
    <a href="{{ route('admin.inventory.create') }}">Add Inventory</a>

    <!-- Display success message if a session variable exists -->
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <!-- Table displaying all inventory records -->
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <!-- Table headers -->
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
            <!-- Loop through inventory records; show message if none exist -->
            @forelse($inventories as $inventory)
            <tr>
                <!-- Inventory data -->
                <td>{{ $inventory->inventory_id }}</td>
                <!-- Display product name; fallback to 'N/A' if product is missing -->
                <td>{{ $inventory->product->product_name ?? 'N/A' }}</td>
                <td>{{ $inventory->stock_quantity }}</td>
                <td>{{ $inventory->reorder_level }}</td>
                <td>{{ $inventory->max_stock_level }}</td>
                <td>{{ $inventory->last_restocked }}</td>
                <td>
                    <!-- Edit link -->
                    <a href="{{ route('admin.inventory.edit', $inventory->inventory_id) }}">Edit</a> |
                    <!-- Delete form -->
                    <form action="{{ route('admin.inventory.destroy', $inventory->inventory_id) }}" method="POST" style="display:inline;">
                        <!-- CSRF token for security -->
                        @csrf
                        <!-- Use DELETE HTTP method for deleting the resource -->
                        @method('DELETE')
                        <!-- Delete button with confirmation prompt -->
                        <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <!-- Message when no inventory records exist -->
            <tr>
                <td colspan="7">No inventory records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
@endsection
