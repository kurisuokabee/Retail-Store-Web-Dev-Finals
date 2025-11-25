<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Product;

class InventoryController extends Controller
{
    // List all inventory records
    public function index()
    {
        $inventories = Inventory::with('product')->get();
        return view('admin.inventory.index', compact('inventories'));
    }

    // Show create form
    public function create()
    {
        $products = Product::all(); // To select which product this inventory belongs to
        return view('admin.inventory.create', compact('products'));
    }

    // Store new inventory
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|unique:inventories,product_id',
            'stock_quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'max_stock_level' => 'required|integer|min:1',
            'last_restocked' => 'nullable|date',
        ]);

        Inventory::create($request->all());

        return redirect()->route('admin.inventory.index')->with('success', 'Inventory created successfully.');
    }

    // Show edit form
    public function edit(Inventory $inventory)
    {
        $products = Product::all();
        return view('admin.inventory.edit', compact('inventory', 'products'));
    }

    // Update inventory
    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'product_id' => 'required|unique:inventories,product_id,' . $inventory->inventory_id . ',inventory_id',
            'stock_quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'max_stock_level' => 'required|integer|min:1',
            'last_restocked' => 'nullable|date',
        ]);

        $inventory->update($request->all());

        return redirect()->route('admin.inventory.index')->with('success', 'Inventory updated successfully.');
    }

    // Delete inventory
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('admin.inventory.index')->with('success', 'Inventory deleted successfully.');
    }
}
