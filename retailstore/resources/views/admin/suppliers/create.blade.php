@extends('layouts.app')

@section('title', 'Add Supplier')

@section('content')

<!-- Force-load supplier-add.css -->
@php
    $publicCssPath = public_path('css/admin/suppliers-create.css');
    $resourceCssPath = resource_path('css/admin/suppliers-create.css');
@endphp

@if (file_exists($publicCssPath))
    <link rel="stylesheet" href="{{ asset('css/admin/suppliers-create.css') }}">
@elseif (function_exists('vite'))
    @vite(['resources/css/admin/suppliers-create.css'])
@elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
    <style>
        {!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}
    </style>
@endif

<div class="admin-suppliers-create-page">

    <!-- Page header -->
    <div class="admin-page-header">
        <h1>Add New Supplier</h1>
    </div>

    <!-- Back link -->
    <a href="{{ route('admin.suppliers.index') }}" class="back-link">← Back to Suppliers</a>

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

    <!-- Add Supplier Form -->
    <form action="{{ route('admin.suppliers.store') }}" method="POST" class="form-container">
        @csrf

        <div class="form-group">
            <label for="supplier_name">Supplier Name:</label>
            <input type="text" id="supplier_name" name="supplier_name" value="{{ old('supplier_name') }}" required>
        </div>

        <div class="form-group">
            <label for="contact_person">Contact Person:</label>
            <input type="text" id="contact_person" name="contact_person" value="{{ old('contact_person') }}">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}">
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <textarea id="address" name="address">{{ old('address') }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Add Supplier</button>
            <a href="{{ route('admin.suppliers.index') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>

</div>

@endsection
