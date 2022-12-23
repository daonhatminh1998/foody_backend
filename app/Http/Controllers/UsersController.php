<?php

namespace App\Http\Controllers;

use App\Http\Responses\BaseResult;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    private $rules = array(
        'username' => 'required',
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
            // do login
            $credentials = [
                'username' => $req->username,
                'password' => $req->password
            ];
            if (Auth::attempt($credentials)) {
                $adminInfo = Auth::user();
                if ($adminInfo) {
                    if (empty($adminInfo->api_expired)) {
                        $token = hash('sha256',Str::random(60));
                        // update token
                        $adminInfo->api_token = $token;
                        $adminInfo->api_expired = now()->addDays(1);
                        $adminInfo->save();
                    } else if (Carbon::parse($adminInfo->api_expired)->lt(now())) {
                        $token = hash('sha256',Str::random(60));
                        // update token
                        $adminInfo->api_token = $token;
                        $adminInfo->api_expired = now()->addDays(1);
                        $adminInfo->save();
                    }

                    $data = [
                        'id' => $adminInfo->id,
                        'username' => $adminInfo->username,
                        'fullName' => $adminInfo->name,
                        'email'=> $adminInfo-> email,
                        'phone'=> $adminInfo-> phone,
                        'token' => $adminInfo->api_token,
                    ];
                    
                    return BaseResult::withData($data);
                } else {
                    return BaseResult::error(500, 'Server error, please try again');
                }                
            } else {
                return BaseResult::error(1, 'Wrong username or password.');
            }

        }
    }

    public function create(Request $req){
        //validate the info, create rules for the inputs
        $this->rules = array_merge($this->rules, [
            'fullname' => 'required|min:3',
            'phone' => 'required|min:10',
            'email' => 'min:3|email:rfc,dns',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bgImg' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'confirmpassword' => 'required|same:password|min:3']
        );

        $this->messages = array_merge($this->messages, [
            'fullname.required' => 'Name is required',
            'fullname.min' => 'Name length at least 3 characters',
            'phone.required' => 'Phone is required',
            'email.email' => 'Wrong email format!!!',
    
            'avatar.image' => 'Should be an image',
            'avatar.mimes'=> 'Image extension should be: jpeg,png,jpg,gif,svg',
            'avatar.max'=> 'Image max size is 2MB',
    
            'bgImg.image' => 'Should be an image',
            'bgImg.mimes'=> 'Image extension should be: jpeg,png,jpg,gif,svg',
            'bgImg.max'=> 'Image max size is 2MB',

            'confirmpassword.required' => 'Confirm password is required',
            'confirmpassword.same' => 'Confirm password and password does not match.',
            'confirmpassword.min' => 'Confirm password length at least 3 characters'
        ]
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make($req->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $checkusername = User::where('username',$req->input('username'))-> count();
            if($checkusername == 0){
                $checkemail = User::where('email',$req->input('email'))-> count();
                if($checkemail == 0){
                    $checkphone = User::where('phone',$req->input('phone'))-> count();
                    if($checkphone == 0){
                            try{
                                $adminInfo = new User();
                                $adminInfo->username = $req->input('username');
                                $adminInfo->password =  Hash::make( $req->input('password'));
                
                                $adminInfo->name = $req->input('fullname');
                                $adminInfo->email = $req->input('email');
                                $adminInfo->phone = $req->input('phone');
                                $adminInfo->save();
                            
                                if ($req->hasFile('img')) { // var name
                                    $filename = pathinfo($req->img->getClientOriginalName(), PATHINFO_FILENAME);
                                    $imageName = $adminInfo->id. '_' . $filename . '_' . time() . '.' . $req->img->extension();
                                    $req->img->move(public_path('data/admins/avatar'), $imageName);
                                    //update DB
                                    $adminInfo->avatar = $imageName; // col name
                                    $adminInfo->save();
                                }

                                if ($req->hasFile('bg')) { // var name
                                    $filename = pathinfo($req->bg->getClientOriginalName(), PATHINFO_FILENAME);
                                    $imageName = $adminInfo->id. '_' . $filename . '_' . time() . '.' . $req->bg->extension();
                                    $req->bg->move(public_path('data/admins/bg-images'), $imageName);
                                    //update DB
                                    $adminInfo->bgimg = $imageName; // col name
                                    $adminInfo->save();
                                }
                            }
                            catch (Throwable $e){
                                return BaseResult::error(500,$e->getMessage());
                            }
                            
                            $data = [
                                'id' => $adminInfo->id,
                                'username' => $adminInfo->username,
                                'fullName' => $adminInfo->name,
                                'avatar' => $adminInfo->avatar,
                                'bgImg' => $adminInfo->bgimg,
                                'email'=> $adminInfo-> email,
                                'phone'=> $adminInfo-> phone,
                                'token' => $adminInfo->api_token,
                            ];
    
                            return BaseResult::withData($data);                 
                    }   
                    else {
                        return BaseResult::error(419,"this phone exist");
                    }
                }
                else {  
                    return BaseResult::error(419,"this email exist");
                }
            }
            else {
                return BaseResult::error(419,"this user name exist");
            }
            
        }
    }

    public function changePassword(Request $req) {
        $rules = array(
            'password' => 'required|min:3',
            'newpassword' => 'required|min:3',
            'confirmpassword' => 'required|same:newpassword|min:3'
        );

        $messages = array(
            'password.required' => 'Password is required',
            'password.min' => 'Password length at least 3 characters',

            'newpassword.required' => 'New password is required',
            'newpassword.min' => 'New password length at least 3 characters',

            'confirmpassword.required' => 'Confirm password is required',
            'confirmpassword.same' => 'Confirm password and new password does not match.',
            'confirmpassword.min' => 'Confirm password length at least 3 characters'
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $adminInfo = Auth::user();

            if ($adminInfo) {
                if(Hash::check($req -> password, $adminInfo -> password)){
                    try {            
                        $adminInfo->password =  Hash::make( $req->input('newpassword'));
                        $adminInfo->save();
                       }
                       catch (Throwable $e){
                           return BaseResult::error(500,$e->getMessage());
                        }
                    return BaseResult::withData($adminInfo);
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

    public function changeInfor( Request $req) {
        $rules = array(
            'fullname' => 'min:3',
            'phone' => 'min:10',
            'email' => 'email:rfc,dns',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bgImg' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        );
        $messages = array(
            'fullname.required' => 'Name is required',
            'phone.required' => 'Phone is required',
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
        $adminInfo = Auth::user();
        // $adminInfo = User::find($uid);
            if ($adminInfo) {
                try {
                    if ($req->has('fullname')) $adminInfo->name = $req->name;
                    if ($req->has('phone')) $adminInfo->phone = $req->phone;
                    if ($req->has('email')) $adminInfo->email = $req->email;            
                    $adminInfo->save();

                    if ($req->hasFile('img')) { // var name
                        // img exist ? => delate old img
                        if(!empty($adminInfo->avatar)){
                            if(File::exists(public_path('data/admins/avatars/').$adminInfo->avatar)){
                                File::delete(public_path('data/admins/avatars/').$adminInfo->avatar);
                            }
                        }
                        $filename = pathinfo($req->img->getClientOriginalName(), PATHINFO_FILENAME);
                        $imageName = $adminInfo->id. '_' . $filename . '_' . time() . '.' . $request->img->extension();
                        $request->img->move(public_path('data/admins/avatars'), $imageName);
                        //update DB
                        $adminInfo->avatar = $imageName; 
                        $adminInfo->save();
                    }

                    if ($req->hasFile('bg')) { // var name
                        // img exist ? => delate old img
                        if(!empty($adminInfo->bgimg)){
                            if(File::exists(public_path('data/admins/bg-images/').$adminInfo->bgimg)){
                                File::delete(public_path('data/admins/bg-images/').$adminInfo->bgimg);
                            }
                        }
                        $filename = pathinfo($req->bg->getClientOriginalName(), PATHINFO_FILENAME);
                        $imageName = $adminInfo->id. '_' . $filename . '_' . time() . '.' . $req->bg->extension();
                        $request->bg->move(public_path('data/admins/bg-images'), $imageName);
                        //update DB
                        $adminInfo->bgimg = $imageName; 
                        $adminInfo->save();
                    }
                   }
                   catch (Throwable $e){
                       return BaseResult::error(500,$e->getMessage());
                    }

                return BaseResult::withData($adminInfo);
            } else {
                return BaseResult::error(500, 'Server error, please try again');
            }
        }
    }
}