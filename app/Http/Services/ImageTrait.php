<?php

namespace App\Http\Services;


trait ImageTrait {
    
    public function addImage($data,$model){
   if ($data->hasFile('profile_image')) {
            $imagePath = $data->file('profile_image')->store('public/profile_image');
            $imageresizePath = $data->file('profile_image')->store('public/profile_image/tmp');
            $img = \Image::make(storage_path().'/app/'.$imagePath);
            
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path().'/app/'.$imageresizePath);
            $model->profile_image = $imagePath;
            $thumbnailimage= explode("/",$model->profile_image);
        }
 
    }
}






