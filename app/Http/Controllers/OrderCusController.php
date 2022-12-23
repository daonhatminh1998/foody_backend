<?php

namespace App\Http\Controllers;

use App\Http\Responses\BaseResult;

use App\Models\Address;
use App\Models\Customers;

use App\Models\OrderCus;
use App\Models\OrderCusDetail;

use App\Models\Carts;
use App\Models\CartDetail;
use App\Models\Receiver;

use App\Models\ProductDetail;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Throwable;

class OrderCusController extends Controller
{
    public function index($id = null) {
        $adminInfo = auth('api')->user();
        if ($adminInfo) {
            if ($id == null) {
                $data = OrderCus::orderBy('ORD_Id','asc')->get();
                return BaseResult::withData($data);
            } else {
                $data = OrderCus::with('details.product_detail')->find($id);
                if($data) { 
                    return BaseResult::withData($data);
                } else {
                    return BaseResult::error(404,'Data Not Found');
                }
            }
        } else {
            return BaseResult::error(500, 'Server error, please try again');
        } 
    }

    public function getPaging(Request $req) {
        $adminInfo = auth('api')->user();
        if ($adminInfo) {
             // for paging
             $pageNum = intval($req->query('p', '0'));
             $pageLength =  intval($req->query('r', '0'));
     
             // for sorting
             $sort = $req->query('sort', '');
             $sortColumn = 'ORD_DateTime';
             $sortDir = 'desc';
             if (!empty($sort)) {
                 $sortColumns = explode(',', $sort);
                 $sortColumn = $sortColumns[0];
                 if (count($sortColumns)>1) {
                     $sortDir = $sortColumns[1];
                 }
              }
             
             $pagingQuery = OrderCus::orderBy($sortColumn, $sortDir);
             
            //   for search
             $search = $req->query('search', '');
             if (!empty($search)) {
                 $pagingQuery = $pagingQuery->where(function ($query) use ($search) {
                     $query->where('ORD_Code', 'LIKE', "%$search%")
                         ->orWhere('ORD_Name', 'LIKE', "%$search%")
                         ->orWhere('ORD_Phone', 'LIKE', "%$search%");
                 });
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
    
    public function create(Request $req) {
        $rules = array(
            // 'customer' => 'required',
            'customer.Cus_Phone' => 'required',
            'details' => 'required|array|min:1'
        );
        $messages = array(
            'customer.required' => 'Customer is required',
            'customer.Cus_Phone' => 'Customer Cus_Phone is required',
            'details.required' => 'Detail is required',
            'details.array' => 'Details must be an array',
            'details.min' => 'At least 1 item',
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make($req->all(), $rules, $messages);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
           
            $customerPhone = $req->input('customer.Cus_Phone');
            $customer = Customers::where('Cus_Phone', $customerPhone)->first();
            $CUS_ID = 0;

            if ($customer) {
                $CUS_ID = $customer->Cus_Id;
            } else {
                $customer = new Customers();
                $customer->Cus_Phone = $customerPhone;
                $customer->Cus_Email = $req->input('customer.Cus_Email');
                $customer->save();

                $CUS_ID = $customer->Cus_Id;
            }

            $code = OrderCus::where ('ORD_Code', 'like', date('ymd')."%")->count();
            
            $orders = new OrderCus();
            $orders->Cus_Id = $CUS_ID;
            $orders->ORD_DateTime = now();
            $orders->ORD_CusNote = $req->input('ORD_CusNote');
            $orders->ORD_AdNote = $req->input('ORD_AdNote');

            $orders->ORD_Name = $req->input('ORD_Name');
            $customer->Cus_Name =  $orders->ORD_Name;
            $orders->ORD_Phone = $customerPhone;
            $orders->ORD_Email = $req->input('customer.Cus_Email');

            $customer->save();

            $orders->ORD_Address = $req->input('ORD_Address');
            $customerAddress = Address::where('Address', $orders->ORD_Address)->where('Cus_Id',$CUS_ID)->first();
            if(!$customerAddress) {
                $address = new Address();
                $address->Address = $orders->ORD_Address;
                $address->Cus_Id = $CUS_ID;
                $address->save();  
            }
            
            if ($code) {
                if($code < 9){
                    $orders->ORD_Code = date('ymd000').($code + 1);
                }  
                else{
                    $orders->ORD_Code = date('ymd00').($code + 1);
                }
            }
            else{
                $orders->ORD_Code = date('ymd00').'01';
            }
            $orders->save();
            
            $details = $req->input('details');
            $detailData = Arr::map($details, function ($item) use($orders) {
                $price = ProductDetail::where('ProDe_Id', $item['id'])->first();

                $orderCusDetail = new OrderCusDetail();
                $orderCusDetail-> ORD_Id = $orders->ORD_Id;
                $orderCusDetail-> ProDe_Id = $item['id'];
                $orderCusDetail-> ORDe_Quantity = $item['ORDe_Quantity'];
                if ($price) $orderCusDetail-> ORDe_Price = $price->Pro_Price *$item['ORDe_Quantity'];
                
                // return $orderCusDetail;
                $orderCusDetail->save();        
            });
        return BaseResult::withData($details);
        }
    }

    public function update($id,Request $request){
        $adminInfo = auth('api')->user();
        if ($adminInfo) {
            $data=OrderCus::find($id);
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
     
            } else {
                return BaseResult::error(404,'Data Not Found');
            }
        } else {
            return BaseResult::error(500, 'Server error, please try again');
        }
    }

    public function delete($id){
        $adminInfo = auth('api')->user();
        if ($adminInfo) {
            $order = OrderCus::find($id);
            if($order){
                try {
                    $OrderCusDetail = OrderCusDetail::where ('ORD_Id', $id)->delete();
                    $Cus_Id= OrderCus::where('ORD_Id', $id)->value('Cus_Id');
                    $count = OrderCus::where('Cus_Id',$Cus_Id)->count();
                    $order->delete();
                    if($count === 1){
                        $address = Address::where('Cus_Id',$Cus_Id)->delete();
                        $customer=Customers::where('Cus_Id',$Cus_Id)->delete();
                    }           
                    
                    return BaseResult::withData($order);
                } catch (Throwable $e) {
                    return BaseResult::error(500,$e->getMessage());
                }
            } else {
                return BaseResult::error(404,'Data Not Found');
            }
        } else {
            return BaseResult::error(500, 'Server error, please try again');
        }
    }
}
