<!DOCTYPE html>
<html>
<head>
    <!-- Page title shown in the browser tab -->
    <title>Suppliers</title>
</head>
<body>
    <!-- Main heading of the page -->
    <h1>Suppliers</h1>

    <!-- Button link to return to the admin dashboard -->
    <p>
        <a href="{{ route('admin.dashboard') }}">
            <button type="button">Back to Dashboard</button>
        </a>
    </p>

    <!-- Link to the form for adding a new supplier -->
    <a href="{{ route('admin.suppliers.create') }}">Add New Supplier</a>

    <!-- Display success messages from session if any -->
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <!-- Table listing all suppliers -->
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <!-- Column headers for supplier data -->
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
            <!-- Loop through suppliers; show each in a table row -->
            @forelse($suppliers as $supplier)
            <tr>
                <td>{{ $supplier->supplier_id }}</td>
                <td>{{ $supplier->supplier_name }}</td>
                <td>{{ $supplier->contact_person }}</td>
                <td>{{ $supplier->email }}</td>
                <td>{{ $supplier->phone }}</td>
                <td>{{ $supplier->address }}</td>
                <td>
                    <!-- Link to edit the supplier -->
                    <a href="{{ route('admin.suppliers.edit', $supplier->supplier_id) }}">Edit</a>
                    |
                    <!-- Form to delete the supplier -->
                    <form action="{{ route('admin.suppliers.destroy', $supplier->supplier_id) }}" method="POST" style="display:inline;">
                        <!-- CSRF token for security -->
                        @csrf
                        <!-- Use DELETE method for resource deletion -->
                        @method('DELETE')
                        <!-- Delete button with confirmation prompt -->
                        <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <!-- Message shown if no suppliers exist -->
            <tr>
                <td colspan="7">No suppliers found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
