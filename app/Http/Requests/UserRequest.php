<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {

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
                        'first_name' => 'required|max:255',
                        'last_name' => 'required|max:255',
                        'category_id' => 'required',
                        'phone' => 'sometimes|required|min:6|max:20',
                        'email' => 'required|email|unique:users,email|max:255',
                        'profile_pic' => 'sometimes|required|image|mimes:jpg,png,jpeg',
                        'password' => 'sometimes|required|string|min:6',
                    ];
                }
            case 'PATCH': {

                    return [
                        'first_name' => 'required|max:255',
                        'last_name' => 'required|max:255',
                        'category_id' => 'required',
                        'phone' => 'sometimes|required|min:6|max:20',
                        'email' => 'required|email|unique:users,email,' . $this->segment(3) . '|max:255',
                        'profile_pic' => 'sometimes|required|image|mimes:jpg,png,jpeg',
                        'password' => 'sometimes|required|string|min:6',
                    ];
                }
        }
    }

}
