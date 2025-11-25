<!DOCTYPE html>
<html>
<head>
    <title>Update Order</title>
</head>
<body>
<h1>Update Order #{{ $order->order_id }}</h1>

<a href="{{ route('admin.orders.index') }}">Back to Orders</a>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.orders.update', $order->order_id) }}" method="POST">
    @csrf
    @method('PUT')

    <p>
        <label>Order Status:</label><br>
        <select name="order_status" required>
            <option value="pending" @if($order->order_status == 'pending') selected @endif>Pending</option>
            <option value="processing" @if($order->order_status == 'processing') selected @endif>Processing</option>
            <option value="completed" @if($order->order_status == 'completed') selected @endif>Completed</option>
            <option value="cancelled" @if($order->order_status == 'cancelled') selected @endif>Cancelled</option>
        </select>
    </p>

    <p>
        <label>Payment Status:</label><br>
        <select name="payment_status" required>
            <option value="pending" @if($order->payment_status == 'pending') selected @endif>Pending</option>
            <option value="paid" @if($order->payment_status == 'paid') selected @endif>Paid</option>
            <option value="failed" @if($order->payment_status == 'failed') selected @endif>Failed</option>
        </select>
    </p>

    <p>
        <button type="submit">Update Order</button>
    </p>
</form>
</body>
</html>
