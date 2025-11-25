<!DOCTYPE html>
<html>
<head>
    <title>Edit Inventory</title>
</head>
<body>
<h1>Edit Inventory</h1>

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

<form action="{{ route('admin.inventory.update', $inventory->inventory_id) }}" method="POST">
    @csrf
    @method('PUT')

    <p>
        <label>Product:</label><br>
        <select name="product_id" required>
            <option value="">Select Product</option>
            @foreach($products as $product)
                <option value="{{ $product->product_id }}" @if($product->product_id == $inventory->product_id) selected @endif>
                    {{ $product->product_name }}
                </option>
            @endforeach
        </select>
    </p>

    <p>
        <label>Stock Quantity:</label><br>
        <input type="number" name="stock_quantity" value="{{ $inventory->stock_quantity }}" min="0" required>
    </p>

    <p>
        <label>Reorder Level:</label><br>
        <input type="number" name="reorder_level" value="{{ $inventory->reorder_level }}" min="0" required>
    </p>

    <p>
        <label>Max Stock Level:</label><br>
        <input type="number" name="max_stock_level" value="{{ $inventory->max_stock_level }}" min="1" required>
    </p>

    <p>
        <label>Last Restocked:</label><br>
        <input type="date" name="last_restocked" value="{{ $inventory->last_restocked ? $inventory->last_restocked->format('Y-m-d') : '' }}">
    </p>

    <p>
        <button type="submit">Update Inventory</button>
    </p>
</form>
</body>
</html>
