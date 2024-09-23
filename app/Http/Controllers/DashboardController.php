<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Workorder;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\InventoryItem;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua form dengan relasi checks dan user
    // $forms = Form::with('checks', 'user')->get();
    
    // Menghitung total stock in dan stock out
    $totalStockIn = DB::table('stock_in_inventory_item')->sum('quantity');
    $totalStockOut = DB::table('stock_out_inventory_item')->sum('quantity');

    
    // Menghitung jumlah produk yang didaftarkan
    $totalProducts = InventoryItem::count();
    
    // Menghitung jumlah stok saat ini
    $currentStock = InventoryItem::sum('stock_quantity');

    return view('dashboard.index', [
        'totalStockIn' => $totalStockIn,
        'totalStockOut' => $totalStockOut,
        'totalProducts' => $totalProducts,
        'currentStock' => $currentStock,
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $workorder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $workorder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $workorder)
    {
        
    }
}
