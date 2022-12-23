<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductDetail;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'Pro_Id';

    // mặc dinh là có khỏi ghi, nếu không
    public $timestamps = false;

    public function product_detail(){
        return $this->hasMany(ProductDetail::class,'ProDe_Id');
    }
}
