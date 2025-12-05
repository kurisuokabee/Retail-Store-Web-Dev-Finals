@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
    <!-- Force-load orders-show.css -->
    @php
        $publicCssPath = public_path('css/admin/orders-show.css');
        $resourceCssPath = resource_path('css/admin/orders-show.css');
    @endphp

    @if (file_exists($publicCssPath))
        <link rel="stylesheet" href="{{ asset('css/admin/orders-show.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/admin/orders-show.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
        <style>
            {!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}
        </style>
    @endif

<div class="admin-orders-show-page">
    <div class="admin-page-header">
        <h1>Order #{{ $order->order_id }} Details</h1>
    </div>

    <a href="{{ route('admin.orders.index') }}" class="back-link">← Back to Orders</a>

    <!-- Customer and order information -->
    <div class="order-meta">
        <div class="meta-item"><strong>Customer:</strong> {{ $order->customer->username ?? 'N/A' }}</div>
        <div class="meta-item"><strong>Order Date:</strong> {{ $order->order_date }}</div>
        <div class="meta-item"><strong>Status:</strong> {{ $order->order_status }}</div>
        <div class="meta-item"><strong>Payment:</strong> {{ $order->payment_status }}</div>
        <div class="meta-item"><strong>Total:</strong> {{ $order->total_amount }}</div>
    </div>

    <!-- Section for order items -->
    <h3>Order Items:</h3>
    <table class="order-items-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderDetails as $item)
            <tr>
                <td>{{ $item->product->product_name ?? 'N/A' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->unit_price }}</td>
                <td>{{ $item->subtotal }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
