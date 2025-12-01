@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <!-- Main heading of the page -->
    <h1>Products</h1>

    <p>
        <!-- Button to go back to the admin dashboard -->
        <a href="{{ route('admin.dashboard') }}">
            <button type="button">Back to Dashboard</button>
        </a>
    </p>

    <!-- Link to create a new product -->
    <a href="{{ route('admin.products.create') }}">Add New Product</a>

    <!-- Display success message if available in the session -->
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <!-- Table displaying all products -->
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <!-- Table headers -->
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Supplier</th>
                <th>Unit Price</th>
                <th>Cost Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through products; show message if none exist -->
            @forelse($products as $product)
            <tr>
                <!-- Product ID -->
                <td>{{ $product->product_id }}</td>
                <!-- Product name -->
                <td>{{ $product->product_name }}</td>
                <!-- Category name; fallback to 'N/A' if category missing -->
                <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                <!-- Supplier name; fallback to 'N/A' if supplier missing -->
                <td>{{ $product->supplier->supplier_name ?? 'N/A' }}</td>
                <!-- Unit price -->
                <td>{{ $product->unit_price }}</td>
                <!-- Cost price -->
                <td>{{ $product->cost_price }}</td>
                <!-- Status -->
                <td>{{ $product->is_active ? 'Active' : 'Inactive' }}</td>
                <td>
                    <!-- Edit product link -->
                    <a href="{{ route('admin.products.edit', $product->product_id) }}">Edit</a>
                    |
                    <!-- Delete product form -->
                    <form action="{{ route('admin.products.destroy', $product->product_id) }}" method="POST" style="display:inline;">
                        <!-- CSRF token for security -->
                        @csrf
                        <!-- DELETE HTTP method for deleting the resource -->
                        @method('DELETE')
                        <!-- Delete button with confirmation -->
                        <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <!-- Message when no products exist -->
            <tr>
                <td colspan="8">No products found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
@endsection
