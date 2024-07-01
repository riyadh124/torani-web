<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('nomor_tiket')->unique()->default('T000');  // Atur default value jika diperlukan
            $table->string('tipe_unit');
            $table->string('model_unit');
            $table->string('nomor_unit');
            $table->string('shift');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('hm_awal');
            $table->integer('hm_akhir');
            $table->string('job_site');
            $table->string('lokasi');
            $table->string('catatan');
            $table->string('status')->default('Waiting'); // Status default Menunggu
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forms');
    }
}

