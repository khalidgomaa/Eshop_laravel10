<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Brand;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index(Request $request){
        $brands = Brand :: latest();
        if(!empty($request->get('keyword'))){
            $brands=$brands->where('name','like','%'.$request->get('keyword').'%');
        }
        $brands = $brands->paginate(10);
        return view('admin.brand.brands-list',compact('brands'));
    }
    public function create(Request $request){
        return view('admin.brand.create');
    }
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'slug' => 'required|unique:brands',
        ]);
        if ($validator->passes()) {
            $brand= new Brand();
            $brand->name= $request->name;
            $brand->slug= $request->slug;
            $brand->status= $request->status;
            $brand->save();
            $request->session()->flash('success','Brand added successfully');
            return response()->json([
                'status' => true,
                'message' =>'Sub brand added successfully',
                ]);
        }
        else{ 
           
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
               
                ]);
        }
        // return view('admin.brand.brands-list');
    }



    public function edit($brand_id,Request $request){ 
        
        $brand=Brand::find($brand_id);

        if(!empty($brand)){
            return view('admin.brand.edit',compact('brand')); 
        }else{
        return redirect()->route('brands.index'); 
         }
    }


    public function update($brand_id,Request $request){
  
        $brand=brand::find($brand_id);
      
        if(empty($brand)){
            return response()->json([
                'status'=>false,
                'notfound'=>true,
                'message'=>'Brand not found',
            ]);   
        } else{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'slug' => 'required|unique:brands,slug,' .$brand->id.',id'
            ]);
            if ($validator->passes()) {
            
                $brand-> name= $request->name;
             
                $brand-> slug= $request->slug;
                $brand-> status= $request->status;
                $brand->save(); 
      
           $request->session()->flash('success','brand updated successfully');
           return response()->json([
            'status' => true,
            'message' =>'brand added successfully',
        ]);
            }else{
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ]);
            }
          }
        }
     

        public function destroy($brand_id){
            $brand = brand::find($brand_id);
               
                if (!empty($brand)) {
                    $brand->delete();
        
                    session()->flash('success', 'brand deleted successfully');
                    
                    return response()->json([
                        'status' => true,
                        'message' => 'brand deleted successfully',
                    ]);
        
    
            } else {
                session()->flash('errors', 'brand not found');
                return response()->json([
                    'status' => false,
                    'notFound'=>true,
                    'message' => 'brand not found',
                ]);
            }
        }
        
}
