<!DOCTYPE html>
<html>
<head>
    <!-- Sets the title of the page shown in the browser tab -->
    <title>Edit Product</title>
</head>
<body>
    <!-- Main heading of the page -->
    <h1>Edit Product</h1>

    <!-- Link to go back to the products list -->
    <a href="{{ route('admin.products.index') }}">Back to Products</a>

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

    <!-- Form to update an existing product -->
    <form action="{{ route('admin.products.update', $product->product_id) }}" method="POST">
        <!-- CSRF token for security to prevent cross-site request forgery -->
        @csrf
        <!-- Use PUT HTTP method for updating the resource -->
        @method('PUT')

        <p>
            <!-- Label and input for product name -->
            <label>Product Name:</label><br>
            <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
        </p>

        <p>
            <!-- Label and textarea for product description -->
            <label>Description:</label><br>
            <textarea name="description">{{ old('description', $product->description) }}</textarea>
        </p>

        <p>
            <!-- Label and input for category ID -->
            <label>Category ID:</label><br>
            <input type="number" name="category_id" value="{{ old('category_id', $product->category_id) }}" required>
        </p>

        <p>
            <!-- Label and input for supplier ID -->
            <label>Supplier ID:</label><br>
            <input type="number" name="supplier_id" value="{{ old('supplier_id', $product->supplier_id) }}" required>
        </p>

        <p>
            <!-- Label and input for unit price -->
            <label>Unit Price:</label><br>
            <!-- step="0.01" allows decimal values -->
            <input type="number" step="0.01" name="unit_price" value="{{ old('unit_price', $product->unit_price) }}" required>
        </p>

        <p>
            <!-- Label and input for cost price -->
            <label>Cost Price:</label><br>
            <!-- step="0.01" allows decimal values -->
            <input type="number" step="0.01" name="cost_price" value="{{ old('cost_price', $product->cost_price) }}" required>
        </p>

        <p>
            <!-- Label and select dropdown for product status -->
            <label>Status:</label><br>
            <select name="is_active">
                <option value="1" {{ old('is_active', $product->is_active) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('is_active', $product->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </p>

        <p>
            <!-- Submit button to update the product -->
            <button type="submit">Update Product</button>
        </p>
    </form>
</body>
</html>
