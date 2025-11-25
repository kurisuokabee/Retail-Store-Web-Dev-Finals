<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>
</head>
<body>
<h1>Edit Category</h1>

<a href="{{ route('admin.categories.index') }}">Back to Categories</a>

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.categories.update', $category->category_id) }}" method="POST">
    @csrf
    @method('PUT')

    <p>
        <label>Category Name:</label><br>
        <input type="text" name="category_name" value="{{ old('category_name', $category->category_name) }}" required>
    </p>

    <p>
        <label>Description:</label><br>
        <textarea name="description">{{ old('description', $category->description) }}</textarea>
    </p>

    <p>
        <label>Status:</label><br>
        <select name="is_active">
            <option value="1" {{ old('is_active', $category->is_active) == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('is_active', $category->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
    </p>

    <p>
        <button type="submit">Update Category</button>
    </p>
</form>
</body>
</html>
