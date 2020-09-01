<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
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
           'email'=>'|email',
           'password'=>'required'
        ];
    }

    public function messages()
    {
        return [
           'email.required'=>' يجب ادخال الاميل ',
           'email.email'=>' يجب ادخال البريد الالكتروني بصيغة صحيحة ex:ashraf@gmail.com',

           'password.required'=>' يجب ادخال كلمة المرور'
        ];
    }
}