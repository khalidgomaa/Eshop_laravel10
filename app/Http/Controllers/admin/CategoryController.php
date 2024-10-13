<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
// use Image;

class CategoryController extends Controller
{
    public function index(Request $request){
        $categories = Category :: latest();
        if(!empty($request->get('keyword'))){
            $categories=$categories->where('name','like','%'.$request->get('keyword').'%');
        }
        $categories = $categories->paginate(10);
        return view('admin.category.categories-list',compact('categories'));
    }

    public function create(){
return view('admin.category.create');
    }

    
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'slug' => 'required|unique:categories',
        ]);
    
        if ($validator->passes()) {
       $category= new Category();
       $category-> name= $request->name;
       $category-> slug= $request->slug;
       $category-> status= $request->status;
       $category->save(); 

   if (!empty($request->image_id)) {
    $tempImage = TempImage::find($request->image_id);
    
    if ($tempImage) {
        $exArray = explode('.', $tempImage->name);
        $ext = last($exArray);
        
        $newImageName = $category->id . '.' . $ext;
        $spath = public_path('temp_images/' . $tempImage->name);
        $dpath = public_path('uploads/category/' . $newImageName);

        if (File::exists($spath)) {
            File::copy($spath, $dpath);
        
             $category->image = $newImageName;
                $category->save();

            // create instance
                // $img = Image::make('$spath');
                // $dpath = public_path('uploads/category/thumbnails' . $newImageName);

                // // resize image to fixed size
                // $img->resize(450, 600);
                // $img->save( $dpath );
                // $category->image = $newImageName;
                // $category->save();
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Source image not found.',
            ]);
        }
    } else {
        return response()->json([
            'status' => false,
            'message' => 'Temporary image not found.',
        ]);
    }
}
      session()->flash('success','Category added successfully');
       return response()->json([
        'status' => true,
        'message' =>'Category added successfully',
    ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

  //~ ******************** updating  *************
    public function edit($category_id,Request $request){
        
        $category=Category::find($category_id);

        if(!empty($category)){
            return view('admin.category.edit',compact('category')); 
        }else{
        return redirect()->route('categories.index'); 
         }
    }

    public function update($category_id,Request $request){
  
        $category=Category::find($category_id);

        if(empty( $category)){
            return response()->jason([
                'status'=>false,
                'notfound'=>true,
                'message'=>'category not found',
            ]);
         
        }
        else{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'slug' => 'required|unique:categories,slug,' .$category->id.',id'
            ]);
            if ($validator->passes()) {
           
                $category-> name= $request->name;
                $category-> slug= $request->slug;
                $category-> status= $request->status;
                $category->save(); 
         
           $oldImage=$category->image;
        }
 
    if (!empty($request->image_id)) {
        $tempImage = TempImage::find($request->image_id);
        
        if ($tempImage) {
            $exArray = explode('.', $tempImage->name);
            $ext = last($exArray);
            
            $newImageName = $category->id . '_'.time() . '.' . $ext;
            $spath = public_path('temp_images/' . $tempImage->name);
            $dpath = public_path('uploads/category/' . $newImageName);
    
            if (File::exists($spath)) {
                File::copy($spath, $dpath);
            
                 $category->image = $newImageName;
                    $category->save();
               File::delete(public_path('uploads/category/' . $oldImage));
          
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Source image not found.',
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Temporary image not found.',
            ]);
      
    }
           $request->session()->flash('success','Category updated successfully');
           return response()->json([
            'status' => true,
            'message' =>'Category added successfully',
        ]);
            }else{
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ]);
            }
        }
    }
    

  //~ ******************** Deleting  *************

    public function destroy($category_id){
        $category = Category::find($category_id);
        
        
        if (empty($category)) {
            session()->flash('error', value: 'Category not found');
            return response()->json([
                'status' => false,
                'notFound'=>true,
                'message' => 'Category not found',
            ]);
        }
   
                File::delete(public_path('uploads/category/' . $category->Image));
                $category->delete();
    
            session()->flash('success', 'Category deleted successfully');
            
            return response()->json([
                'status' => true,
                'message' => 'Category deleted successfully',
            ]);
      

      
     
    }
    
}
