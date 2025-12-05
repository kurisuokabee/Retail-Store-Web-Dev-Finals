@extends('layouts.app')

@section('title', 'Update Order')

@section('content')
    <!-- Force-load orders-edit.css -->
    @php
        $publicCssPath = public_path('css/admin/orders-edit.css');
        $resourceCssPath = resource_path('css/admin/orders-edit.css');
    @endphp

    @if (file_exists($publicCssPath))
        <link rel="stylesheet" href="{{ asset('css/admin/orders-edit.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/admin/orders-edit.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
        <style>
            {!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}
        </style>
    @endif

<div class="admin-orders-edit-page">
    <!-- Page header and back link -->
    <div class="admin-page-header">
        <h1>Update Order #{{ $order->order_id }}</h1>
    </div>

    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary back-link">← Back to Orders</a>

    <!-- Display validation errors from the backend if any exist -->
    @if ($errors->any())
        <div class="alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form to update an existing order -->
    <form action="{{ route('admin.orders.update', $order->order_id) }}" method="POST" class="form-container">
        <!-- CSRF token for security to prevent cross-site request forgery -->
        @csrf
        <!-- Use PUT HTTP method for updating the resource -->
        @method('PUT')

        <div class="form-group">
            <label for="order_status">Order Status</label>
            <select id="order_status" name="order_status" required>
                <option value="pending" @if($order->order_status == 'pending') selected @endif>Pending</option>
                <option value="processing" @if($order->order_status == 'processing') selected @endif>Processing</option>
                <option value="completed" @if($order->order_status == 'completed') selected @endif>Completed</option>
                <option value="cancelled" @if($order->order_status == 'cancelled') selected @endif>Cancelled</option>
            </select>
        </div>

        <div class="form-group">
            <label for="payment_status">Payment Status</label>
            <select id="payment_status" name="payment_status" required>
                <option value="pending" @if($order->payment_status == 'pending') selected @endif>Pending</option>
                <option value="paid" @if($order->payment_status == 'paid') selected @endif>Paid</option>
                <option value="failed" @if($order->payment_status == 'failed') selected @endif>Failed</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Update Order</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
