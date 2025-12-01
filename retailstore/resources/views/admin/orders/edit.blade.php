@extends('layouts.app')

@section('title', 'Update Order')

@section('content')
    <!-- Main heading of the page displaying the order ID -->
    <h1>Update Order #{{ $order->order_id }}</h1>

    <!-- Link to go back to the orders list -->
    <a href="{{ route('admin.orders.index') }}">Back to Orders</a>

    <!-- Display validation errors from the backend if any exist -->
    @if ($errors->any())
        <!-- Errors are displayed in red color -->
        <div style="color:red;">
            <ul>
                <!-- Loop through all errors and display each one as a list item -->
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form to update an existing order -->
    <form action="{{ route('admin.orders.update', $order->order_id) }}" method="POST">
        <!-- CSRF token for security to prevent cross-site request forgery -->
        @csrf
        <!-- Use PUT HTTP method for updating the resource -->
        @method('PUT')

        <p>
            <!-- Label and dropdown for order status -->
            <label>Order Status:</label><br>
            <!-- Select input with pre-selected value based on current order status -->
            <select name="order_status" required>
                <option value="pending" @if($order->order_status == 'pending') selected @endif>Pending</option>
                <option value="processing" @if($order->order_status == 'processing') selected @endif>Processing</option>
                <option value="completed" @if($order->order_status == 'completed') selected @endif>Completed</option>
                <option value="cancelled" @if($order->order_status == 'cancelled') selected @endif>Cancelled</option>
            </select>
        </p>

        <p>
            <!-- Label and dropdown for payment status -->
            <label>Payment Status:</label><br>
            <!-- Select input with pre-selected value based on current payment status -->
            <select name="payment_status" required>
                <option value="pending" @if($order->payment_status == 'pending') selected @endif>Pending</option>
                <option value="paid" @if($order->payment_status == 'paid') selected @endif>Paid</option>
                <option value="failed" @if($order->payment_status == 'failed') selected @endif>Failed</option>
            </select>
        </p>

        <p>
            <!-- Submit button to update the order -->
            <button type="submit">Update Order</button>
        </p>
    </form>
@endsection
