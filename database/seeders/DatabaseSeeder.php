<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Form;
use App\Models\FormCheck;
use App\Models\Material;
use App\Models\Workorder;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
         'name' => 'Admin Account',
         'email' => 'admin@gmail.com',
         'role' => 'Supervisor',
        ]);

        Form::create([
         'user_id' => 240701001, // Replace with the actual user ID
         'tipe_unit' => 'Excavator',
         'model_unit' => 'ABC123',
         'nomor_unit' => 'UNIT001',
         'shift' => 'Pagi',
         'jam_mulai' => '08:00:00',
         'jam_selesai' => '16:00:00',
         'hm_awal' => 1000,
         'hm_akhir' => 1200,
         'job_site' => 'Construction Site A',
         'lokasi' => 'City X, Country Y',
         'status' => 'Waiting',
         'catatan' => 'Test Catatan Hehehe'
     ]);

     $checks = [
        'Kebocoran oli gear box / oil PTO (AA)',
        'Level oil swing & kebocoran (AA)',
        'Level oil hydraulic & kebocoran (AA)',
        'Kondisi underacarriage (A)',
        'Fuel drain / Buangan air dari tanki BBC (A)',
        'BBC minimum 25% dari Cap. Tanki (A)',
        'Buang air dalam tanki udara (A)',
        'Kebersihan accessories safety & Alat (A)',
        'Kebocoran2 bila ada (oli, solar, grease ) (A)',
        'Alarm travel (Big Digger) (A)',
        'Lock pin Bucket (AA)',
        'Lock pin tooth & ketajaman kuku (AA)',
        'Kebersihan aki / battery (A)',
        'Air conditioner (AC) (A)',
        'Fungsi steering / kemudi (AA)',
        'Fungsi seat belt / sabuk pengaman (AA)',
        'Fungsi semua lampu (AA)',
        'Fungsi Rotary lamp (AA)',
        'Fungsi mirror / spion (A)',
        'Fungsi wiper dan air wiper (A)',
        'Fungsi horn / klakson (AA)',
        'Fire Extinguiser / Fire supresion APAR (AA)',
        'Fungsi kontrol panel (AA)',
        'Fungsi radio komunikasi (AA)',
        'Kebersihan ruang kabin (A)',
        'Radiator (AA)',
        'Engine / Oli Mesin (AA)'
    ];

    foreach ($checks as $check) {
        FormCheck::create([
            'form_id' =>1,
            'item_name' => $check,
            'status' => 'OK',
            'documentation' => 'No issues found'
        ]);
    }


        // Workorder::create([
        //     'nomor_tiket' => 'TCKT-12345',
        //     'tipe_segmen' => 'Seeder',
        //     'lokasi_gangguan_masal' => 'Alamat Gangguan',
        //     'deskripsi_gangguan' => 'Deskripsi Gangguan',
        //     'instruksi_pekerjaan' => 'Instruksi Pekerjaan',
        //     'status' => 'Menunggu',
        // ]);
    }
}
