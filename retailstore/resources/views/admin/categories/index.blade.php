@extends('layouts.app')

@section('title', 'Categories')

@section('content')

    <!-- Force-load categories-index.css -->
    @php
        $publicCssPath = public_path('css/admin/categories-index.css');
        $resourceCssPath = resource_path('css/admin/categories-index.css');
    @endphp

    @if (file_exists($publicCssPath))
        <link rel="stylesheet" href="{{ asset('css/admin/categories-index.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/admin/categories-index.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
        <style>
            {!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}
        </style>
    @endif

<div class="admin-categories-page">
    <!-- Page header -->
    <div class="admin-page-header">
        <h1>Categories</h1>
    </div>

    <!-- Action bar -->
    <div class="admin-action-bar">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            ← Back to Dashboard
        </a>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            + Add New Category
        </a>
    </div>

    <!-- Success message -->
    @if(session('success'))
        <div class="alert alert-success">
            ✓ {{ session('success') }}
        </div>
    @endif

    <!-- Categories table -->
    <div class="categories-table-wrapper">
        <table class="categories-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $category->category_id }}</td>
                    <td class="category-name">{{ $category->category_name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                        <span class="status-badge {{ $category->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="actions-cell">
                        <a href="{{ route('admin.categories.edit', $category->category_id) }}" class="btn-link edit">Edit</a>
                        <span class="action-separator">|</span>
                        <form action="{{ route('admin.categories.destroy', $category->category_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-link delete" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="table-empty">No categories found. <a href="{{ route('admin.categories.create') }}">Create one</a></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
