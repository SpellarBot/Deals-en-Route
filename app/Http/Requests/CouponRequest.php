<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        if ($this->request->get('steps') == 1) {
            return [
//                // step 1
                'coupon_name' => 'required|max:255',   
                'coupon_detail' => 'required',
                'coupon_redeem_limit' => 'required|numeric',
                'coupon_code' => 'required|unique:coupon',
                'coupon_end_date' => 'required',
                'coupon_logo' => 'required',
                'coupon_radius' =>'required|integer|min:1|max:500',
                'coupon_original_price'=>'required',
                'coupon_discounted_percent' => 'required_without:coupon_discounted_price',
               
         
            ];
        } elseif ($this->request->get('steps') == 2) {
            return [
                  // step 1
                   'coupon_name' => 'required|max:255',   
                'coupon_detail' => 'required',
                'coupon_redeem_limit' => 'required|numeric',
                'coupon_code' => 'required|unique:coupon',
                'coupon_end_date' => 'required',
                'coupon_logo' => 'required',
                'coupon_radius' =>'required|integer|min:1|max:500',
                'coupon_original_price'=>'required',
                'coupon_discounted_percent' => 'required_without:coupon_discounted_price',
                // step 2
                'coupon_notification_sqfeet'=>'required'
            ];
        } elseif ($this->request->get('steps') == 3) {
            return [
                  // step 1
               'coupon_name' => 'required|max:255',   
                'coupon_detail' => 'required',
                'coupon_redeem_limit' => 'required|numeric',
                'coupon_code' => 'required|unique:coupon',
                'coupon_end_date' => 'required',
                'coupon_logo' => 'required',
                'coupon_radius' =>'required|integer|min:1|max:500',
                'coupon_original_price'=>'required',
                'coupon_discounted_percent' => 'required_without:coupon_discounted_price',
                // step 2
                'coupon_notification_sqfeet'=>'required',
                // step 3
                'agree' => 'required'
            ];
        }
    }
    


}
