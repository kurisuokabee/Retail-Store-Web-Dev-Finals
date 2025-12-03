@extends('layouts.app')

@section('title', 'Orders')

@section('content')
    <!-- Force-load orders-index.css (same loading pattern as other admin pages) -->
    @php
        $publicCssPath = public_path('css/admin/orders-index.css');
        $resourceCssPath = resource_path('css/admin/orders-index.css');
    @endphp

    @if (file_exists($publicCssPath))
        <link rel="stylesheet" href="{{ asset('css/admin/orders-index.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/admin/orders-index.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
        <style>
            {!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}
        </style>
    @endif

<div class="admin-orders-page">
    <!-- Page header -->
    <div class="admin-page-header">
        <h1>Orders</h1>
    </div>

    <!-- Action bar: back button uses shared admin button styles -->
    <div class="admin-action-bar">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">← Back to Dashboard</a>
    </div>

    <!-- Success message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Orders table -->
    <div class="orders-table-wrapper">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->customer->username ?? 'N/A' }}</td>
                        <td>{{ $order->order_date }}</td>
                        <td>{{ $order->order_status }}</td>
                        <td>{{ $order->payment_status }}</td>
                        <td>{{ $order->total_amount }}</td>
                        <td class="actions-cell">
                            <a href="{{ route('admin.orders.show', $order->order_id) }}" class="btn-link edit">View</a>
                            <span class="action-separator">|</span>
                            <a href="{{ route('admin.orders.edit', $order->order_id) }}" class="btn-link edit">Update</a>
                            <span class="action-separator">|</span>
                            <form action="{{ route('admin.orders.destroy', $order->order_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-link delete" onclick="return confirm('Delete this order?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="table-empty">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
