<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.product.index',[
            'products' =>  InventoryItem::all()
           ]);
    }

    public function getListProducts()
    {
        // Get all inventory items, you can modify this to paginate or filter as needed
        $items = InventoryItem::all();

        return response()->json([
            'success' => true,
            'message' => 'Inventory items retrieved successfully',
            'data' => $items
        ], 200);
    }

    public function getInventoryWithStock()
    {
       // Get all inventory items
    $items = InventoryItem::all()->map(function ($item) {
        // Calculate total stock in and stock out from pivot tables
        $stokMasuk = $item->stockIns()->sum('stock_in_inventory_item.quantity');
        $stokKeluar = $item->stockOuts()->sum('stock_out_inventory_item.quantity');

        // Add stok_masuk and stok_keluar to each item
        return [
            'id' => $item->id,
            'division_id' => $item->division_id,
            'name' => $item->name,
            'category' => $item->category,
            'stock_quantity' => $item->stock_quantity,
            'thumbnail' => $item->thumbnail,
            'unit' => $item->unit,
            'unit_price' => $item->unit_price,
            'stok_masuk' => $stokMasuk,
            'stok_keluar' => $stokKeluar,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    });

    return response()->json([
        'success' => true,
        'message' => 'Inventory items with stock details retrieved successfully',
        'data' => $items
    ], 200);
    }


    public function countStock()
{
    // Sum the quantities from the stock_in_inventory_item table
    $totalStockIn = DB::table('stock_in_inventory_item')->sum('quantity');
    $totalStockOut = DB::table('stock_out_inventory_item')->sum('quantity');

    return response()->json([
        'success' => true,
        'message' => 'Total stock in quantity calculated successfully',
        'total_stock_in' => $totalStockIn,
        'total_stock_out' => $totalStockOut
    ], 200);
}

public function getStockMovements()
{
    // Get stock in data with related inventory items
    $stockIns = StockIn::with('inventoryItems')
        ->get()
        ->map(function($stockIn) {
            return [
                'id' => $stockIn->id,
                'type' => 'stock_in',  // To differentiate stock in and out
                'inventory_items' => $stockIn->inventoryItems->map(function($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'quantity' => $item->pivot->quantity,
                        'unit' => $item->unit,
                        'category' => $item->category,
                        'thumbnail' => $item->thumbnail


                    ];
                }),
                'notes' => $stockIn->notes,
                'date' => $stockIn->created_at,
            ];
        });

    // Get stock out data with related inventory items
    $stockOuts = StockOut::with('inventoryItems')
        ->get()
        ->map(function($stockOut) {
            return [
                'id' => $stockOut->id,
                'type' => 'stock_out',  // To differentiate stock in and out
                'inventory_items' => $stockOut->inventoryItems->map(function($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'quantity' => $item->pivot->quantity,
                        'unit' => $item->unit,
                        'category' => $item->category,
                        'thumbnail' => $item->thumbnail
                    ];
                }),
                'notes' => $stockOut->notes,
                'date' => $stockOut->created_at,
            ];
        });

    // Merge stock in and stock out data
    $stockMovements = $stockIns->merge($stockOuts)->sortByDesc('date')->values();

    return response()->json([
        'success' => true,
        'message' => 'Stock movements retrieved successfully',
        'data' => $stockMovements
    ], 200);
}

public function getTotalProductStock()
{
    // Fetch all products from the inventory_items table
    $inventoryItems = InventoryItem::all();

    // Initialize total stock and product count
    $totalStock = 0;
    $totalProducts = 0;

    // Loop through each item to calculate the total stock
    foreach ($inventoryItems as $item) {
        $totalStock += $item->stock_quantity; // Sum all stock quantities
        $totalProducts++; // Count total number of products
    }

    // Return the total stock and total number of products
    return response()->json([
        'success' => true,
        'message' => 'Total product stock and product count retrieved successfully',
        'data' => [
            'total_products' => $totalProducts,
            'total_stock' => $totalStock,
            'products' => $inventoryItems,
        ]
    ], 200);
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.product.create');
    }

    // Handle the form submission to store the new product
    public function store(Request $request)
    {
        // Validate the input fields
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category' => 'required|max:255',
            'stock_quantity' => 'required|integer',
            'unit' => 'required|max:50',
            'unit_price' => 'required|numeric',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle thumbnail file upload (if exists)
        if ($request->hasFile('thumbnail')) {
            $validatedData['thumbnail'] = $request->file('thumbnail')->store('product-thumbnails', 'public');
        }

        // Create the new product
        InventoryItem::create($validatedData);

        // Redirect with success message
        return redirect('/dashboard/product')->with('success', 'Produk baru berhasil dibuat!');
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
    public function edit($id)
    {
        // Fetch the product by ID
        $product = InventoryItem::findOrFail($id);

        // Return the edit view with the product's data
        return view('dashboard.product.edit', compact('product'));
    }

    // Handle the form submission to update a product
    public function update(Request $request, $id)
    {
        // Validate the request input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'stock_quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'unit_price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional thumbnail
        ]);

        // Fetch the product by ID
        $product = InventoryItem::findOrFail($id);

        // Update the product data
        $product->name = $validatedData['name'];
        $product->category = $validatedData['category'];
        $product->stock_quantity = $validatedData['stock_quantity'];
        $product->unit = $validatedData['unit'];
        $product->unit_price = $validatedData['unit_price'];

        // If a new thumbnail is uploaded, handle the file upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('product-thumbnails', 'public');
            $product->thumbnail = $thumbnailPath;
        }

        // Save the changes to the database
        $product->save();

        // Redirect back to the product list with a success message
        return redirect()->route('product.index')->with('success', 'Product berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the product by ID
        $product = InventoryItem::findOrFail($id);

        // Check if a thumbnail exists and delete the file if it does
        if ($product->thumbnail) {
            Storage::delete('public/' . $product->thumbnail);
        }

        // Delete the product
        $product->delete();

        // Redirect back to the product list with a success message
        return redirect()->route('product.index')->with('success', 'Produk berhasil dihapus!');
    }
}
