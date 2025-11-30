<!DOCTYPE html>
<html>
<head>
    <!-- Sets the title of the page shown in the browser tab -->
    <title>Edit Category</title>
</head>
<body>
    <!-- Main heading of the page -->
    <h1>Edit Category</h1>

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

    <!-- Form to update an existing category -->
    <form action="{{ route('admin.categories.update', $category->category_id) }}" method="POST">
        <!-- CSRF token for security to prevent cross-site request forgery -->
        @csrf
        <!-- Use PUT HTTP method for updating a resource -->
        @method('PUT')

        <p>
            <!-- Label for category name input -->
            <label>Category Name:</label><br>
            <!-- Text input for category name; required -->
            <!-- `old('category_name', $category->category_name)` retains previous input if validation fails, or shows current category name -->
            <input type="text" name="category_name" value="{{ old('category_name', $category->category_name) }}" required>
        </p>

        <p>
            <!-- Label for description input -->
            <label>Description:</label><br>
            <!-- Textarea for category description; retains previous input or current category description -->
            <textarea name="description">{{ old('description', $category->description) }}</textarea>
        </p>

        <p>
            <!-- Label for status selection -->
            <label>Status:</label><br>
            <!-- Dropdown to select if the category is active or inactive -->
            <!-- Retains previously selected value or current category status -->
            <select name="is_active">
                <option value="1" {{ old('is_active', $category->is_active) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('is_active', $category->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </p>

        <p>
            <!-- Submit button to update the category -->
            <button type="submit">Update Category</button>
        </p>
    </form>
</body>
</html>
