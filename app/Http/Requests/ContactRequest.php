<?php

namespace App\Http\Requests;



class ContactRequest extends BaseRequest
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

            'service_name'=>'required',
            'address'=>'required',
            'contact_time'=>'required',
            'phone'=>'required',
            'captcha'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'請輸入姓名',

            'service_name.required'=>'請選擇咨詢項目',
            'address.required'=>'請選擇地區',
            'contact_time.required'=>'請選擇聯絡時間',
            'phone.required'=>'請輸入電話',
            'captcha.required'=>'請輸入驗證碼',
        ];
    }


}
