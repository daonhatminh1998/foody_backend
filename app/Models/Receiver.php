<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Members;

class Receiver extends Model
{
    use HasFactory;

    protected $table = 'receiver';
    protected $primaryKey = 'Re_Id';

    // mặc dinh là có khỏi ghi, nếu không
    public $timestamps = false;

    public function member(){
        return $this->belongsTo(Members::class,'Mem_Id');
    }
}
