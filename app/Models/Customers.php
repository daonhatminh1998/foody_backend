<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders;
use App\Models\Address;

class Customers extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $primaryKey = 'Cus_Id';

    public $timestamps = false;

    public function orders(){
        return $this->hasMany(Orders::class,'Cus_Id');
    }

    public function address(){
        return $this->hasMany(Address::class,'Cus_Id');
    }
}
