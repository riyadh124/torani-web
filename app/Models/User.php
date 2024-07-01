<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = ['id'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function forms()
    {
        return $this->hasMany(Form::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Get the current date in YYMMDD format
            $date = Carbon::now()->format('ymd');

            // Get the latest user ID that starts with today's date
            $latestUser = DB::table('users')
                ->where('id', 'like', $date . '%')
                ->orderBy('id', 'desc')
                ->first();

            // Extract the numeric part and increment it
            $nextNumber = $latestUser ? (int)substr($latestUser->id, 6) + 1 : 1;

            // Format the ID as YYMMDD + 3 digit number
            $user->id = $date . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        });
    }
}