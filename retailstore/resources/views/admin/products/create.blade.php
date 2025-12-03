@extends('layouts.app')

@section('title', 'Add New Product')

@section('content')

    <!-- Force-load products-create.css (same pattern as details.blade.php) -->
    @php
        $publicCssPath = public_path('css/admin/products-create.css');
        $resourceCssPath = resource_path('css/admin/products-create.css');
    @endphp

    @if (file_exists($publicCssPath))
        <link rel="stylesheet" href="{{ asset('css/admin/products-create.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/admin/products-create.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
        <style>
            {!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}
        </style>
    @endif

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="admin-products-create-page">
    <!-- Page header -->
    <div class="admin-page-header">
        <h1>Add New Product</h1>
    </div>

    <!-- Link to go back to the products list -->
    <a href="{{ route('admin.products.index') }}" class="back-link">← Back to Products</a>

    <!-- Display validation errors from the backend if any exist -->
    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form to add a new product -->
    <form action="{{ route('admin.products.store') }}" method="POST" class="form-container">
        <!-- CSRF token for security to prevent cross-site request forgery -->
        @csrf

        <div class="form-group">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" value="{{ old('product_name') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="category_id">Category:</label>
            <select id="category_id" name="category_id" class="searchable-select" required>
                <!-- Fetches all categories to make a searchable select dropdown menu -->
                <option value="">-- Select a Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="supplier_id">Supplier:</label>
            <select id="supplier_id" name="supplier_id" class="searchable-select" required>
                <!-- Fetches all suppliers to make a searchable select dropdown menu -->
                <option value="">-- Select a Supplier --</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->supplier_id }}" {{ old('supplier_id') == $supplier->supplier_id ? 'selected' : '' }}>
                        {{ $supplier->supplier_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="unit_price">Unit Price:</label>
            <input type="number" id="unit_price" step="0.01" name="unit_price" value="{{ old('unit_price') }}" required>
        </div>

        <div class="form-group">
            <label for="cost_price">Cost Price:</label>
            <input type="number" id="cost_price" step="0.01" name="cost_price" value="{{ old('cost_price') }}" required>
        </div>

        <div class="form-group">
            <label for="is_active">Status:</label>
            <select id="is_active" name="is_active">
                <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Add Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2 for searchable dropdowns
        $('.searchable-select').select2({
            placeholder: '-- Search or Select --',
            allowClear: false,
            minimumResultsForSearch: 0,
            width: '100%'
        });
    });
</script>

@endsection
