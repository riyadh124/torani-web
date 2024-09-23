<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;


    protected $fillable = ['notes'];

    public function inventoryItems()
    {
        return $this->belongsToMany(InventoryItem::class, 'stock_out_inventory_item')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
