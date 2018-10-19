<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhoneInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    //表单授权
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    //设置校验规则
    public function rules()
    {
        return [
            //微信号
            'wxnumber'=>'required',
            //手机编号
            'phonenum'=>'required|unique:ly_admin_phone',
            //手机号
            'number'=>'required|regex:/^1[0-9]{10}$/|unique:ly_admin_phone',
            

            //微信余额
            'money'=>'required|regex:/[0-9]+\.?[0-9]+/',

            //绑定卡号
            'cardid'=>'required',

           
            
            
        ];
    }

    //自定义错误信息
    public function messages(){
        return [

            'wxnumber.required'=>'微信号不能为空',
            
            'phonenum.required'=>'手机编号不能为空',
            'phonenum.unique'=>'手机编号已存在',
            
            'number.required'=>'手机号不能为空',
            'number.regex'=>'请输入正确的手机号',
            'number.unique'=>'手机号已存在',

           

            'money.required'=>'微信余额不能为空',
            'money.regex'=>'微信余额格式不正确',

            'cardid.required'=>'请选择绑定的银行卡号',
        
               ];
    }
}
