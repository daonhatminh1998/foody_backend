<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Customers;
use App\Models\Member;

use App\Models\ProductDetail;
use App\Models\OrderMemDetail;

class OrderMem extends Model
{
    use HasFactory;

    protected $table = 'order_mem';
    protected $primaryKey = 'ORD_Id';

    public $timestamps = false;

    public function details(){
        return $this->hasMany(OrderMemDetail::class,'ORD_Id');
    }

    public function member(){
        return $this->belongsTo(Member::class,'Mem_Id');
    }

}
