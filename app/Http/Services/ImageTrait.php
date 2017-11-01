<?php

namespace App\Http\Services;

use URL;

trait ImageTrait {
 //api image
    public function addImage($data, $model, $attribute) {


        if ($data->hasFile($attribute)) {
            $fileName = time() . '.' . $data->file($attribute)->getClientOriginalExtension();

            $imagePath = $data->file($attribute)->storeAs('public/' . $attribute, $fileName);
            $imageresizePath = $data->file($attribute)->storeAs('public/' . $attribute . '/tmp', $fileName);

            $img = \Image::make(storage_path() . '/app/' . $imagePath);
            // save thumbnail image
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path() . '/app/' . $imageresizePath);
            $model->$attribute = $fileName;
            $model->save();
        }
    }

    public function updateImage($data, $model, $attribute) {

        self::removeImage($data, $model, $attribute);
        self::addImage($data, $model, $attribute);
    }

    public function removeImage($data, $model, $attribute) {
        if(!empty($model->profile_pic)){
        $imagePath = public_path() . '/../'.\Config::get('constants.IMAGE_PATH').'/'.$attribute . '/' . $model->profile_pic;
        $imageResizePath = public_path() . '/../'.\Config::get('constants.IMAGE_PATH').'/'.$attribute . '/tmp/' . $model->profile_pic;

        //remove file path
        if (file_exists($imagePath) && file_exists($imageResizePath)) {
            unlink($imagePath);
            unlink($imageResizePath);
        }
    }
    }

    //web image
    public function showImage($fieldName, $attribute) {
    
     $imageResizePath = public_path() . '/../'.\Config::get('constants.IMAGE_PATH').'/'.$attribute . '/tmp/' . $fieldName;

     //remove file path
     if (file_exists($imageResizePath)) {
        return URL::to('/storage/app/public').'/'.$attribute. '/tmp/' . $fieldName;
     }
     return URL::to('/storage/app/public/images/no-img.png');

 }
 
    public function addImageWeb($imagedata, $model, $attribute) {

            $fileName = time() . '.' . $imagedata->getClientOriginalExtension();

            $imagePath = $imagedata->storeAs('public/' . $attribute, $fileName);
            $imageresizePath = $imagedata->storeAs('public/' . $attribute . '/tmp', $fileName);

            $img = \Image::make(storage_path() . '/app/' . $imagePath);
            // save thumbnail image
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path() . '/app/' . $imageresizePath);
            $model->$attribute = $fileName;
            $model->save();
        
    }
    
    public function updateImageWeb($filename, $model, $attribute) {

        self::removeImageWeb($filename, $attribute);
        self::addImageWeb($filename, $model, $attribute);
    }

    public function removeImageWeb($fileName, $attribute) {
        if(!empty($fileName)){
        $imagePath = public_path() . '/../'.\Config::get('constants.IMAGE_PATH').'/'.$attribute . '/' . $fileName;
        $imageResizePath = public_path() . '/../'.\Config::get('constants.IMAGE_PATH').'/'.$attribute . '/tmp/' . $fileName;

        //remove file path
        if (file_exists($imagePath) && file_exists($imageResizePath)) {
            unlink($imagePath);
            unlink($imageResizePath);
        }
    }
    }
    
    // show logo image
    public function showLogoImage(){
       $company_logo=\Config::get('app.url') . \Config::get('constants.IMAGE_PATH') . '/images/logo.png'; 
       return $company_logo;
    }
}
