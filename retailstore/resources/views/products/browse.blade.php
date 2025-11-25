@extends('layouts.app')

@section('content')
<div>
    <h1>Browse Products</h1>
    
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
        <h3>Filter by Category:</h3>
        <ul>
            <li><a href="{{ route('products.browse') }}">All Products</a></li>
            @foreach ($categories as $category)
                <li>
                    <a href="{{ route('products.filterByCategory', $category->category_id) }}">
                        {{ $category->category_name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                    <td>${{ number_format($product->unit_price, 2) }}</td>
                    <td>{{ $product->inventory->stock_quantity ?? 0 }}</td>
                    <td>
                        <a href="{{ route('products.details', $product->product_id) }}">View Details</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No products available</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $products->links() }}
    </div>
</div>
@endsection
