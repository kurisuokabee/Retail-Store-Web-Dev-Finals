@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <!-- Main heading of the page -->
    <h1>Categories</h1>

    <p>
        <!-- Button to go back to the admin dashboard -->
        <a href="{{ route('admin.dashboard') }}">
            <button type="button">Back to Dashboard</button>
        </a>
    </p>

    <!-- Link to add a new category -->
    <a href="{{ route('admin.categories.create') }}">Add New Category</a>

    <!-- Display success message if a session variable exists -->
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <!-- Table displaying all categories -->
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <!-- Table headers -->
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through categories; show message if none exist -->
            @forelse($categories as $category)
            <tr>
                <!-- Category data -->
                <td>{{ $category->category_id }}</td>
                <td>{{ $category->category_name }}</td>
                <td>{{ $category->description }}</td>
                <td>{{ $category->is_active ? 'Active' : 'Inactive' }}</td>
                <td>
                    <!-- Edit link -->
                    <a href="{{ route('admin.categories.edit', $category->category_id) }}">Edit</a>
                    |
                    <!-- Delete form -->
                    <form action="{{ route('admin.categories.destroy', $category->category_id) }}" method="POST" style="display:inline;">
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
            <!-- Message when no categories exist -->
            <tr>
                <td colspan="5">No categories found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
@endsection
