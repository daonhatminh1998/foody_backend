<?php

namespace App\Http\Controllers;

use App\Http\Responses\BaseResult;
use App\Models\Customers;
use Illuminate\Http\Request;
use Throwable;

class CustomersController extends Controller
{  
    public function index($id = null) {
        $adminInfo = auth('api')->user();
        if ($adminInfo) {
            if ($id == null) {
                $data = Customers::with('address')->get();
                return BaseResult::withData($data);
            } else {
                $data = Customers::with('address','orders')->orderBy('Cus_Name','asc')->find($id);
                
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
    
    public function create(Request $request) {
        try {
            $data = new Customers();
            $data->Cus_FirstName = $request->input('Cus_Name');
            $data->Cus_Email = $request->input('Cus_Email');     
            $data->Cus_Phone = $request->input('Cus_Phone');
            $data->save();

            return BaseResult::withData($data);
        } catch (Throwable $e) {
            return BaseResult::error(500,$e->getMessage());
        }
    }       
    
    public function update($id, Request $request) {
        $adminInfo = auth('api')->user();
        if ($adminInfo) {
            $data=Customers::find($id);
            if($data){
                try {            
                $data->Cus_Name = $request->input('Cus_Name');
                $data->Cus_Email = $request->input('Cus_Email');
                $data->Cus_Phone = $request->input('Cus_Phone');
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
            $data=Customers::find($id);
            if($data) {
                try {            
                    $data->delete();
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
}
