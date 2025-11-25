<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;

class ProductController extends Controller
{
    // List all products
    public function index()
    {
        // Eager load category and supplier
        $products = Product::with(['category', 'supplier'])->get();

        return view('admin.products.index', compact('products'));
    }

    // Show form to create a product
    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('admin.products.create', compact('categories', 'suppliers'));
    }

    // Store a new product
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:200',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,category_id',
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'unit_price' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'is_active' => 'required|boolean',
        ]);

        Product::create($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    // Show a single product
    public function show($id)
    {
        $product = Product::with(['category', 'supplier'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    // Show form to edit a product
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('admin.products.edit', compact('product', 'categories', 'suppliers'));
    }

    // Update a product
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:200',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,category_id',
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'unit_price' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'is_active' => 'required|boolean',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    // Delete a product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
