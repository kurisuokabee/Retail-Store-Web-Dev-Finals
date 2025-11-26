<div>
    <h1>{{ $product->product_name }}</h1>

    @if ($errors->any())
        <div style="color: red; margin-bottom: 20px;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if (session('success'))
        <div style="color: green; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom: 20px;">
        <p><strong>Description:</strong> {{ $product->description }}</p>
        <p><strong>Category:</strong> {{ $product->category->category_name ?? 'N/A' }}</p>
        <p><strong>Supplier:</strong> {{ $product->supplier->supplier_name ?? 'N/A' }}</p>
        <p><strong>Price:</strong> ${{ number_format($product->unit_price, 2) }}</p>
        <p><strong>Stock Available:</strong> {{ $product->inventory->stock_quantity ?? 0 }}</p>
    </div>

    @if ($product->inventory && $product->inventory->stock_quantity > 0)
        <form method="POST" action="{{ route('products.addToCart', $product->product_id) }}">
            @csrf
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" max="{{ $product->inventory->stock_quantity }}" value="1" required>
            <button type="submit">Add to Cart</button>
        </form>
    @else
        <p style="color: red;">Out of Stock</p>
    @endif

    <div style="margin-top: 20px;">
        <a href="{{ route('products.browse') }}">Back to Products</a>
    </div>
</div>
