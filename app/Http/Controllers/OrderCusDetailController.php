<?php

namespace App\Http\Controllers;

use App\Http\Responses\BaseResult;
use App\Models\OrderCusDetail;
use Illuminate\Http\Request;
use Throwable;

class OrderCusDetailController extends Controller
{
    public function index($id = null){
        if ($id == null){
            $data = OrderCusDetail::all();
            return BaseResult::withData($data);
        }
        else{
            $data =OrderCusDetail::find($id);
            
            if($data){ 
                return BaseResult::withData($data);
            }
            else{
                return BaseResult::error(404,'Data Not Found');
            }
        }
    }
   
}
