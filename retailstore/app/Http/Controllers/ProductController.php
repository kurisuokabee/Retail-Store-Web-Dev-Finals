<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Browse all products with categories and inventory
     */
    public function browse(Request $request)
    {
        // Base query with relationships
        $q = Product::with(['category', 'inventory']);

        // Apply category/in-stock/price filters (unchanged)
        if ($request->filled('category')) {
            $q->where('category_id', $request->category);
        }
        if ($request->filled('in_stock')) {
            $q->whereHas('inventory', function ($inventoryQ) {
                $inventoryQ->where('stock_quantity', '>', 0);
            });
        }
        if ($request->filled('min_price')) {
            $q->where('unit_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $q->where('unit_price', '<=', $request->max_price);
        }

        // Apply the search query (if present)
        $searchTerm = $request->input('query');
        if ($searchTerm !== null && trim($searchTerm) !== '') {
            $q->search($searchTerm);
        }

        // Apply the in-stock filter using boolean request helper to check for truthiness
        if ($request->boolean('in_stock')) {
            $q->inStock();
        }

        // Apply sorting scope & pagination and preserve query string
        $sort = $request->query('sort');
        $products = $q->applySort($sort)
            ->paginate(12)
            ->appends($request->query()); // preserve sorting/searching filters in pagination

        $categories = Category::all();

        return view('products.browse', compact('products', 'categories'));
    }

    /**
     * View product details
     */
    public function details($product_id)
    {
        $product = Product::with(['category', 'supplier', 'inventory'])
            ->findOrFail($product_id);

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
            ->get(); // <-- changed

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
     * Store a new product
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'unit_price' => 'required|numeric',
            'image' => 'nullable|image|max:2048', // add image validation
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        $product = Product::create($data);

        return back()->with('success', 'Product created!');
    }

    /**
     * Update an existing product
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'unit_price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // delete previous image (if any)
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        $product->update($data);

        return back()->with('success', 'Product updated!');
    }
}
