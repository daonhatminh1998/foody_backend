<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Http\Responses\BaseResult;

use App\Models\ProductDetail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

use Throwable;

class ProductDetailController extends Controller
{
    private $rules = array(
        // 'Pro_Name' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    );

    private $messages = array(
        'Pro_Name.required' => 'Product\'s Name is required',
        // 'img.required' => 'Product image is required',
        'img.image' => 'Should be an image',
        'img.mimes'=> 'Image extension should be: jpeg,png,jpg,gif,svg',
        'img.max'=> 'Image max size is 2MB'
    );
    
    public function index($id = null){
        if ($id == null){
            $data = ProductDetail::with('type')->get();
             $data = $data->map(function($item){
                if (!empty($item->Pro_Avatar)) {
                    $item->Pro_Avatar = url('/public/data/products/'.$item->Pro_Avatar);
                }
                return $item;
            });
            return BaseResult::withData($data);
        }
        else{
            $data = ProductDetail::with('type')->find($id);

            if($data){ 
                if(!empty($data->Pro_Avatar)){
                    $data->Pro_Avatar = url("/public/data/products/".$data->Pro_Avatar);
                }
                return BaseResult::withData($data);
            }
            else{
                return BaseResult::error(404,'Data Not Found');
            }
        }
    }

    public function create(Request $request){
        //don't need
        // $this->rules = array_merge($this->rules, [
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048']
        // );
        // $this->messages = array_merge($this->messages, [
        //     'image.required' => 'Image is required.',
        //     'image.image' => 'Should be an image.',
        //     'image.mimes' => 'Image extension should be: jpeg,png,jpg,gif,svg.',
        //     'image.max' => 'Image max is 2M.'
        // ]);

        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {

        try{
            $data = new ProductDetail();
            $data->Pro_Id = $request->input('Pro_Id');
            $data->Pro_Name = $request->input('Pro_Name');
            $data->Pro_Price = $request->input('Pro_Price');
            $data->shortDes = $request->input('shortDes');
            $data->longDes = $request->input('longDes');
            $data->Pro_Unit = $request->input('Pro_Unit');
            $data->is_Published = $request->boolean('is_Published');
            $data->save();

            //  sample code
            // if ($req->hasFile('avatar')) {
            //     $filename = pathinfo($req->avatar->getClientOriginalName(), PATHINFO_FILENAME);
            //     $imageName = $data->ART_ID . '_' . $filename . '_' . time() . '.' . $request->Avatar->extension();
            //     $request->Avatar->move(public_path('data/avatars'), $imageName);
            //     $data->Avatar = $imageName;
            //     $data->save();
            // }
            
            if ($request->hasFile('img')) { // var name
                $filename = pathinfo($request->img->getClientOriginalName(), PATHINFO_FILENAME);
                $imageName = $data->ProDe_Id. '_' . $filename . '_' . time() . '.' . $request->img->extension();
                $request->img->move(public_path('data/products'), $imageName);
                //update DB
                $data->Pro_Avatar = $imageName; // col name
                $data->save();
            }
            
            return BaseResult::withData($data);
        }
        catch (Throwable $e){
           return BaseResult::error(500,$e->getMessage());
        }
    }}

    public function update($id,Request $request){
        $data=ProductDetail::find($id);
        
        if($data){
            $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            try {            
                $data->Pro_Name = $request->input('Pro_Name');
                $data->Pro_Price = $request->input('Pro_Price');
                $data->Pro_Unit = $request->input('Pro_Unit');
                $data->shortDes = $request->input('shortDes');
                $data->longDes = $request->input('longDes');
                $data->is_Published = $request->boolean('is_Published');
                $data->save();

                if ($request->hasFile('img')) { // var name
                    // img exist ? => delate old img
                    if(!empty($data->Pro_Avatar)){
                        if(File::exists(public_path('data/products/').$data->Pro_Avatar))
                        {
                            File::delete(public_path('data/products/').$data->Pro_Avatar);
                        }
                    }
                    $filename = pathinfo($request->img->getClientOriginalName(), PATHINFO_FILENAME);
                    $imageName = $data->ProDe_Id. '_' . $filename . '_' . time() . '.' . $request->img->extension();
                    $request->img->move(public_path('data/products'), $imageName);
                    //update DB
                    $data->Pro_Avatar = $imageName; // col name
                    $data->save();
                }
                return BaseResult::withData($data);
            }
            catch (Throwable $e){
                return BaseResult::error(500,$e->getMessage());
             }
 
        } }
        else{
            return BaseResult::error(404,'Data Not Found');
        }
        
    }

