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
                'coupon_name' => 'required|max:255',
                'coupon_detail' => 'required',
                'coupon_redeem_limit' => 'required|numeric',
                'coupon_code' => 'required',
                'coupon_end_date' => 'required',
                'coupon_logo' => 'required'
            ];
        } elseif ($this->request->get('steps') == 2) {
            return [
                'coupon_name' => 'required|max:255',
                'coupon_detail' => 'required',
                'coupon_redeem_limit' => 'required|numeric',
                'coupon_code' => 'required',
                'coupon_end_date' => 'required',
                'coupon_logo' => 'required'
            ];
        } elseif ($this->request->get('steps') == 3) {
            return [
                'agree' => 'required'
            ];
        }
    }

}
