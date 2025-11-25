<!DOCTYPE html>
<html>
<head>
    <title>Suppliers</title>
</head>
<body>
<h1>Suppliers</h1>

<p>
    <a href="{{ route('admin.dashboard') }}">
        <button type="button">Back to Dashboard</button>
    </a>
</p>

<a href="{{ route('admin.suppliers.create') }}">Add New Supplier</a>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Supplier Name</th>
            <th>Contact Person</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($suppliers as $supplier)
        <tr>
            <td>{{ $supplier->supplier_id }}</td>
            <td>{{ $supplier->supplier_name }}</td>
            <td>{{ $supplier->contact_person }}</td>
            <td>{{ $supplier->email }}</td>
            <td>{{ $supplier->phone }}</td>
            <td>{{ $supplier->address }}</td>
            <td>
                <a href="{{ route('admin.suppliers.edit', $supplier->supplier_id) }}">Edit</a>
                |
                <form action="{{ route('admin.suppliers.destroy', $supplier->supplier_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">No suppliers found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
</body>
</html>
