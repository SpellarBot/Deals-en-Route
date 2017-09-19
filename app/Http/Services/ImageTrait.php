<?php

namespace App\Http\Services;


trait ImageTrait {
    
    public  function addImage($data,$model,$attribute){
   if ($data->hasFile($attribute)) {
            $fileName   = time() . '.' . $data->file($attribute)->getClientOriginalExtension();
            $imagePath = $data->file($attribute)->storeAs('public/'.$attribute,$fileName);
            $imageresizePath = $data->file($attribute)->storeAs('public/'.$attribute.'/tmp',$fileName);
            
            $img = \Image::make(storage_path().'/app/'.$imagePath);
            // save thumbnail image
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path().'/app/'.$imageresizePath);
            $model->$attribute = $fileName;
            $model->save();
        }
 
    }
}






