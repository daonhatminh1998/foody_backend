<?php

namespace App\Http\Controllers;

use App\Http\Responses\BaseResult;

use App\Models\OrderMem;
use App\Models\OrderMemDetail;

use App\Models\Carts;
use App\Models\CartDetail;
use App\Models\Receiver;

use App\Models\ProductDetail;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Throwable;

class OrderMemController extends Controller
{
    public function index($id = null){
        $memberInfo = auth('member')->user();
        if ($memberInfo) {
            if ($id == null){
                $data = OrderMem::where("Mem_Id",$memberInfo->Mem_Id)->orderBy('ORD_Id','asc')->get();
                return BaseResult::withData($data);
            }
            else{
                $data = OrderMem::where("Mem_Id",$memberInfo->Mem_Id)->with('details.product_detail')->find($id);
                
                if($data){ 
                    return BaseResult::withData($data);
                }
                else{
                    return BaseResult::error(404,'Data Not Found');
                }
            }
        } else {
            return BaseResult::error(500, 'Server error, please try again');
        }
    }

    public function order (Request $req) {
        $rules = array(   
            'Re_Id' => 'required',
            'details' => 'required|array|min:1'
        );
        $messages = array(
            'Re_Id.required' => 'Id can not null',
        );
        $validator = Validator::make($req->all(), $rules, $messages);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $memberInfo = auth('member')->user();
            if ($memberInfo) {
                $receiver = Receiver::where('Mem_Id', $memberInfo->Mem_Id)->where('Re_Id', $req->Re_Id)->first();
                if ($receiver) {
                    $details = $req->input('details');
                    if($details){
                        $orders = new OrderMem();
                        $orders->Mem_Id = $memberInfo->Mem_Id;
                        $orders->ORD_DateTime = now();
                        $orders->ORD_CusNote = $req->input('ORD_CusNote');

                        $orders->ORD_Name = $receiver->name;
                        $orders->ORD_Phone = $receiver->phone;
                        $orders->ORD_Address = $receiver->address;
                    
                        $code = OrderMem::where ('ORD_Code', 'like', date('ymd')."%")->count();
                        if ($code) {
                            if($code < 9){
                                $orders->ORD_Code = date('ymd000').($code + 1);
                            }  
                            else{
                                $orders->ORD_Code = date('ymd00').($code + 1);
                            }
                        } else {
                            $orders->ORD_Code = date('ymd00').'01';
                        }
                        $orders->save();
                    
                        $cart =  Carts::where("Mem_Id",$memberInfo->Mem_Id)->first();
                        $detailData = Arr::map($details, function ($item) use($orders, $cart) {
                            $price = ProductDetail::where('ProDe_Id', $item['id'])->first();
                            
                            $OrderMemDetail = new OrderMemDetail();
                            $OrderMemDetail-> ORD_Id = $orders->ORD_Id;
                            $OrderMemDetail-> ProDe_Id = $item['id'];
                            $OrderMemDetail-> ORDe_Quantity = $item['quantity'];
                            if ($price) $OrderMemDetail-> ORDe_Price = $price->Pro_Price * $item['quantity'];
                        
                            $OrderMemDetail->save();
                            CartDetail::where('Cart_Id', $cart->Cart_Id)->where('ProDe_Id', $item['id'])->delete();
                        });

                        return BaseResult::withData($orders);
                    } else {
                        return BaseResult::error(404,"Your order item is empty. Please check again!");   
                    }
                } else {
                    return BaseResult::error(404,'Receiver Not Found!!!');
                }
            }
            else {
                return BaseResult::error(500, 'Server error, please try again');
            }
         }
    }

    public function update($id,Request $request){
        $data=OrderMem::find($id);
        if($data){
            try {            
                $data->Pro_Name = $request->input('Pro_Name');
                $data->Pro_Price = $request->input('Pro_Price');
                $data->Pro_Avatar = $request->input('Pro_Avatar');
                $data->Pro_Description = $request->input('Pro_Description');
                $data->Pro_Unit = $request->input('Pro_Unit');
                $data->Pro_Id = $request->input('Pro_Id');
                $data->save();
                return BaseResult::withData($data);
            }
            catch (Throwable $e){
                return BaseResult::error(500,$e->getMessage());
             }
 
        } 
        else{
            return BaseResult::error(404,'Data Not Found');
        }
        
    }

    public function delete($id){
        $order = OrderMem::find($id);

        if($order){
            try {
                $OrderMemDetail = OrderMemDetail::where ('ORD_Id', $id)->delete();
                $Cus_Id= OrderMem::where('ORD_Id', $id)->value('Cus_Id');
                $count = OrderMem::where('Cus_Id',$Cus_Id)->count();
                $order->delete();
                if($count === 1){
                    $address = Address::where('Cus_Id',$Cus_Id)->delete();
                    $customer=Customers::where('Cus_Id',$Cus_Id)->delete();
                }           
                
                return BaseResult::withData($order);
            }
            catch (Throwable $e){
                return BaseResult::error(500,$e->getMessage());
             }
        } 

        else{
            return BaseResult::error(404,'Data Not Found');
        }
        
    }

    public function getPaging(Request $req) {
        $memberInfo = auth('member')->user();
        if ($memberInfo) {
             // for paging
             $pageNum = intval($req->query('p', '0'));
             $pageLength =  intval($req->query('r', '0'));
     
             // for sorting
             $sort = $req->query('s', '');
             $sortColumn = 'ORD_DateTime';
             $sortDir = 'desc';
             if (!empty($sort)) {
                 $sortColumns = explode(',', $sort);
                 $sortColumn = $sortColumns[0];
                 if (count($sortColumns)>1) {
                     $sortDir = $sortColumns[1];
                 }
              }
             
             $pagingQuery = OrderMem::orderBy($sortColumn, $sortDir);
             
            //   for search
             $q = $req->query('q', '');
             if (!empty($q)) {
                //  $pagingQuery = $pagingQuery->where(function ($query) use ($q) {
                //      $query->where('Pro_Name', 'LIKE', "%$q%")
                //          ->orWhere('Pro_Price', 'LIKE', "%$q%");
                //  });
             } 

              $data = $pagingQuery->get();
             //  $data = $data->map(function($item){
             //     if (!empty($item->Pro_Avatar)) {
             //         $item->Pro_Avatar = url('/public/data/products/'.$item->Pro_Avatar);
             //     }
             //     return $item;
             // });
     
             if ($pageLength > 0) {
                 $pagingData = $data->forPage($pageNum + 1, $pageLength)->values();
             } else {
                 $pagingData = $data;
             }
             if ($pageLength > 0) {
                 $pagingInfo = [
                     'orderPage' => $pageNum,
                     'orderPageLength' => $pageLength,
                     'totalRecords' => $data->count(),
                     'totalPages' => ceil($data->count()/$pageLength),
                 ];
                 return BaseResult::withPaging($pagingInfo, $pagingData);
             } else {
                 return BaseResult::withData($pagingData);
             }   
        } else {
            return BaseResult::error(500, 'Server error, please try again');
        }   
    }
}
