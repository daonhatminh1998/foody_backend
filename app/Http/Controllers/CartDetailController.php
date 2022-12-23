<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\BaseResult;

use App\Models\Carts;
use App\Models\CartDetail;

use Throwable;

class CartDetailController extends Controller
{
    public function index($id=null){
        if ($id == null){
            $data = CartDetail::get();
            return BaseResult::withData($data);
        }
        else{
            $data = CartDetail::find($id);
            
            if($data){ 
                return BaseResult::withData($data);
            }
            else{
                return BaseResult::error(404,'Data Not Found');
            }
        }
    }

    public function create(Request $req){
        try{
            $data = new CartDetail();
            $data->CartDe_Quantity = $req->input('CartDe_Quantity');
            $data->CartDe_Price = $req->input('CartDe_Price');
            $data->ProDe_Id = $req->input('ProDe_Id');
            $data->Cart_Id = $req->input('Cart_Id');
            $data->save();
            return BaseResult::withData($data);

        }
        catch (Throwable $e){
           return BaseResult::error(500,$e->getMessage());
        }
    }

    public function update($id,Request $req){
        $data=CartDetail::find($id);
        if($data){
            try {            
                $data->CartDe_Quantity = $req->input('CartDe_Quantity');
                $data->CartDe_Price = $req->input('CartDe_Price');
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
}
