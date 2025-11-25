<!DOCTYPE html>
<html>
<head>
    <title>Add New Product</title>
</head>
<body>
<h1>Add New Product</h1>

<a href="{{ route('admin.products.index') }}">Back to Products</a>

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.products.store') }}" method="POST">
    @csrf
    <p>
        <label>Product Name:</label><br>
        <input type="text" name="product_name" value="{{ old('product_name') }}" required>
    </p>

    <p>
        <label>Description:</label><br>
        <textarea name="description">{{ old('description') }}</textarea>
    </p>

    <p>
        <label>Category ID:</label><br>
        <input type="number" name="category_id" value="{{ old('category_id') }}" required>
    </p>

    <p>
        <label>Supplier ID:</label><br>
        <input type="number" name="supplier_id" value="{{ old('supplier_id') }}" required>
    </p>

    <p>
        <label>Unit Price:</label><br>
        <input type="number" step="0.01" name="unit_price" value="{{ old('unit_price') }}" required>
    </p>

    <p>
        <label>Cost Price:</label><br>
        <input type="number" step="0.01" name="cost_price" value="{{ old('cost_price') }}" required>
    </p>

    <p>
        <label>Status:</label><br>
        <select name="is_active">
            <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
    </p>

    <p>
        <button type="submit">Add Product</button>
    </p>
</form>
</body>
</html>
