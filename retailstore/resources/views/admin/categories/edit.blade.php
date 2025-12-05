@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')

    @php
        $publicCssPath = public_path('css/admin/categories-create.css');
        $resourceCssPath = resource_path('css/admin/categories-create.css');
    @endphp

    @if (file_exists($publicCssPath))
        <link rel="stylesheet" href="{{ asset('css/admin/categories-create.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/admin/categories-create.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
        <style>
            {!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}
        </style>
    @endif

<div class="admin-products-create-page">
    <div class="admin-page-header">
        <h1>Edit Category</h1>
    </div>

    <a href="{{ route('admin.categories.index') }}" class="back-link">← Back to Categories</a>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.update', $category->category_id) }}" method="POST" class="form-container">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="category_name">Category Name:</label>
            <input type="text" id="category_name" name="category_name" value="{{ old('category_name', $category->category_name) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="is_active">Status:</label>
            <select id="is_active" name="is_active">
                <option value="1" {{ old('is_active', $category->is_active) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('is_active', $category->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Update Category</button>
            <a href="{{ route('admin.categories.index') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

@endsection
