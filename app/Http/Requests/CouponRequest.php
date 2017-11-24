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
        $commonvaldiation = ['coupon_name' => 'required|max:255',
            'coupon_detail' => 'required',
            'coupon_redeem_limit' => 'required|numeric',
            'coupon_end_date' => 'required',
            'coupon_logo' => 'sometimes|required|image|mimes:jpg,png,jpeg',
            'coupon_radius' => 'required|integer|min:1|max:10',
            'coupon_original_price' => 'required',
            'coupon_discounted_percent' => 'required_without:coupon_discounted_price',
        ];
        //update coupon validation 
        if ($this->request->get('coupon_id') != '') {
            if ($this->request->get('steps') == 1) {
                return $commonvaldiation +
                        $current = [
                    // step 1
                    'coupon_code' => 'required|unique:coupon,coupon_code,' . $this->request->get('coupon_id') . ',coupon_id',
                ];
            } elseif ($this->request->get('steps') == 2) {
                return $commonvaldiation +
                        $current = [
                    // step 1
                    'coupon_code' => 'required|unique:coupon,coupon_code,' . $this->request->get('coupon_id') . ',coupon_id',
                    //step 2
                    'coupon_notification_point' => 'required'
                ];
            } elseif ($this->request->get('steps') == 3) {
                return $commonvaldiation +
                        $current = [
                    // step 1
                    'coupon_code' => 'required|unique:coupon,coupon_code,' . $this->request->get('coupon_id') . ',coupon_id',
                    // step 2
                    'coupon_notification_point' => 'required',
                    // step 3        
                    'agree' => 'required'
                ];
            }
        }

        
        // create coupon validation
        if ($this->request->get('steps') == 1) {

            return $commonvaldiation +
                    $current = [
                // step 1
                'coupon_code' => 'required|unique:coupon',
            ];
        } elseif ($this->request->get('steps') == 2) {

            return $commonvaldiation +
                    $current = [
                // step 1
                'coupon_code' => 'required|unique:coupon',
                //step 2
                'coupon_notification_point' => 'required'
            ];
        } elseif ($this->request->get('steps') == 3) {

            return $commonvaldiation +
                    $current = [
                // step 1
                'coupon_code' => 'required|unique:coupon',
                //step 2
                'coupon_notification_point' => 'required',
                // step 3
                'agree' => 'required'
            ];
        }
    }

}
