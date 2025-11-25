<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
</head>
<body>
<h1>Categories</h1>

<p>
    <a href="{{ route('admin.dashboard') }}">
        <button type="button">Back to Dashboard</button>
    </a>
</p>

<a href="{{ route('admin.categories.create') }}">Add New Category</a>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <td>{{ $category->category_id }}</td>
            <td>{{ $category->category_name }}</td>
            <td>{{ $category->description }}</td>
            <td>{{ $category->is_active ? 'Active' : 'Inactive' }}</td>
            <td>
                <a href="{{ route('admin.categories.edit', $category->category_id) }}">Edit</a>
                |
                <form action="{{ route('admin.categories.destroy', $category->category_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No categories found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
</body>
</html>
