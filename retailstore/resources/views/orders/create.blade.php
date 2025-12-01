@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<header>
    @include('components.navbar')
</header>

<div>
    <h1>Checkout</h1>

    <!-- Error messages -->
    @if ($errors->any())
        <div style="color: red; margin-bottom: 20px;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Order summary table -->
    <h2>Order Summary</h2>
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cartItems as $item)
                <tr>
                    <td>{{ $item['product']->product_name }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>${{ number_format($item['product']->unit_price, 2) }}</td>
                    <td>${{ number_format($item['subtotal'], 2) }}</td>
                    <td>
                        <form method="POST" action="{{ route('products.removeFromCart', $item['product']->product_id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="padding: 5px 10px;">Remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Total amount -->
    <h2 style="text-align: right; margin-top: 20px;">Total: ${{ number_format($total, 2) }}</h2>

    <!-- Delivery & Payment Form -->
    <h2>Delivery Information</h2>
    <form method="POST" action="{{ route('orders.store') }}">
        @csrf
        <div style="margin-bottom: 15px;">
            <label for="shipping_address">Shipping Address:</label><br>
            <textarea id="shipping_address" name="shipping_address" rows="4" cols="50" required></textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="payment_method">Payment Method:</label><br>
            <select id="payment_method" name="payment_method" required>
                <option value="">Select Payment Method</option>
                <option value="credit_card">Credit Card</option>
                <option value="debit_card">Debit Card</option>
                <option value="cash">Cash on Delivery</option>
            </select>
        </div>

        <button type="submit" style="padding: 10px 15px;">Place Order</button>
    </form>

    <!-- Continue shopping link -->
    <div style="margin-top: 20px;">
        <a href="{{ route('products.browse') }}">Continue Shopping</a>
    </div>
</div>
@endsection
