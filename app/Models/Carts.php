<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Members;
use App\Models\CartDetail;

class Carts extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $primaryKey = 'Cart_Id';

    // mặc dinh là có khỏi ghi, nếu không
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(Members::class,'Mem_Id');
    }

    public function cart_detail(){
        return $this->hasMany(CartDetail::class,'Cart_Id');
    }
}
