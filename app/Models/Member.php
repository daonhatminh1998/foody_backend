<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Receiver;
use App\Models\Carts;
use App\Models\Orders;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'members';
    protected $primaryKey = 'Mem_Id';
    protected $guard = 'member';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'api_expired',
        // 'api_token',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function receiver(){
        return $this->hasMany(Receiver::class,'Mem_Id');
    }
    public function cart(){
        return $this->hasOne(Carts::class,'Cart_Id');
    }

    public function order(){
        return $this->hasMany(Orders::class,'Mem_Id');
    }
}
