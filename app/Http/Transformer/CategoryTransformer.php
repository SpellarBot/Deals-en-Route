<?php

namespace App\Http\Transformer;

use URL;
use Carbon\Carbon;

class CategoryTransformer {

    public function transformList($category) {

        $var = [];
        $var = $category->map(function ($item) {
            return [
                'category_id' => $item->category_id ?? '',
                'category_name' => $item->category_name ?? '',
                'category_image' => $item->category_image ?? ''
            ];
        });
        return $var;
    }

}
