<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->id,
            'birthdate' => 'required|date_format:d-m-Y',
            'address' => 'required',
            'phone' => 'required',
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required',
            'company_id' => "required_if:role_id,2|required_if:role_id,3"
        ];
    }
}
