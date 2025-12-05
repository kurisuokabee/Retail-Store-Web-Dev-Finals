@extends('layouts.app')

@section('title', 'Inventory')

@section('content')

<!-- Force-load inventory-index.css -->
@php
    $publicCssPath = public_path('css/admin/inventory-index.css');
    $resourceCssPath = resource_path('css/admin/inventory-index.css');
@endphp

@if (file_exists($publicCssPath))
    <link rel="stylesheet" href="{{ asset('css/admin/inventory-index.css') }}">
@elseif (function_exists('vite'))
    @vite(['resources/css/admin/inventory-index.css'])
@elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
    <style>
        {!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}
    </style>
@endif

<div class="admin-inventory-page">

    <!-- Page header -->
    <div class="admin-page-header">
        <h1>Inventory</h1>
    </div>

    <!-- Action bar -->
    <div class="admin-action-bar">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">← Back to Dashboard</a>
        <a href="{{ route('admin.inventory.create') }}" class="btn btn-primary">+ Add Inventory Record</a>
    </div>

    <!-- Success message -->
    @if(session('success'))
        <div class="alert alert-success">
            ✓ {{ session('success') }}
        </div>
    @endif

    <!-- Inventory table -->
    <div class="inventory-table-wrapper">
        <table class="inventory-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Stock Quantity</th>
                    <th>Reorder Level</th>
                    <th>Max Stock Level</th>
                    <th>Last Restocked</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventories as $inventory)
                <tr>
                    <td>{{ $inventory->inventory_id }}</td>
                    <td>{{ $inventory->product->product_name ?? 'N/A' }}</td>
                    <td>{{ number_format($inventory->stock_quantity) }}</td>
                    <td>{{ number_format($inventory->reorder_level) }}</td>
                    <td>{{ number_format($inventory->max_stock_level) }}</td>
                    <td>{{ $inventory->last_restocked ? $inventory->last_restocked->format('Y-m-d') : 'N/A' }}</td>
                    <td class="actions-cell">
                        <a href="{{ route('admin.inventory.edit', $inventory->inventory_id) }}" class="btn-link edit">Edit</a>
                        <span class="action-separator">|</span>
                        <form action="{{ route('admin.inventory.destroy', $inventory->inventory_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-link delete" onclick="return confirm('Are you sure you want to delete this inventory record?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="table-empty">
                        No inventory records found. <a href="{{ route('admin.inventory.create') }}">Add one</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
