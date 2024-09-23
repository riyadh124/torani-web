<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\StockIn;
use Illuminate\Http\Request;

class StockInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.stock-in.index',[
            'stocks' =>  StockIn::with('inventoryItems')->get()
           ]);

    }

    // public function showStockIn($id)
    // {
       
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inventoryItems = InventoryItem::all();
        return view('dashboard.stock-in.create', compact('inventoryItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'items.*.inventory_item_id' => 'required|exists:inventory_items,id',
            'items.*.quantity' => 'required|integer|min:0', // Allow quantity to be 0, but we will handle it in logic
            'notes' => 'nullable|string',
        ]);

        // Create a new StockIn entry
        $stockIn = StockIn::create(['notes' => $request->input('notes')]);

        // Iterate through each item, and only add the stock for quantities greater than 0
        foreach ($validatedData['items'] as $item) {
            if ($item['quantity'] > 0) {  // Only process items with a quantity greater than 0
                $inventoryItem = InventoryItem::find($item['inventory_item_id']);
                $inventoryItem->stock_quantity += $item['quantity'];
                $inventoryItem->save();

                // Attach the stock-in record to the inventory item
                $stockIn->inventoryItems()->attach($inventoryItem->id, ['quantity' => $item['quantity']]);
            }
        }

        // Redirect back to the stock-in list with a success message
        return redirect()->route('stockIn.index')->with('success', 'Stock In berhasil ditambahkan!');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stockIn = StockIn::with('inventoryItems')->findOrFail($id);
        return view('dashboard.stock-in.show',[
            'stockIn' => $stockIn
           ]);
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
