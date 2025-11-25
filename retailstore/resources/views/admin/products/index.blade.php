<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
</head>
<body>
<h1>Products</h1>

<p>
    <a href="{{ route('admin.dashboard') }}">
        <button type="button">Back to Dashboard</button>
    </a>
</p>

<a href="{{ route('admin.products.create') }}">Add New Product</a>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
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
        @forelse($products as $product)
        <tr>
            <td>{{ $product->product_id }}</td>
            <td>{{ $product->product_name }}</td>
            <td>{{ $product->category->category_name ?? 'N/A' }}</td>
            <td>{{ $product->supplier->supplier_name ?? 'N/A' }}</td>
            <td>{{ $product->unit_price }}</td>
            <td>{{ $product->cost_price }}</td>
            <td>{{ $product->is_active ? 'Active' : 'Inactive' }}</td>
            <td>
                <a href="{{ route('admin.products.edit', $product->product_id) }}">Edit</a>
                |
                <form action="{{ route('admin.products.destroy', $product->product_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8">No products found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
</body>
</html>
