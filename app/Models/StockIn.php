<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $fillable = ['notes'];

    public function inventoryItems()
    {
        return $this->belongsToMany(InventoryItem::class, 'stock_in_inventory_item')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
