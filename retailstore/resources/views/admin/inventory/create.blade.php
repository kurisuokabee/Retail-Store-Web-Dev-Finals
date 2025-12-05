@extends('layouts.app')

@section('title', 'Add Inventory')

@section('content')

    <!-- Force-load inventory-add.css -->
    @php
        $publicCssPath = public_path('css/admin/inventory-create.css');
        $resourceCssPath = resource_path('css/admin/inventory-create.css');
    @endphp

    @if (file_exists($publicCssPath))
        <link rel="stylesheet" href="{{ asset('css/admin/inventory-create.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/admin/inventory-create.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
        <style>
            {!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}
        </style>
    @endif

<div class="admin-inventory-add-page">
    <!-- Page header -->
    <div class="admin-page-header">
        <h1>Add Inventory</h1>
    </div>

    <!-- Back link -->
    <a href="{{ route('admin.inventory.index') }}" class="back-link">← Back to Inventory</a>

    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Inventory add form -->
    <form action="{{ route('admin.inventory.store') }}" method="POST" class="form-container">
        @csrf

        <div class="form-group">
            <label for="product_id">Product:</label>
            <select id="product_id" name="product_id" class="searchable-select" required>
                <option value="">-- Select a Product --</option>
                @foreach($products as $product)
                    <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="stock_quantity">Stock Quantity:</label>
            <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0" required>
        </div>

        <div class="form-group">
            <label for="reorder_level">Reorder Level:</label>
            <input type="number" id="reorder_level" name="reorder_level" value="{{ old('reorder_level', 10) }}" min="0" required>
        </div>

        <div class="form-group">
            <label for="max_stock_level">Max Stock Level:</label>
            <input type="number" id="max_stock_level" name="max_stock_level" value="{{ old('max_stock_level', 50) }}" min="1" required>
        </div>

        <div class="form-group">
            <label for="last_restocked">Last Restocked:</label>
            <input type="date" id="last_restocked" name="last_restocked" value="{{ old('last_restocked') }}">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Add Inventory</button>
            <a href="{{ route('admin.inventory.index') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

<!-- Optional: Include Select2 for searchable dropdowns -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('.searchable-select').select2({
            placeholder: '-- Search or Select --',
            allowClear: false,
            minimumResultsForSearch: 0,
            width: '100%'
        });
    });
</script>

@endsection
