<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Products;
use App\Models\OrderCusDetail;
use App\Models\OrderMemDetail;

class ProductDetail extends Model
{
    use HasFactory;

    protected $table = 'product_detail';
    protected $primaryKey = 'ProDe_Id';

    public $timestamps = false;

    public function type(){
        return $this->belongsTo(Products::class,'Pro_Id');
    }

    public function orderCus(){
        return $this->hasMany(OrderMemDetail::class,'ProDe_Id');
    }

    public function orderMem(){
        return $this->hasMany(OrderCusDetail::class,'ProDe_Id');
    }
    
   
}
