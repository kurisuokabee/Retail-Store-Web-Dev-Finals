<!DOCTYPE html>
<html>
<head>
    <!-- Sets the title of the page shown in the browser tab -->
    <title>Add Inventory</title>
</head>
<body>
    <!-- Main heading of the page -->
    <h1>Add Inventory</h1>

    <!-- Link to go back to the inventory list -->
    <a href="{{ route('admin.inventory.index') }}">Back to Inventory</a>

    <!-- Display validation errors from the backend if any exist -->
    @if ($errors->any())
        <!-- Errors are displayed in red color -->
        <div style="color:red;">
            <ul>
                <!-- Loop through all errors and display each one as a list item -->
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form to add a new inventory item -->
    <form action="{{ route('admin.inventory.store') }}" method="POST">
        <!-- CSRF token for security to prevent cross-site request forgery -->
        @csrf

        <p>
            <!-- Label for product selection -->
            <label>Product:</label><br>
            <!-- Dropdown to select a product from existing products; required -->
            <select name="product_id" required>
                <option value="">Select Product</option>
                <!-- Loop through all products to create options -->
                @foreach($products as $product)
                    <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                @endforeach
            </select>
        </p>

        <p>
            <!-- Label and input for stock quantity -->
            <label>Stock Quantity:</label><br>
            <!-- Number input starting at 0, minimum value 0, required -->
            <input type="number" name="stock_quantity" value="0" min="0" required>
        </p>

        <p>
            <!-- Label and input for reorder level -->
            <label>Reorder Level:</label><br>
            <!-- Number input starting at 10, minimum value 0, required -->
            <input type="number" name="reorder_level" value="10" min="0" required>
        </p>

        <p>
            <!-- Label and input for maximum stock level -->
            <label>Max Stock Level:</label><br>
            <!-- Number input starting at 50, minimum value 1, required -->
            <input type="number" name="max_stock_level" value="50" min="1" required>
        </p>

        <p>
            <!-- Label and input for last restocked date -->
            <label>Last Restocked:</label><br>
            <!-- Date input; optional -->
            <input type="date" name="last_restocked">
        </p>

        <p>
            <!-- Submit button to add inventory -->
            <button type="submit">Add Inventory</button>
        </p>
    </form>
</body>
</html>
