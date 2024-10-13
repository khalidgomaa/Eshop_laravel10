<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
class SubCategoryController extends Controller
{

    public function index(Request $request){
      // $sub_categories = Sub_Category::with('category');
      $sub_categories = \DB::table('sub_categories') 
      ->select('sub_categories.*','categories.name as categoryName')
      ->latest('sub_categories.id')
      ->leftJoin('categories','categories.id','sub_categories.category_id'); 


      if(!empty($request->get('keyword'))){
          $sub_categories = $sub_categories->where('sub_categories.name', 'like', '%'.$request->get('keyword').'%');
          $sub_categories = $sub_categories->where('categories.name', 'like', '%'.$request->get('keyword').'%');
      }
      $sub_categories = $sub_categories->paginate(10);
      return view('admin.sub_category.sub_categories-list', compact('sub_categories'));
  }



  public function create(){
    $categories = Category::all();
    return view('admin.sub_category.create',compact('categories'));
  }


  public function store(Request $request){
  
    $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'category_id' => 'required|integer',
        'slug' => 'required|unique:sub_categories',
    ]);

    if ($validator->passes()) {
        $sub_category=new SubCategory();
        $sub_category->category_id = $request->category_id;
        $sub_category-> name= $request->name;
        $sub_category-> slug= $request->slug;
        $sub_category-> status= $request->status;

       $trueSaved= $sub_category-> save();

        session()->flash('success','Sub Category added successfully');
        return response()->json([
        'status' => true,
        'message' =>'Sub Category added successfully',
        ]);
    }else{
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
           
            ]);
    }
    // return view('admin.sub_category.sub_categories-list');
  }

  public function edit($sub_category_id,Request $request){
  
      $categories = Category::all();
    $sub_category=SubCategory::find($sub_category_id);

    if(!empty($sub_category)){
        return view('admin.Sub_category.edit',compact('sub_category'),compact('categories')); 
    }else{
    return redirect()->route('sub_categories.index'); 
     }
}

public function update($sub_category_id,Request $request){
  
  $sub_category=SubCategory::find($sub_category_id);

  if(empty($sub_category)){
      return response()->json([
          'status'=>false,
          'notfound'=>true,
          'message'=>'category not found',
      ]);   
  } else{
      $validator = Validator::make($request->all(), [
          'name' => 'required|string',
          'slug' => 'required|unique:categories,slug,' .$sub_category->id.',id'
      ]);
      if ($validator->passes()) {
          $sub_category-> category_id= $request->category_id;
          $sub_category-> name= $request->name;
       
          $sub_category-> slug= $request->slug;
          $sub_category-> status= $request->status;
          $sub_category->save(); 

 session()->flash('success','Sub_Category updated successfully');
     return response()->json([
      'status' => true,
      'message' =>'Sub_Category added successfully',
  ]);
      }else{
          return response()->json([
              'status' => false,
              'errors' => $validator->errors(),
          ]);
      }
    }
  }



  public function destroy($sub_category_id){
  $sub_category = SubCategory::find($sub_category_id);
  
  if ($sub_category) {
   
   
      $sub_category->delete();

      session()->flash('success', 'sub_category deleted successfully');
      
      return response()->json([
          'status' => true,
          'message' => 'sub_category deleted successfully',
      ]);
  } else {
      session()->flash('errors', 'sub_category not found');
      return response()->json([
          'status' => false,
          'notFound'=>true,
          'message' => 'Sub Category not found',
      ]);
  }
}
}
