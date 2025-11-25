<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Customer;

class OrderController extends Controller
{
    // List all orders
    public function index()
    {
        $orders = Order::with('customer')->get();
        return view('admin.orders.index', compact('orders'));
    }

    // Show a single order with details
    public function show(Order $order)
    {
        $order->load('customer', 'details.product');
        return view('admin.orders.show', compact('order'));
    }

    // Show edit form for processing/updating order
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    // Update order status and payment status
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:pending,processing,completed,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $order->update($request->only('order_status', 'payment_status'));

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');
    }

    // Delete order
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
}
