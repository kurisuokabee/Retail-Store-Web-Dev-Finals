<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Browse all products with categories and inventory
     */
    public function browse()
    {
        $products = Product::with(['category', 'inventory'])->where('is_active', true)->paginate(10);
        $categories = Category::all();
        return view('products.browse', compact('products', 'categories'));
    }

    /**
     * View product details
     */
    public function details($product_id)
    {
        $product = Product::with(['category', 'supplier', 'inventory'])->findOrFail($product_id);
        return view('products.details', compact('product'));
    }

    /**
     * Filter products by category
     */
    public function filterByCategory($category_id)
    {
        $products = Product::where('category_id', $category_id)
                            ->where('is_active', true)
                            ->with(['category', 'inventory'])
                            ->paginate(10);
        $categories = Category::all();
        return view('products.browse', compact('products', 'categories'));
    }

    /**
     * Add product to cart
     */
    public function addToCart(Request $request, $product_id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($product_id);
        $inventory = $product->inventory;

        if (!$inventory || $inventory->stock_quantity < $validated['quantity']) {
            return back()->withErrors(['error' => 'Insufficient stock available']);
        }

        $cart = session('cart', []);
        $quantity = (int) $validated['quantity'];
        
        if (isset($cart[$product_id])) {
            $cart[$product_id] += $quantity;
        } else {
            $cart[$product_id] = $quantity;
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Product added to cart!');
    }

    /**
     * Remove product from cart
     */
    public function removeFromCart($product_id)
    {
        $cart = session('cart', []);
        unset($cart[$product_id]);
        session(['cart' => $cart]);

        return back()->with('success', 'Product removed from cart');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
