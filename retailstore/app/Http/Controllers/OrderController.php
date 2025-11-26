<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * View customer's order history
     */
    public function history()
    {
        $customer_id = Auth::user()->customer_id;
        $orders = Order::where('customer_id', $customer_id)
                        ->with('orderDetails.product')
                        ->orderBy('order_date', 'desc')
                        ->paginate(10);
        return view('orders.history', compact('orders'));
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        // Verify customer owns this order
        if ($order->customer_id !== Auth::user()->customer_id) {
            abort(403);
        }

        $order->load('orderDetails.product');
        return view('orders.show', compact('order'));
    }

    /**
     * Show cart and checkout form
     */
    public function create()
    {
        $cart = session('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $product_id => $quantity) {
            $product = Product::findOrFail($product_id);
            $subtotal = $product->unit_price * $quantity;
            $cartItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
            $total += $subtotal;
        }

        if (empty($cartItems)) {
            return redirect()->route('products.browse')->with('error', 'Your cart is empty');
        }

        return view('orders.create', compact('cartItems', 'total'));
    }

    /**
     * Store the order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:credit_card,debit_card,cash',
            'shipping_address' => 'required|string',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('products.browse')->with('error', 'Your cart is empty');
        }

        DB::beginTransaction();

        try {
            $total = 0;
            foreach ($cart as $product_id => $quantity) {
                $product = Product::findOrFail($product_id);
                $total += $product->unit_price * $quantity;
            }

            // Create order
            $order = Order::create([
                'customer_id' => Auth::user()->customer_id,
                'order_date' => now(),
                'order_status' => 'pending',
                'total_amount' => $total,
                'payment_status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'shipping_address' => $validated['shipping_address'],
            ]);

            // Create order details and update inventory
            foreach ($cart as $product_id => $quantity) {
                $product = Product::findOrFail($product_id);

                $subtotal = $product->unit_price * $quantity;  // 🔥 NEW LINE

                OrderDetail::create([
                    'order_id' => $order->order_id,
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'unit_price' => $product->unit_price,
                    'subtotal' => $subtotal,                    // 🔥 REQUIRED
                ]);

                // Update inventory
                $inventory = Inventory::where('product_id', $product_id)->first();
                if ($inventory) {
                    $inventory->stock_quantity -= $quantity;
                    $inventory->save();
                }
            }

            DB::commit();

            session()->forget('cart');

            return redirect()->route('orders.show', $order->order_id)
                        ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to place order: ' . $e->getMessage()]);
        }
    }
    

    
}
