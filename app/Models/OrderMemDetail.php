<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductDetail;
use App\Models\OrderMem;

class OrderMemDetail extends Model
{
    use HasFactory;

    protected $table = 'order_mem_detail';
    protected $primaryKey = 'ORDe_Id';

    public $timestamps = false;

    public function product_detail(){
        return $this->belongsTo(ProductDetail::class,'ProDe_Id');
    }
    
}
