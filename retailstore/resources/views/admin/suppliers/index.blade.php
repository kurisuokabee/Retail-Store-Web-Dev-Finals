@extends('layouts.app')

@section('title', 'Suppliers')

@section('content')

<!-- Force-load supplier-index.css -->
@php
    $publicCssPath = public_path('css/admin/suppliers-index.css');
    $resourceCssPath = resource_path('css/admin/suppliers-index.css');
@endphp

@if (file_exists($publicCssPath))
    <link rel="stylesheet" href="{{ asset('css/admin/suppliers-index.css') }}">
@elseif (function_exists('vite'))
    @vite(['resources/css/admin/suppliers-index.css'])
@elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
    <style>
        {!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}
    </style>
@endif

<div class="admin-suppliers-page">

    <!-- Page header -->
    <div class="admin-page-header">
        <h1>Suppliers</h1>
    </div>

    <!-- Action bar -->
    <div class="admin-action-bar">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">← Back to Dashboard</a>
        <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">+ Add New Supplier</a>
    </div>

    <!-- Success message -->
    @if(session('success'))
        <div class="alert alert-success">
            ✓ {{ session('success') }}
        </div>
    @endif

    <!-- Suppliers table -->
    <div class="suppliers-table-wrapper">
        <table class="suppliers-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Supplier Name</th>
                    <th>Contact Person</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->supplier_id }}</td>
                    <td>{{ $supplier->supplier_name }}</td>
                    <td>{{ $supplier->contact_person }}</td>
                    <td>{{ $supplier->email }}</td>
                    <td>{{ $supplier->phone }}</td>
                    <td>{{ $supplier->address }}</td>
                    <td class="actions-cell">
                        <a href="{{ route('admin.suppliers.edit', $supplier->supplier_id) }}" class="btn-link edit">Edit</a>
                        <span class="action-separator">|</span>
                        <form action="{{ route('admin.suppliers.destroy', $supplier->supplier_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-link delete" onclick="return confirm('Are you sure you want to delete this supplier?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="table-empty">No suppliers found. <a href="{{ route('admin.suppliers.create') }}">Add one</a></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
