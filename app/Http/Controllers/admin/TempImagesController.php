<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;
// use Intervention\Image\Facades\Image;  I have a problem with this library i can't make thumpnial

class TempImagesController extends Controller
{
   public function create(Request $request){
        $image = $request->image;
        if(!empty($image)){
            $ext = $image->getClientOriginalExtension();
            $newName = time() . '.' . $ext;

            // Save the original image
            $image->move(public_path('temp_images'), $newName);

            // // Generate and save the thumbnail
            // $thumbnailPath = public_path('temp_images/thumbnails');
            // if (!file_exists($thumbnailPath)) {
            //     mkdir($thumbnailPath, 0777, true);
            // }
            // $thumbnailName = 'thumb_' . $newName;
            // $thumbnail = Image::make(public_path('temp_images') . '/' . $newName)
            //     ->resize(150, 150, function ($constraint) {
            //         $constraint->aspectRatio();
            //     });
            // $thumbnail->save($thumbnailPath . '/' . $thumbnailName);

            // Save the image information to the database
            $tempImage = new TempImage();
            $tempImage->name = $newName;
            $tempImage->save();

            return response()->json([
                'status' => true,
                'image_id'=> $tempImage->id ,
                'message' => 'Image uploaded successfully', 
                'filename' => $newName,
                'image-path' => asset('/temp_images/'.$newName),
              
            ]);
        }
         
        return response()->json([
            'status' => false, 
            'message' => 'No image file found in the request']);
   }
}
