<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Address;

class Address extends Model
{
    use HasFactory;

    protected $table = 'address';
    protected $primaryKey = 'Add_Id';

    public $timestamps = false;

}
