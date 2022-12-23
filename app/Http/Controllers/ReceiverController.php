<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Responses\BaseResult;
use Illuminate\Support\Str;

use App\Models\Receiver;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;

class ReceiverController extends Controller
{   
    public function index($id = null){
        $memberInfo = auth('member')->user();
        if ($memberInfo) {
            if ($id == null){
                $data = Receiver::where("Mem_Id",$memberInfo->Mem_Id)->get();
                return BaseResult::withData($data);
            }
            else{
                $data = Receiver::find($id);
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

    public function create(Request $req) {
        $rules = array(
            'name' => 'required|min:1',
            'phone' => 'required|min:10',
            'address' => 'required|min:5',
            'is_Default' => 'boolean',
        );
        $messages = array(
            'name.min' => 'Name can not null',
            'phone.min' => 'Phone can not null',
            'address.min' => 'Address can not null',

            'name.required' => 'Name is required',
            'phone.required' => 'Phone is required',
            'address.required' => 'Address is required',
            'is_Default.boolean' => 'Wrong format',
        );
        
        $validator = Validator::make($req->all(), $rules, $messages);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {   
            $memberInfo = auth('member')->user();
            if ($memberInfo) {
                $checkValid = Receiver::where('Mem_Id', $memberInfo->Mem_Id)->where('name',$req->input('name'))-> where('phone',$req->input('phone'))->where('address',$req->input('address')) -> count();
                    if($checkValid == 0){ 
                        try{
                            Receiver::query()->where('Mem_Id', $memberInfo->Mem_Id)->update(['is_Chosen' => 0]);

                            $newReceiver = new Receiver();
                            $newReceiver->name = $req->name;
                            $newReceiver->phone = $req->phone;
                            $newReceiver->address = $req->address;
                            $newReceiver->Mem_Id = $memberInfo->Mem_Id;
                            $newReceiver->is_Chosen = 1;

                            if ($req->has('is_Default')) {
                                Receiver::query()->where('Mem_Id', $memberInfo->Mem_Id)->update(['is_Default' => 0]);
                                $newReceiver->is_Default = $req->is_Default;
                            } else {
                                $count = Receiver::where('Mem_Id', $memberInfo->Mem_Id)->count();
                                if ($count == 0) {
                                    $newReceiver->is_Default = 1; 
                                }
                            }  

                            $newReceiver->save();
                            return BaseResult::withData($newReceiver);
                    }
                        catch (Throwable $e){
                            return BaseResult::error(500,$e->getMessage());
                        }
                    } else {
                        return BaseResult::error(404, 'Receiver already have!!!');
                    }
            } else {
                return BaseResult::error(500, 'Server error, please try again');
            }  
        }
    }

    public function update($Re_Id, Request $req) {
        $rules = array(
            'name' => 'min:1',
            'phone' => 'min:10',
            'address' => 'min:5',
        );
        $messages = array(
            'name.min' => 'Name can not null',
            'phone.min' => 'Phone can not null',
            'address.min' => 'Address can not null',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {   
            $memberInfo = auth('member')->user();
            if ($memberInfo) {
                $receiver = Receiver::where('Mem_Id', $memberInfo->Mem_Id)->where("Re_Id",$Re_Id)->first();
                    if($receiver){ 
                        try{
                            $checkDefault = Receiver::where('Mem_Id', $memberInfo->Mem_Id)->where('name',$req->name)-> where('phone',$req->phone)->where('address',$req->address)->where('is_Default',$req->is_Default)->first();
                            if (!$checkDefault) {
                                $checkInfo = Receiver::where('Mem_Id', $memberInfo->Mem_Id)->where('name',$req->name)-> where('phone',$req->phone)->where('address',$req->address)->where('Re_Id', $Re_Id)->first();
                                    if ($checkInfo) {
                                        $updateReceiver = Receiver::find($Re_Id);     
                                                              
                                        Receiver::query()->where('Mem_Id', $memberInfo->Mem_Id)->update(['is_Default' => 0]);
                                        $updateReceiver->is_Default = $req->is_Default;
                                        if($req->is_Default) {
                                            $updateReceiver->is_Chosen = 1;
                                        }
                                        $updateReceiver->save();
                                    
                                        return BaseResult::withData($updateReceiver);
                                    } else {
                                        $checkValid = Receiver::where('Mem_Id', $memberInfo->Mem_Id)->where('name',$req->name)-> where('phone',$req->phone)->where('address',$req->address)->first();    
                                        if (!$checkValid) { 
                                            $updateReceiver = Receiver::find($Re_Id);

                                            if($req->has('name')) $updateReceiver->name = $req->name;
                                            if($req->has('phone')) $updateReceiver->phone = $req->phone;
                                            if($req->has('address')) $updateReceiver->address = $req->address;

                                            $updateReceiver->save();
                                    
                                            return BaseResult::withData($updateReceiver);

                                        } else {
                                            return BaseResult::error(404, 'Receiver already have!!! (Different default)'); 
                                        }                                         
                                    } 
                            } else {
                                return BaseResult::error(404, 'Receiver already have!!!');   
                            }
       
                        }
                        catch (Throwable $e){
                            return BaseResult::error(500,$e->getMessage());
                        }
                    } else {
                        return BaseResult::error(404, 'Receiver not found!!!');
                    }
            } else {
                return BaseResult::error(500, 'Server error, please try again');
            }  
        }
    }

    public function default(Request $req) {
        $rules = array(   
            'Re_Id' => 'required',
        );
        $messages = array(
            'Re_Id.required' => 'Id can not null'
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {   
            $memberInfo = auth('member')->user();
            if ($memberInfo) {
                $receiver = Receiver::where('Mem_Id', $memberInfo->Mem_Id)->find($req->Re_Id);
                    if($receiver){ 
                        $checkDefault = Receiver::where('Mem_Id', $memberInfo->Mem_Id)->where('Re_Id', $req->Re_Id)->where('is_Default', 0)->first();

                        if($checkDefault){
                            try{
                                Receiver::query()->where('Mem_Id', $memberInfo->Mem_Id)->update(['is_Default' => 0]);
                                Receiver::query()->where('Mem_Id', $memberInfo->Mem_Id)->update(['is_Chosen' => 0]);

                                $checkDefault->is_Default = 1;
                                $checkDefault->is_Chosen = 1;

                                $checkDefault->save();
                                
                                return BaseResult::withData($checkDefault);                  
                            }
                            catch (Throwable $e){
                                return BaseResult::error(500,$e->getMessage());
                            }
                        } else {                  
                            Receiver::query()->where('Mem_Id', $memberInfo->Mem_Id)->update(['is_Default' => 0]);
                            Receiver::query()->where('Mem_Id', $memberInfo->Mem_Id)->update(['is_Chosen' => 0]);
    
                            $checkDefault = Receiver::where('Mem_Id', $memberInfo->Mem_Id)->where('Re_Id', $req->Re_Id)->first();
                            return BaseResult::withData($checkDefault); 
                                    
                        }
                    } else {
                        return BaseResult::error(404, 'Receiver not found');
                    }
            } else {
                return BaseResult::error(500, 'Server error, please try again');
            }  
        }
    }

    public function chosen(Request $req) {
        $rules = array(   
            'Re_Id' => 'required',
        );
        $messages = array(
            'Re_Id.required' => 'Id can not null'
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {   
            $memberInfo = auth('member')->user();
            if ($memberInfo) {
                $receiver = Receiver::where('Mem_Id', $memberInfo->Mem_Id)->find($req->Re_Id);
                    if($receiver){ 
                        $checkChosen = Receiver::where('Mem_Id', $memberInfo->Mem_Id)->where('Re_Id', $req->Re_Id)->where('is_Chosen', 0)->first();
                        if($checkChosen){
                            try{
                                Receiver::query()->where('Mem_Id', $memberInfo->Mem_Id)->update(['is_Chosen' => 0]);
                                $checkChosen->is_Chosen = 1;
                                $checkChosen->save();
    
                                return BaseResult::withData($checkChosen);                     
                            }
                            catch (Throwable $e){
                                return BaseResult::error(500,$e->getMessage());
                            }
                        } else {                  
                            return BaseResult::withData($receiver);         
                        }
                    } else {
                        return BaseResult::error(404, 'Receiver not found');
                    }
            } else {
                return BaseResult::error(500, 'Server error, please try again');
            }  
        }
    }

    public function reset() {
        $memberInfo = auth('member')->user();
            if ($memberInfo) {
                $receiver = Receiver::where('Mem_Id', $memberInfo->Mem_Id)->first();
                    if($receiver){ 
                        try{
                            Receiver::query()->where('Mem_Id', $memberInfo->Mem_Id)->update(['is_Chosen' => 0]);
                            $reset = Receiver::where('Mem_Id', $memberInfo->Mem_Id)->where('is_Default', 1)->first();
                            if ($reset) {
                                $reset->is_Chosen = 1;
                                $reset->save();
                            }
                            
                            return BaseResult::withData($reset);                     
                        }
                        catch (Throwable $e){
                            return BaseResult::error(500,$e->getMessage());
                        }          
                    } else {
                        return BaseResult::error(404, "You don't have any receiver!!!");
                    }  
            } else {
                return BaseResult::error(500, 'Server error, please try again');
            }        
        
    }

    public function delete($Re_Id) {
        $memberInfo = auth('member')->user();
            if ($memberInfo) {
                $receiver = Receiver::where('Mem_Id', $memberInfo->Mem_Id)->where("Re_Id",$Re_Id)->first();
                    if($receiver){ 
                        try{
                            $receiver->delete();
                            $message = "Delete Sucessful.";
                            return BaseResult::withData($message);
                        }
                        catch (Throwable $e){
                            return BaseResult::error(500,$e->getMessage());
                        }  
                    } else {
                        return BaseResult::error(404, 'Receiver not found!!!');
                    }
            } else {
                return BaseResult::error(500, 'Server error, please try again');
            }  
        }


      
    }


            
