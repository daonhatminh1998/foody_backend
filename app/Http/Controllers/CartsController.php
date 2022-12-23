<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\CartDetail;
use App\Models\ProductDetail;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Responses\BaseResult;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CartsController extends Controller
{
    public function index($id = null){
        $memberInfo = auth('member')->user();
        if ($memberInfo) {
            if ($id == null){
                $data = Carts::with('cart_detail')->where("Mem_Id",$memberInfo->Mem_Id)->first();
                return BaseResult::withData($data);
            }
            else{
                $data = CartDetail::where("Mem_Id",$memberInfo->Mem_Id)->with('product_detail')->find($id);
                
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
    
    public function updateCart (Request $req) {
        $memberInfo = auth('member')->user();
        if ($memberInfo) { 
            $data = $req->cartItem;

            $cart = Carts::where("Mem_Id",$memberInfo->Mem_Id)->first();
            
            //delete
            CartDetail::where("Cart_Id",$cart->Cart_Id)->whereNotIn("ProDe_Id",$req->input('cartItem.*.id'))->delete();        
            
            Arr::map($data, function($item) use($cart) {
            $cartDetail = CartDetail::where("Cart_Id",$cart->Cart_Id)->where("ProDe_Id",$item["id"])->first();
                if ($cartDetail) {
                    $cartDetail->CartDe_Quantity = $item["quantity"];
                    $cartDetail->save();
                }
               else{
                    $addItem = new CartDetail();
                    $addItem->CartDe_Quantity = $item["quantity"];                    
                    $addItem->ProDe_Id = $item["id"];
                    $addItem->Cart_Id = $cart->Cart_Id;

                    $addItem->save();
               }
            });    

            $cart = Carts::with("cart_detail")->where("Mem_Id",$memberInfo->Mem_Id)->first();

            return BaseResult::withData($cart);
        } else {
            return BaseResult::error(500, 'Server error, please try again');
        }
    }

    public function deleteAll() {
        $memberInfo = auth('member')->user();
        if ($memberInfo) {
            try{
                $cart = Carts::with('cart_detail')->where('Mem_Id', $memberInfo->Mem_Id)->first();
                $deleteItem = CartDetail::where("Cart_Id", $cart->Cart_Id)->delete();
                
                $update = Carts::with('cart_detail')->where('Mem_Id', $memberInfo->Mem_Id)->first();                                            

                $updateCart = Carts::with('cart_detail')->where('Mem_Id', $memberInfo->Mem_Id)->first();
                return BaseResult::withData($updateCart);
            }

            catch (Throwable $e){
                return BaseResult::error(500,$e->getMessage());
            }

        } else {
            return BaseResult::error(500, 'Server error, please try again');
        }                  
    }  

}
