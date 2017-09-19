<?php

namespace App\Http\Transformer;

use URL;
use Carbon\Carbon;

class CategoryTransformer {

   

    public function transformList($category) {
 new Collection($category, function(array $categorys) {      
  return [
           'category_id'=>$categorys->category_id,
           'category_name'=>$category->category_name,
           'category_image'=>$category->category_image,

        ];
}
    }

}
