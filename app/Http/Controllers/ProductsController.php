<?php

namespace App\Http\Controllers;

use App\Http\Responses\BaseResult;
use App\Models\Products;
use Illuminate\Http\Request;
use Throwable;

class ProductsController extends Controller
{
    public function index($id=null){
        $adminInfo = auth('api')->user();
        if ($adminInfo) {
            if ($id == null){
                $data = Products::all();
                return BaseResult::withData($data);
            } else {
                $data = Products::with('product_detail')->find($id);
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

    public function create(Request $request){
        $adminInfo = auth('api')->user();
        if ($adminInfo) {
            try{
                $data = new Products();
                $data->Pro_Id = $request->input('Pro_Id');
                $data->Pro_Type = $request->input('Pro_Type');
                $data->save();
                return BaseResult::withData($data);
    
            }
            catch (Throwable $e){
               return BaseResult::error(500,$e->getMessage());
            }
        } else {
            return BaseResult::error(500, 'Server error, please try again');
        } 
    }

    public function update($id,Request $req) {
        $adminInfo = auth('api')->user();
        if ($adminInfo) {
            $data=Products::find($id);
            if($data) {
                try {            
                    $data->Pro_Type = $req->input('Pro_Type');
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

    public function delete($id) {
        $adminInfo = auth('api')->user();
        if ($adminInfo) {
            $data=Products::find($id);
            if($data){
                try {            
                    $data->delete();
                    return BaseResult::withData($data);
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
