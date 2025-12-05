@extends('layouts.app')

@section('title', 'Products')

@section('content')

    <!-- Force-load products-index.css (same pattern as details.blade.php) -->
    @php
        $publicCssPath = public_path('css/admin/products-index.css');
        $resourceCssPath = resource_path('css/admin/products-index.css');
    @endphp

    @if (file_exists($publicCssPath))
        <link rel="stylesheet" href="{{ asset('css/admin/products-index.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/admin/products-index.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
        <style>
            {!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}
        </style>
    @endif

<div class="admin-products-page">
    <!-- Page header -->
    <div class="admin-page-header">
        <h1>Products</h1>
    </div>

    <!-- Action bar with navigation and controls -->
    <div class="admin-action-bar">
        <!-- Button to go back to the admin dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            ← Back to Dashboard
        </a>

        <!-- Link to create a new product -->
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            + Add New Product
        </a>
    </div>

    <!-- Display success message if available in the session -->
    @if(session('success'))
        <div class="alert alert-success">
            ✓ {{ session('success') }}
        </div>
    @endif

    <!-- Table displaying all products -->
    <div class="products-table-wrapper">
        <table class="products-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>Unit Price</th>
                    <th>Cost Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->product_id }}</td>
                    <td class="product-name">{{ $product->product_name }}</td>
                    <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                    <td>{{ $product->supplier->supplier_name ?? 'N/A' }}</td>
                    <td class="price-cell">${{ number_format($product->unit_price, 2) }}</td>
                    <td class="price-cell">${{ number_format($product->cost_price, 2) }}</td>
                    <td>
                        <span class="status-badge {{ $product->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="actions-cell">
                        <a href="{{ route('admin.products.edit', $product->product_id) }}" class="btn-link edit">Edit</a>
                        <span class="action-separator">|</span>
                        <form action="{{ route('admin.products.destroy', $product->product_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-link delete" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="table-empty">No products found. <a href="{{ route('admin.products.create') }}">Create one</a></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
