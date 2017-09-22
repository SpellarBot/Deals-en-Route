<?php

namespace App\Http\Transformer;

use URL;

class CouponTransformer {

   

    public function transformList($coupon) {
    
        $var = [];
        $var = $coupon->map(function ($item) {
          
            return [
                'category_id'=>$item->coupon_id??'',
                'coupon_category_name'=>$item->categoryDetail->category_name ??'',
                'coupon_name'=>$item->coupon_name??'',
                'vendor_name'=>$item->vendorDetail->vendor_name??'',
                'coupon_detail'=>$item->coupon_detail??'',
                'coupon_logo'=>$item->coupon_logo ??"",
                'coupon_start_date'=>$item->coupon_start_date??'',
                'coupon_end_date'=>$item->coupon_end_date??'',
                
            ];
        });
        return $var;
    }
    


}
