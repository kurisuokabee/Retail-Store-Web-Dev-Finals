<!DOCTYPE html>
<html>
<head>
    <title>Add Inventory</title>
</head>
<body>
<h1>Add Inventory</h1>

<a href="{{ route('admin.inventory.index') }}">Back to Inventory</a>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.inventory.store') }}" method="POST">
    @csrf
    <p>
        <label>Product:</label><br>
        <select name="product_id" required>
            <option value="">Select Product</option>
            @foreach($products as $product)
                <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
            @endforeach
        </select>
    </p>

    <p>
        <label>Stock Quantity:</label><br>
        <input type="number" name="stock_quantity" value="0" min="0" required>
    </p>

    <p>
        <label>Reorder Level:</label><br>
        <input type="number" name="reorder_level" value="10" min="0" required>
    </p>

    <p>
        <label>Max Stock Level:</label><br>
        <input type="number" name="max_stock_level" value="50" min="1" required>
    </p>

    <p>
        <label>Last Restocked:</label><br>
        <input type="date" name="last_restocked">
    </p>

    <p>
        <button type="submit">Add Inventory</button>
    </p>
</form>
</body>
</html>
