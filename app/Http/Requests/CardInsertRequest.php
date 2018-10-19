<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardInsertRequest extends FormRequest
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
            //
            //设置银行卡 required 数据不能为空 其他规则用|隔开
            'number'=>'required|unique:ly_admin_card',
            //银行卡卡主
            'cardname'=>'required',
            //卡内金额
            'money'=>'required|regex:/[0-9]+\.?[0-9]+/',
        ];
    }

    //自定义错误信息
    public function messages(){
        return [

            'number.required'=>'银行卡号不能为空',
            'number.unique'=>'银行卡号已经存在',
            'cardname.required'=>'卡主不能为空',
            'money.required'=>'卡内金额与不能为空',
            'money.regex'=>'请输入正确的金额格式',

               ];
    }
}
