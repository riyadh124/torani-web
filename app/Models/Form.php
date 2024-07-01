<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'nomor_tiket',
        'tipe_unit',
        'model_unit',
        'nomor_unit',
        'shift',
        'jam_mulai',
        'jam_selesai',
        'hm_awal',
        'hm_akhir',
        'job_site',
        'lokasi',
        'status',
        'catatan'
    ];

    public static $rules = [
        'nomor_tiket' => 'unique:forms,nomor_tiket',
        // aturan validasi lainnya
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function checks()
    {
        return $this->hasMany(FormCheck::class);
    }
}
