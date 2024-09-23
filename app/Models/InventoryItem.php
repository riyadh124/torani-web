<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'stock_quantity',
        'unit',
        'unit_price',
        'thumbnail',
        'division_id',
    ];
    
    public function stockIns()
    {
        return $this->belongsToMany(StockIn::class, 'stock_in_inventory_item')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function stockOuts()
    {
        return $this->belongsToMany(StockOut::class, 'stock_out_inventory_item')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
