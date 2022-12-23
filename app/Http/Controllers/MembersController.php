<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\CartDetail;

use App\Models\Member;
use App\Models\Receiver;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Responses\BaseResult;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class MembersController extends Controller
{
    private $rules = array(
        'username' => 'required|min:3',
        'password' => 'required|min:3',
    );
    private $messages = array(
        'username.required' => 'Username is required',
        'password.required' => 'Password is required',
        'password.min' => 'Password length at least 3 characters',
    );

    public function login(Request $req) {
        $validator = Validator::make($req->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            // $memberInfo = Member::with('cart.cart_detail.product_detail','receiver','order.details.productDetail')->where('username',$req->username)->first();
            $memberInfo = Member::where('username',$req->username)->first();
            if($memberInfo){
                if (Hash::check($req->password, $memberInfo->password)) {
                    if (empty($memberInfo->api_expired)) {
                        $token = hash('sha256',Str::random(60));
                        // update token
                        $memberInfo->api_token = $token;
                        $memberInfo->api_expired = now()->addDays(1);
                        $memberInfo->save();
                    } else if (Carbon::parse($memberInfo->api_expired)->lt(now())) {
                        $token = hash('sha256',Str::random(60));
                        // update token
                        $memberInfo->api_token = $token;
                        $memberInfo->api_expired = now()->addDays(1);
                        $memberInfo->save();
                    }

                    if(!empty($memberInfo->avatar)){
                        $memberInfo->avatar = url("/public/data/members/avatars/".$memberInfo->avatar);
                    }
                    if(!empty($memberInfo->bgimg)){
                        $memberInfo->bgimg = url("/public/data/members/bg-images/".$memberInfo->bgimg);
                    }

                    $data = $req->input("cartItem");
                    if ($data) {
                        $cart = Carts::where("Mem_Id",$memberInfo->Mem_Id)->first();
                        $detailsData = Arr::map($data, function($item) use($cart) {
                        $cartDetail = CartDetail::where("Cart_Id",$cart->Cart_Id)->where("ProDe_Id",$item["id"])->first();
                            if ($cartDetail) {
                                $cartDetail->CartDe_Quantity = $item["quantity"];
                                $cartDetail->save();
                            } else {
                                $newItem = new CartDetail();
                                $newItem->Cart_Id = $cart->Cart_Id;
                                $newItem->ProDe_Id = $item["id"];
                                $newItem->CartDe_Quantity = $item["quantity"];
                                $newItem->save();
                            }
                        });
                    }
                    return BaseResult::withData($memberInfo);             
                } else {
                    return BaseResult::error(1, 'Wrong password.');
                }
            }
            else{
                return BaseResult::error(1, 'Username not exist.');
            }
            
        }
    }

    public function create(Request $req) {      
        $rules =  [
            'username' => 'required|min:3',
            'name' => 'required|min:3',
            'email' => 'min:3|email:rfc,dns',
            'password' => 'required|min:3',
            'confirmPassword' => 'required|same:password|min:3'];

        $messages =  [
            'username.required' => 'Username is required',
            'name.required' => 'Name is required',
            'email.email' => 'Wrong email format!!! ',

            'password.required' => 'password is required',
            'password.min' => ' password length at least 3 characters',

            'confirmPassword.required' => 'Confirm password is required',
            'confirmPassword.same' => 'Confirm password and password does not match.',
            'confirmPassword.min' => 'Confirm password length at least 3 characters'];

        $validator = Validator::make($req->all(), $rules, $messages);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $checkusername = Member::where('username',$req->input('username'))-> count();
            if($checkusername == 0){
                $checkemail = Member::where('email',$req->input('email'))-> count();
                if($checkemail == 0) {
                    try{
                        $memberInfo = new Member();
                        $memberInfo->username = $req->input('username');
                        $memberInfo->name = $req->input('name');
                        $memberInfo->email = $req->input('email');
                        $memberInfo->password =  Hash::make( $req->input('password'));
                        
                        $memberInfo->api_token = hash('sha256',Str::random(60));
                        $memberInfo->api_expired = now()->addDays(1);
                        $memberInfo->save();
                       
                        $cartInfo = new Carts();
                        $cartInfo->Mem_Id = $memberInfo->Mem_Id;
                        $cartInfo->save();
                         
                        return BaseResult::withData($memberInfo);
                    } catch (Throwable $e) {
                        return BaseResult::error(500,$e->getMessage());
                        }
                } else {  
                    return BaseResult::error(419,"this email exist");
                }
            } else {
                return BaseResult::error(419,"this user name exist");
            }
        }
    }

    public function changePassword( Request $req) {
        $rules = array(
            'password' => 'required|min:3',
            'newPassword' => 'required|min:3',
            'confirmPassword' => 'required|min:3'
            // same:newPassword
            
        );

        $messages = array(
            'password.required' => 'Password is required',
            'password.min' => 'Password length at least 3 characters',

            'newPassword.required' => 'New password is required',
            'newPassword.min' => 'New password length at least 3 characters',

            'confirmPassword.required' => 'Confirm password is required',
            'confirmPassword.min' => 'Confirm password length at least 3 characters',
            // 'confirmPassword.same' => 'Confirm password and new password does not match.'
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $memberInfo = auth('member')->user();
            if ($memberInfo) {
                if(Hash::check($req->password, $memberInfo->password)){
                    if(Hash::check($req->newPassword, Hash::make($req->confirmPassword))){
                        try {       
                            $memberInfo->password =  Hash::make( $req->input('newPassword'));
                            $memberInfo->save();
                           }
                           catch (Throwable $e){
                               return BaseResult::error(500,$e->getMessage());
                            }    
                    } else {
                        return BaseResult::error(1, 'Confirm password and new password do not match.');
                    }
                   
                    return BaseResult::withData($memberInfo);
                }
                else {
                    return BaseResult::error(1, 'Wrong current password.');
                }
            }
            else {
                return BaseResult::error(500, 'Server error, please try again');
            }                
        } 
    }
    
    public function changeInfor(Request $req) {
        $rules = array(
            'name' => 'min:3',
            'email' => 'email:rfc,dns',
            // 'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'bgImg' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        );
        $messages = array(
            'name.required' => 'Name is required',
            'email.email' => 'Wrong email format!!!',
    
            'avatar.image' => 'Should be an image',
            'avatar.mimes'=> 'Image extension should be: jpeg,png,jpg,gif,svg',
            'avatar.max'=> 'Image max size is 2MB',
    
            'bgImg.image' => 'Should be an image',
            'bgImg.mimes'=> 'Image extension should be: jpeg,png,jpg,gif,svg',
            'bgImg.max'=> 'Image max size is 2MB',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {    
            $memberInfo = auth('member')->user();
            if ($memberInfo) {
                try {           
                    if ($req->has('name')) $memberInfo->name = $req->name;
                    if ($req->has('email')) $memberInfo->email = $req->email;
                    $memberInfo->save();

                    if ($req->hasFile('img')) { // var name
                        // img exist ? => delate old img
                        if(!empty($memberInfo->avatar)){
                            if(File::exists(public_path('data/members/avatars/').$memberInfo->avatar)){
                                File::delete(public_path('data/members/avatars/').$memberInfo->avatar);
                            }
                        }
                        $filename = pathinfo($req->img->getClientOriginalName(), PATHINFO_FILENAME);
                        $imageName = $memberInfo->Mem_Id. '_' . $filename . '_' . time() . '.' . $request->img->extension();
                        $request->img->move(public_path('data/members/avatars'), $imageName);
                        //update DB
                        $memberInfo->avatar = $imageName; 
                        $memberInfo->save();
                    }

                    if ($req->hasFile('bg')) { // var name
                        // img exist ? => delate old img
                        if(!empty($memberInfo->bgimg)){
                            if(File::exists(public_path('data/members/bg-images/').$memberInfo->bgimg)){
                                File::delete(public_path('data/members/bg-images/').$memberInfo->bgimg);
                            }
                        }
                        $filename = pathinfo($req->bg->getClientOriginalName(), PATHINFO_FILENAME);
                        $imageName = $memberInfo->Mem_Id. '_' . $filename . '_' . time() . '.' . $req->bg->extension();
                        $request->bg->move(public_path('data/members/bg-images'), $imageName);
                        //update DB
                        $memberInfo->bgimg = $imageName; 
                        $memberInfo->save();
                    }
                   }
                   catch (Throwable $e){
                       return BaseResult::error(500,$e->getMessage());
                    }

                return BaseResult::withData($memberInfo);
            } else {
                return BaseResult::error(500, 'Server error, please try again');
            }
        }
    }
}