<?php
namespace App\Traits;

use Intervention\Image\Facades\Image;

Trait  ImageTrait
{
    public function saveImage($request,$folderName){
        Image::make($request->image)->resize(null, 200, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('uploads/' .$folderName.'/'. $request->image->hashName()));
    }



}


