<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\InventoryItem;
use App\Models\User;
use App\Models\Division;
use App\Models\StockIn;
use App\Models\StockOut;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $divisions = [
            ['name' => 'Kasir'],
            ['name' => 'Dapur Umum'],
            ['name' => 'Koki'],
            ['name' => 'Kapten'],
            ['name' => 'Cuci Piring'],
            ['name' => 'Waitress'],
            ['name' => 'Keseluruhan'],
        ];

        foreach ($divisions as $division) {
            Division::create($division);
        }

        $users = [
            [
                'name' => 'Admin Owner',
                'email' => 'owner@example.com',
                'password' => Hash::make('password'),
                'role' => 'Owner',
                'division_id' => Division::where('name', 'Keseluruhan')->first()->id,
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@example.com',
                'password' => Hash::make('password'),
                'role' => 'Manajer',
                'division_id' => Division::where('name', 'Keseluruhan')->first()->id,
            ],
            [
                'name' => 'Chef',
                'email' => 'chef@example.com',
                'password' => Hash::make('password'),
                'role' => 'Karyawan',
                'division_id' => Division::where('name', 'Koki')->first()->id,
            ],
            // Tambahkan user lainnya sesuai kebutuhan
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        InventoryItem::create([
            'division_id' => 1, // Divisi (misalnya: dapur, kasir, dll.)
            'name' => 'Beras',
            'category' => 'Bahan Makanan',
            'stock_quantity' => 20,
            'unit' => 'kg',
            'unit_price' => 12.50
        ]);

        InventoryItem::create([
            'division_id' => 1,
            'name' => 'Minyak Goreng',
            'category' => 'Bahan Makanan',
            'stock_quantity' => 5,
            'unit' => 'liter',
            'unit_price' => 15.00
        ]);

        InventoryItem::create([
            'division_id' => 2,
            'name' => 'Telur',
            'category' => 'Bahan Makanan',
            'stock_quantity' => 100,
            'unit' => 'pcs',
            'unit_price' => 0.50
        ]);

      // Membuat stok masuk
      $stockIn = StockIn::create([
        'notes' => 'Pengiriman awal bulan'
    ]);

    // Menambahkan barang ke dalam stok masuk
    $stockIn->inventoryItems()->attach([
        InventoryItem::where('name', 'Beras')->first()->id => ['quantity' => 50],
        InventoryItem::where('name', 'Minyak Goreng')->first()->id => ['quantity' => 20],
    ]);

    // Stok masuk lainnya
    $stockIn = StockIn::create([
        'notes' => 'Pengiriman pertengahan bulan'
    ]);

    $stockIn->inventoryItems()->attach([
        InventoryItem::where('name', 'Beras')->first()->id => ['quantity' => 10],
        InventoryItem::where('name', 'Telur')->first()->id => ['quantity' => 100],
    ]);


    $stockOut1 = StockOut::create([
        'notes' => 'Bahan digunakan untuk memasak menu utama'
    ]);

    // Hubungkan item ke stok keluar melalui tabel pivot, dengan kuantitas barang keluar
    $stockOut1->inventoryItems()->attach([
        InventoryItem::where('name', 'Beras')->first()->id => ['quantity' => 40],
        InventoryItem::where('name', 'Minyak Goreng')->first()->id => ['quantity' => 15],
    ]);

  

        
    }
}
