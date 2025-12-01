@extends('layouts.app')

@section('title', 'Add Category')

@section('content')
    <!-- Main heading of the page -->
    <h1>Add New Category</h1>

    <!-- Link to go back to the list of categories -->
    <a href="{{ route('admin.categories.index') }}">Back to Categories</a>

    <!-- Display validation errors from the backend if any exist -->
    @if ($errors->any())
        <!-- Errors are displayed in red color -->
        <div style="color: red;">
            <ul>
                <!-- Loop through all errors and display each one as a list item -->
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form to add a new category -->
    <form action="{{ route('admin.categories.store') }}" method="POST">
        <!-- CSRF token for security to prevent cross-site request forgery -->
        @csrf

        <p>
            <!-- Label for category name input -->
            <label>Category Name:</label><br>
            <!-- Text input for category name; required to be filled before submission -->
            <!-- `old('category_name')` keeps the previously entered value if validation fails -->
            <input type="text" name="category_name" value="{{ old('category_name') }}" required>
        </p>

        <p>
            <!-- Label for description input -->
            <label>Description:</label><br>
            <!-- Textarea for category description; preserves previous input if validation fails -->
            <textarea name="description">{{ old('description') }}</textarea>
        </p>

        <p>
            <!-- Label for status selection -->
            <label>Status:</label><br>
            <!-- Dropdown to select if the category is active or inactive -->
            <!-- The previously selected value is retained using old() -->
            <select name="is_active">
                <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </p>

        <p>
            <!-- Submit button to add the new category -->
            <button type="submit">Add Category</button>
        </p>
    </form>
@endsection
