<?php

namespace App\Http\Transformer;

use URL;

class CouponTransformer {

   

    public function transformList($coupon) {
    
        $var = [];
        $var = $coupon->map(function ($item) {
    
            return [
                'coupon_id'=>$item->coupon_id??'',
                'coupon_category_name'=>$item->categoryDetail->category_name ??'',
                'coupon_name'=>$item->coupon_name??'',
                'vendor_name'=>$item->vendorDetail->vendor_name??'',
                'coupon_detail'=>$item->coupon_detail??'',
                'vendor_logo'=>$item->vendorDetail->vendor_logo??'',
                'coupon_start_date'=>$item->coupon_start_date??'',
                'coupon_end_date'=>$item->coupon_end_date??'',
                'is_favorite'=>$item->is_favorite??0,
                
            ];
        });

        return ['has_page'=>$coupon->hasMorePages(),'current_page'=>$coupon->currentPage(),'listing'=>$var];
    }

    
     public function transformFavSearchList($coupon) {
    
        $var = [];
        $var = $coupon->map(function ($item) {
   
            return [
                'coupon_id'=>$item->coupon_id??'',   
                'coupon_name'=>$item->coupon_name??'',
                'coupon_detail'=>$item->coupon_detail??'',  
                'vendor_address'=>$item->vendorDetail->vendor_address??'',  
                'vendor_logo'=>$item->vendorDetail->vendor_logo??'',
                'coupon_logo'=>$item->coupon_logo ??"",
                'distance'=>$item->distance??'',
                'coupon_latitude'=>$item->coupon_lat??'',
                'coupon_longitude'=>$item->coupon_long??'',
                 'is_favorite'=>$item->is_favorite??0,
                
            ];
        });
          return ['has_page'=>$coupon->hasMorePages(),'current_page'=>$coupon->currentPage(),'listing'=>$var];
    }
    
   
      public function transformDetail($item) {
    
            return [
                'coupon_id'=>$item->coupon_id??'',
                'coupon_logo'=>$item->coupon_logo??'',
                'vendor_name'=>$item->vendorDetail->vendor_name??'',
                'vendor_address'=>$item->vendorDetail->vendor_address??'',
                'coupon_name'=>$item->coupon_name??'',
                'coupon_detail'=>$item->coupon_detail??'',
                'coupon_qrcode_image'=>$item->coupon_qrcode_image??'',
                'coupon_redemption_code'=>$item->coupon_redemption_code??'',
                'coupon_end_date'=>$item->coupon_end_date??'',

            ];
       
         return ['has_page'=>$coupon->hasMorePages(),'current_page'=>$coupon->currentPage(),'listing'=>$var];
    }
    
       public function transformShareList($coupon) {
    
        $var = [];
        $var = $coupon->map(function ($item) {
   
            return [
                'coupon_id'=>$item->coupon_id??'',   
                'coupon_name'=>$item->coupon_name??'',
                'coupon_detail'=>$item->coupon_detail??'',  
                'vendor_address'=>$item->vendorDetail->vendor_address??'',  
               'vendor_logo'=>$item->vendorDetail->vendor_logo??'',
                'coupon_logo'=>$item->coupon_logo ??"",
     
                
            ];
        });
          return ['has_page'=>$coupon->hasMorePages(),'current_page'=>$coupon->currentPage(),'listing'=>$var];
    }
    


}
