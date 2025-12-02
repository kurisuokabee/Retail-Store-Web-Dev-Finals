@extends('layouts.app')

@section('title', 'Budega Philippines | Order History')

@section('content')

    <!-- Force-load history.css here (same pattern used by other product/order pages) -->
    @php
        $publicCssPath = public_path('css/history.css');
        $resourceCssPath = resource_path('css/history.css');
    @endphp

    @if (file_exists($publicCssPath))
        <link rel="stylesheet" href="{{ asset('css/history.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/history.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
        <style>
            {!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}
        </style>
    @endif

<header>
    @include('components.navbar')
</header>

<main class="container">
    <h1>Order History</h1>

    @if (session('success'))
        <div class="alert alert-success" style="margin-bottom:12px;">
            {{ session('success') }}
        </div>
    @endif

    <section class="panel orders-list">
        @forelse ($orders as $order)
            <article class="order-card">
                <header class="order-card-head">
                    <div>
                        <div class="order-id">Order #{{ $order->order_id }}</div>

                        @php
                            // normalize status to safe CSS class names, e.g. "order-shipped"
                            $orderStatusClass = 'order-'.\Illuminate\Support\Str::slug($order->order_status ?? 'unknown', '-');
                            $paymentStatusClass = 'payment-'.\Illuminate\Support\Str::slug($order->payment_status ?? 'unknown', '-');
                        @endphp

                        <div class="order-meta small-muted">
                            Placed {{ $order->order_date->format('M d, Y H:i') }}
                            • Order<span class="status {{ $orderStatusClass }}">{{ ucfirst(str_replace('_',' ', $order->order_status)) }}</span>
                            • Payment<span class="payment {{ $paymentStatusClass }}">{{ ucfirst(str_replace('_',' ', $order->payment_status)) }}</span>
                        </div>
                    </div>
                    <div class="order-total">
                        <div class="total-label">Total</div>
                        <div class="total-amount">${{ number_format($order->total_amount, 2) }}</div>
                    </div>
                </header>

                <div class="order-body">
                    <div class="order-items">
                        @foreach ($order->orderDetails as $detail)
                            <div class="order-item-row">
                                <div class="item-thumb">
                                    @php
                                        $thumb = $detail->product->image_url ?? '/images/generic-product.png';
                                        if (!preg_match('/^https?:\\/\\//i', $thumb)) {
                                            $thumb = asset(ltrim($thumb, '/'));
                                        }
                                    @endphp
                                    <img src="{{ $thumb }}" alt="{{ $detail->product->product_name ?? 'Product' }}" loading="lazy">
                                </div>
                                <div class="item-info">
                                    <div class="item-name">{{ $detail->product->product_name ?? 'Product' }}</div>
                                    <div class="item-meta small-muted">{{ $detail->quantity }} × ${{ number_format($detail->unit_price, 2) }}</div>
                                </div>
                                <div class="item-subtotal">${{ number_format($detail->unit_price * $detail->quantity, 2) }}</div>
                            </div>
                        @endforeach
                    </div>

                    <div class="order-actions-row">
                        <a href="{{ route('orders.show', $order->order_id) }}" class="btn btn-view">View Details</a>
                    </div>
                </div>

                <footer class="order-card-foot">
                    <div class="shipping-address"><strong>Shipping:</strong> {{ $order->shipping_address }}</div>
                    <div class="payment-method small-muted">{{ ucfirst(str_replace('_',' ', $order->payment_method)) }}</div>
                </footer>
            </article>
        @empty
            <div class="empty-state panel">
                <p>No orders found.</p>
                <p class="small-muted">Once you place orders they'll appear here for tracking and details.</p>
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="pagination pagination-wrapper" style="margin-top: 16px;">
            {{ $orders->links() }}
        </div>
    </section>
</main>

@endsection
