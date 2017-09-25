<?php

namespace App\Http\Services;

use URL;

trait ImageTrait {

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

}
