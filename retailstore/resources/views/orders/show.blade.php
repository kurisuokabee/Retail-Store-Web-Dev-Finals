@extends('layouts.app')

@section('content')
<div>
    <h1>Order Details</h1>
    
    @if (session('success'))
        <div style="color: green; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px;">
        <h3>Order #{{ $order->order_id }}</h3>
        <p><strong>Order Date:</strong> {{ $order->order_date->format('M d, Y H:i') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->order_status) }}</p>
        <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
        <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
        <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
        <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
    </div>

    <h2>Order Items</h2>
    <table border="1" cellpadding="10" style="width: 100%;">
        <thead>
            <tr>
                <th>Product</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderDetails as $detail)
                <tr>
                    <td>{{ $detail->product->product_name }}</td>
                    <td>{{ $detail->product->description }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>${{ number_format($detail->unit_price, 2) }}</td>
                    <td>${{ number_format($detail->unit_price * $detail->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="text-align: right; margin-top: 20px; font-size: 18px; font-weight: bold;">
        <p>Order Total: ${{ number_format($order->total_amount, 2) }}</p>
    </div>

    <div style="margin-top: 20px;">
        <a href="{{ route('orders.history') }}">Back to Order History</a>
        <span style="margin: 0 10px;">|</span>
        <a href="{{ route('products.browse') }}">Continue Shopping</a>
    </div>
</div>
@endsection