    public function delete($id){
        $data=ProductDetail::find($id);
        if($data){
            try {            
                // check image exist or not
                if(!empty($data->Pro_Avatar)){
                    File::delete(public_path('data/products/').$data->Pro_Avatar);  
                }
                $data->delete();
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

    public function getImageUrl($id){
        $row = ProductDetail::find($id);
        if($row){
            if(empty($row->Pro_Avatar)){
                return BaseResult::error(404,'No Image');
            }else{
                return BaseResult::withData(url('public/data/products/'.$row->Pro_Avatar));
            }
        }else return BaseResult::error(404,'Data not found');
    }

    public function getImage($id){
        $data=ProductDetail::find($id);
        if($data && !empty($data->Pro_Avatar)){         
                return Image::make(public_path('data/products/'.$data->Pro_Avatar))->response();
        }
        return response('',204); 
    }

    public function getImageBase64($id) {
        $row = ProductDetail::find($id);
        if ($row && !empty($row->Pro_Avatar)) {
            $filePath = public_path('data/products/' .$row->Pro_Avatar);
            $fileExt = pathinfo($filePath, PATHINFO_EXTENSION);
            $base64 = 'data:image/' . $fileExt . ';base64,' . base64_encode(file_get_contents($filePath));
            $response = [
                'fileName' => $row->Image,
                'data' => $base64
            ];
            return BaseResult::withData($response);
        }
        return BaseResult::error(404, 'Data not found');
    }

    public function getPaging(Request $req) {
        // for paging
        $pageNum = intval($req->query('p', '0'));
        $pageLength =  intval($req->query('r', '0'));

        // for sorting
        $sort = $req->query('s', '');
        $sortColumn = 'ProDe_Id';
        $sortDir = 'desc';
        if (!empty($sort)) {
            $sortColumns = explode(',', $sort);
            $sortColumn = $sortColumns[0];
            if (count($sortColumns)>1) {
                $sortDir = $sortColumns[1];
            }
         }
        
        $admin = $req->query('a', false);
        if($admin){
            $pagingQuery = ProductDetail::with('type')->orderBy($sortColumn, $sortDir);
        }

        else{
            $pagingQuery = ProductDetail::with('type')->where('is_Published',true)->orderBy($sortColumn, $sortDir);
        }
        
        //sort by type
        $type = $req->query('type', '');
        if($type > 0 ) {
            $pagingQuery->where('Pro_Id','=',
            $type
        );
        }

        //sort price
        $priceFrom = $req->query('from', '0');
        $priceTo = $req->query('to',"0");

        if($priceFrom > 0 ) {
             $pagingQuery->where('Pro_Price','>=',$priceFrom);
        }
        if($priceTo > 0 ) {
             $pagingQuery->where('Pro_Price','<=',$priceTo);
        }

         // for search
        $q = $req->query('q', '');
        if (!empty($q)) {
            $pagingQuery = $pagingQuery->where(function ($query) use ($q) {
                $query->where('Pro_Name', 'LIKE', "%$q%")
                    ->orWhere('Pro_Price', 'LIKE', "%$q%")
                    // ->orWhere('shortDes', 'LIKE', "%$q%")
                    // ->orWhere('longDes', 'LIKE', "%$q%")
                    // ->orWhere(DB::raw("CONCAT(lastName,' ',firstName)"), 'LIKE', "%$q%")
                   ;
            });
        } 
         $data = $pagingQuery->get();
         $data = $data->map(function($item){
            if (!empty($item->Pro_Avatar)) {
                $item->Pro_Avatar = url('/public/data/products/'.$item->Pro_Avatar);
            }
            return $item;
        });

        // $data = ProductDetail::orderBy('PRO_Name', 'asc')->get();

        if ($pageLength > 0) {
            $pagingData = $data->forPage($pageNum + 1, $pageLength)->values();
        } else {
            $pagingData = $data;
        }
        if ($pageLength > 0) {
            $pagingInfo = [
                'page' => $pageNum,
                'pageLength' => $pageLength,
                'totalRecords' => $data->count(),
                'totalPages' => ceil($data->count()/$pageLength),
            ];
            return BaseResult::withPaging($pagingInfo, $pagingData);
        } else {
            return BaseResult::withData($pagingData);
        }        
    }
}
