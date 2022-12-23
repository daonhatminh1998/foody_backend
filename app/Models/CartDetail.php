<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductDetail;
use App\Models\Carts;

class CartDetail extends Model
{
    use HasFactory;

    protected $table = 'cart_detail';
    protected $primaryKey = 'CartDe_Id';

    public $timestamps = false;

    public function product_detail(){
        return $this->belongsTo(ProductDetail::class,'ProDe_Id');
    }
}
