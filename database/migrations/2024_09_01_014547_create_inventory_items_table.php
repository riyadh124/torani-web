<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('division_id')->nullable();
            $table->string('name'); // Nama barang
            $table->string('category')->nullable(); // Kategori (misalnya: bahan makanan, alat masak)
            $table->integer('stock_quantity')->default(0); // Jumlah stok
            $table->string('unit')->nullable(); // Satuan (misalnya: kg, liter, pcs)
            $table->decimal('unit_price', 8, 2)->nullable(); // Harga per satuan
            $table->string('thumbnail')->nullable(); // Path or URL for the thumbnail image
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
