<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Customers;

use App\Models\ProductDetail;
use App\Models\OrderCusDetail;

class OrderCus extends Model
{
    use HasFactory;

    protected $table = 'order_cus';
    protected $primaryKey = 'ORD_Id';

    public $timestamps = false;

    public function details(){
        return $this->hasMany(OrderCusDetail::class,'ORD_Id');
    }

    public function customer(){
        return $this->belongsTo(Customers::class,'Cus_Id');
    }
}
