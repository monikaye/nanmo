<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhonesInsertRequest extends FormRequest
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
            //店铺
            'shopmark'=>'required',
            //手机编号
            'phoneid'=>'required',
            //日发单量
            'countday'=>'required',
            //绑定卡号
            'cardid'=>'required',
            //银行卡余额
            'cmoney'=>'required|regex:/[0-9]+\.?[0-9]+/',
            //微信余额
            'wxmoney'=>'required|regex:/[0-9]+\.?[0-9]+/',
        ];
    }

    //自定义错误信息
    public function messages(){
        return [

            'shopname.required'=>'商家店铺不能为空',

            'phoneid.required'=>'请选择手机编号',

            'countday.required'=>'日发单量不能为空',

            'cardid.required'=>'请选择绑定的银行卡号',

            'cmoney.required'=>'银行卡余额不能为空',
            'cmoney.regex'=>'银行卡余额格式不正确',

            'wxmoney.required'=>'微信余额不能为空',
            'wxmoney.regex'=>'微信余额格式不正确',

               ];
    }
}
