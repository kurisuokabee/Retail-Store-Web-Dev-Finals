@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

    <!-- Force-load create.css here -->
    @php
        $publicCssPath = public_path('css/create.css');
        $resourceCssPath = resource_path('css/create.css');
    @endphp

    @if (file_exists($publicCssPath))
        <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/create.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
        <style>
            {!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}
        </style>
    @endif

<header>
    @include('components.navbar')
</header>

<main class="checkout-wrap">
    {{-- Continue Shopping removed --}}
    <div class="checkout-container">
        <h1>Checkout</h1>

        <!-- Error messages -->
        @if ($errors->any())
            <div style="color: red; margin-bottom: 20px;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="checkout-page">
            <!-- Left: Delivery & Payment -->
            <section class="panel checkout-panel">
                <h2>Shipping & Payment</h2>

                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf

                    <div class="form-row">
                        <div class="form-field">
                            <label for="shipping_fullname">Full name</label>
                            <input id="shipping_fullname" name="shipping_fullname" type="text" value="{{ old('shipping_fullname') }}" required>
                        </div>
                        <div class="form-field">
                            <label for="shipping_phone">Phone</label>
                            <input id="shipping_phone" name="shipping_phone" type="tel" value="{{ old('shipping_phone') }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-field" style="flex: 1 1 100%;">
                            <label for="shipping_address">Shipping Address</label>
                            <textarea id="shipping_address" name="shipping_address" rows="4" required>{{ old('shipping_address') }}</textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-field">
                            <label for="payment_method">Payment Method</label>
                            <select id="payment_method" name="payment_method" required>
                                <option value="">Select Payment Method</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="debit_card">Debit Card</option>
                                <option value="cash">Cash on Delivery</option>
                            </select>
                        </div>
                        <div class="form-field">
                            <label for="shipping_notes">Order notes (optional)</label>
                            <input id="shipping_notes" name="notes" type="text" value="{{ old('notes') }}" placeholder="Leave delivery instructions, etc.">
                        </div>
                    </div>

                    <div style="margin-top: 18px;">
                        <button type="submit" class="btn btn-primary btn-block">Place Order</button>
                    </div>
                </form>
            </section>

            <!-- Right: Order Summary -->
            <aside class="panel order-summary">
                <div class="summary-title">
                    <h2>Order Summary</h2>
                    <div class="form-note">Total: ${{ number_format($total, 2) }}</div>
                </div>

                <div class="order-items">
                    @foreach ($cartItems as $item)
                        @php
                            // quick image fallback, keep simple for checkout list
                            $thumb = $item['product']->image_url ?: '/images/generic-product.png';
                            // prefer absolute/asset path if not already absolute
                            if (!preg_match('/^https?:\\/\\//i', $thumb)) {
                                $thumb = asset(ltrim($thumb, '/'));
                            }
                        @endphp
                        <div class="order-item">
                            <img class="thumb" src="{{ $thumb }}" alt="{{ $item['product']->product_name ?? 'Product' }}" loading="lazy">
                            <div>
                                <div class="item-name">{{ $item['product']->product_name }}</div>
                                <div class="item-meta">{{ $item['quantity'] }} × ${{ number_format($item['product']->unit_price, 2) }}</div>
                            </div>
                            <div class="item-price">
                                <div>${{ number_format($item['subtotal'], 2) }}</div>
                                <form method="POST" action="{{ route('products.removeFromCart', $item['product']->product_id) }}" style="margin-top: 6px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-remove" aria-label="Remove item">Remove</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="order-totals">
                    <div class="totals-row">
                        <span>Items</span>
                        <span>${{ number_format($subtotal ?? $total, 2) }}</span>
                    </div>
                    <div class="totals-row">
                        <span>Shipping</span>
                        <span>${{ number_format($shipping ?? 0.00, 2) }}</span>
                    </div>
                    <div class="totals-row total">
                        <span>Order Total</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                </div>

            </aside>
        </div>

        <!-- bottom continue button removed (moved above checkout panels) -->

    </div>
</main>

@endsection
