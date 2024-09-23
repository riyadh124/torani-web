<?php

namespace App\Http\Controllers;

use App\Models\StockOut;
use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\StockIn;
use Illuminate\Support\Facades\DB;

class StockOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.stock-out.index',[
            'stocks' =>  StockOut::with('inventoryItems')->get()
           ]);
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
      
        // Validate the incoming request
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.inventory_item_id' => 'required|exists:inventory_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

            // Create a new StockOut record
            $stockOut = StockOut::create([
                'notes' => $request->input('notes'),
            ]);

            // Iterate through each inventory item and perform stock reduction
            foreach ($validated['items'] as $item) {
                $inventoryItem = InventoryItem::find($item['inventory_item_id']);

                // Check if there's enough stock for this item
                if ($inventoryItem->stock_quantity < $item['quantity']) {
                    return response()->json([
                        'error' => 'Insufficient stock for item: ' . $inventoryItem->name,
                    ], 400);
                }

                // Reduce the stock quantity
                $inventoryItem->stock_quantity -= $item['quantity'];
                $inventoryItem->save();

                // Attach the item to the StockOut entry with the quantity
                $stockOut->inventoryItems()->attach($inventoryItem->id, [
                    'quantity' => $item['quantity'],
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Stock out recorded successfully',
                'stock_out' => $stockOut,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to create stock out: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stockOut = StockOut::with('inventoryItems')->findOrFail($id);
        return view('dashboard.stock-out.show',[
            'stockOut' => $stockOut
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
