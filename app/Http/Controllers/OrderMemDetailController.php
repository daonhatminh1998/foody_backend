<?php

namespace App\Http\Controllers;

use App\Http\Responses\BaseResult;

use App\Models\OrderMem;
use App\Models\OrderMemDetail;
use App\Models\ProductDetail;

use Illuminate\Http\Request;
use Throwable;

class OrderMemDetailController extends Controller
{   
    public function index($id = null){
        $memberInfo = auth('member')->user();
        if ($memberInfo) {
            if ($id == null){
                $order = OrderMem::where("Mem_Id",$memberInfo->Mem_Id)->orderBy('ORD_Id','asc')->get(); 
                // $data = $order->ORD_Id;
                // $data = OrderMemDetail::where("ORD_Id",$order->ORD_Id)->get();
            return BaseResult::withData($order);
            } else {
                $data =OrderMemDetail::with('productDetail')->find($id);
                if ($data) { 
                    return BaseResult::withData($data);
                }
                else {
                    return BaseResult::error(404,'Data Not Found');
                }
            }
        } else {
            return BaseResult::error(500, 'Server error, please try again');
        }
    }
   
}
