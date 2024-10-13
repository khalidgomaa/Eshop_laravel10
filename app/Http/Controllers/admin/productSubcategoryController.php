<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;

class productSubcategoryController extends Controller
{
    public function index(Request $request){
     
    $sub_categories=SubCategory::where('category_id',$request->category_id)
    ->orderBy('name','ASC')
    ->get();
 
    if(!empty( $sub_categories)){
        return response()->json([
            'status' => true,
            'sub_categories' => $sub_categories,
         
        ]);
      
        }
        else{
            return response()->json([
         'status' => false,
         ' sub_categories' => [],
     ]);
     }
}
}
