<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest {

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
        switch ($this->method()) {
            case 'POST': {
                    return [
                        'vendor_name' => 'required|max:255',
                        'vendor_address' => 'required',
                        'vendor_category' => 'required',
                        'vendor_phone' => 'required',
                        'email' => 'required|email|unique:users,email|max:255',
                        'vendor_logo' => 'required|image|mimes:jpg,png,jpeg',
                        'password' => 'required|string|min:6|confirmed',
                        'vendor_city' => 'required',
                        'vendor_zip' => 'required',
                    ];
                }
            case 'PATCH': {

                    return [
                        'vendor_name' => 'required|max:255',
                        'vendor_address' => 'required',
                        'email' => 'required|email|unique:users,email,' . $this->segment(3) . '|max:255',
                        'vendor_logo' => 'required|image|mimes:jpg,png,jpeg',
                        'vendor_category' => 'required',
                        'vendor_city' => 'required',
                        'vendor_zip' => 'required',
                        'vendor_phone' => 'required',
                    ];
                }
        }
    }

}
