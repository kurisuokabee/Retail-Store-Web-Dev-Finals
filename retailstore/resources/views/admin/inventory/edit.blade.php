<!DOCTYPE html>
<html>
<head>
    <!-- Sets the title of the page shown in the browser tab -->
    <title>Edit Inventory</title>
</head>
<body>
@extends('layouts.app')

@section('title', 'Edit Inventory')

@section('content')
    <!-- Main heading of the page -->
    <h1>Edit Inventory</h1>

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

    <!-- Form to update an existing inventory item -->
    <form action="{{ route('admin.inventory.update', $inventory->inventory_id) }}" method="POST">
        <!-- CSRF token for security to prevent cross-site request forgery -->
        @csrf
        <!-- Use PUT HTTP method for updating the resource -->
        @method('PUT')

        <p>
            <!-- Label for product selection -->
            <label>Product:</label><br>
            <!-- Dropdown to select a product; required -->
            <select name="product_id" required>
                <option value="">Select Product</option>
                <!-- Loop through products to create options -->
                <!-- Pre-select the product that matches the current inventory item -->
                @foreach($products as $product)
                    <option value="{{ $product->product_id }}" @if($product->product_id == $inventory->product_id) selected @endif>
                        {{ $product->product_name }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <!-- Label and input for stock quantity -->
            <label>Stock Quantity:</label><br>
            <!-- Number input; pre-filled with current stock quantity, minimum 0, required -->
            <input type="number" name="stock_quantity" value="{{ $inventory->stock_quantity }}" min="0" required>
        </p>

        <p>
            <!-- Label and input for reorder level -->
            <label>Reorder Level:</label><br>
            <!-- Number input; pre-filled with current reorder level, minimum 0, required -->
            <input type="number" name="reorder_level" value="{{ $inventory->reorder_level }}" min="0" required>
        </p>

        <p>
            <!-- Label and input for maximum stock level -->
            <label>Max Stock Level:</label><br>
            <!-- Number input; pre-filled with current max stock level, minimum 1, required -->
            <input type="number" name="max_stock_level" value="{{ $inventory->max_stock_level }}" min="1" required>
        </p>

        <p>
            <!-- Label and input for last restocked date -->
            <label>Last Restocked:</label><br>
            <!-- Date input; pre-filled with current last restocked date if available -->
            <input type="date" name="last_restocked" value="{{ $inventory->last_restocked ? $inventory->last_restocked->format('Y-m-d') : '' }}">
        </p>

        <p>
            <!-- Submit button to update the inventory item -->
            <button type="submit">Update Inventory</button>
        </p>
    </form>
@endsection
</body>
</html>
