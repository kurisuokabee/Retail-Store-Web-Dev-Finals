@extends('layouts.app')

@section('title', 'Budega Philippines | Order Details')

@section('content')

    <!-- Force-load show.css here -->
    @php
        $publicCssPath = public_path('css/show.css');
        $resourceCssPath = resource_path('css/show.css');
    @endphp

    @if (file_exists($publicCssPath))
        <link rel="stylesheet" href="{{ asset('css/show.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/show.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
        <style>
            {!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}
        </style>
    @endif

<header>
    @include('components.navbar')
</header>

<main class="container">
    <h1>Order Details</h1>

    @if (session('success'))
        <p style="color: green; margin-bottom: 15px;">{{ session('success') }}</p>
    @endif

    <div class="order-details-page">
        <!-- Left: Order items -->
        <section class="panel order-items-panel">
            <h2>Items in Order #{{ $order->order_id }}</h2>

            <div class="order-items">
                @foreach ($order->orderDetails as $detail)
                    @php
                        $product = $detail->product ?? null;
                        $thumb = $product->image_url ?? '/images/generic-product.png';
                        if (!preg_match('/^https?:\\/\\//i', $thumb)) {
                            $thumb = asset(ltrim($thumb, '/'));
                        }
                    @endphp
                    <div class="order-item">
                        <img class="thumb" src="{{ $thumb }}" alt="{{ $product->product_name ?? 'Product' }}" loading="lazy">
                        <div>
                            <div class="item-name">{{ $product->product_name ?? 'Product' }}</div>
                            <div class="item-meta">{{ $detail->quantity }} × ${{ number_format($detail->unit_price, 2) }}</div>
                            @if(!empty($product->description))
                                <div class="item-meta" style="margin-top:6px; color: var(--muted); font-size:13px;">
                                    {{ strlen($product->description) > 120 ? substr($product->description, 0, 120) . '...' : $product->description }}
                                </div>
                            @endif
                        </div>
                        <div style="text-align:right;">
                            <div class="item-price">${{ number_format($detail->unit_price * $detail->quantity, 2) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order actions -->
            <div class="order-actions">
                <a href="{{ route('orders.history') }}" class="btn btn-ghost">Back to Orders</a>
            </div>
        </section>

        <!-- Right: Order metadata & totals -->
        <aside class="panel order-meta">
            <h2>Order Summary</h2>

            <div class="meta-row">
                <div class="meta-title">Order Date</div>
                <div class="meta-value">{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y H:i') }}</div>
            </div>
            <div class="meta-row">
                <div class="meta-title">Order Status</div>
                <div class="meta-value">{{ ucfirst($order->order_status) }}</div>
            </div>
            <div class="meta-row">
                <div class="meta-title">Payment Status</div>
                <div class="meta-value">{{ ucfirst($order->payment_status) }}</div>
            </div>
            <div class="meta-row">
                <div class="meta-title">Payment Method</div>
                <div class="meta-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</div>
            </div>
            <div class="meta-row">
                <div class="meta-title">Shipping Address</div>
                <div class="meta-value" style="max-width: 240px; text-align:right;">{{ $order->shipping_address }}</div>
            </div>

            <div class="order-totals">
                <div class="totals-row">
                    <span>Items</span>
                    <span>${{ number_format($order->subtotal_amount ?? ($order->total_amount - ($order->shipping_fee ?? 0)), 2) }}</span>
                </div>
                <div class="totals-row">
                    <span>Shipping</span>
                    <span>${{ number_format($order->shipping_fee ?? 0.00, 2) }}</span>
                </div>
                <div class="totals-row total">
                    <span>Total</span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </aside>
    </div>
</main>

@endsection
