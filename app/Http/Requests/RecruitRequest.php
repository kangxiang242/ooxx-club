<?php

namespace App\Http\Requests;



class RecruitRequest extends BaseRequest
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
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'message'=>'required',
            'job'=>'required',
            'sex'=>'required',
            'line'=>'required',
            'captcha'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'captcha.required'=>'請輸入驗證碼',

        ];
    }


}
