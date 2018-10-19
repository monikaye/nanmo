<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCardInsertRequest extends FormRequest
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
            //银行卡
            'cardid'=>'required',
            //充值金额
            'addmoney'=>'required',
        ];
    }

    //自定义错误信息
    public function messages(){
        return [

            'cardid.required'=>'银行卡未选择',
            'addmoney.required'=>'重置金额不能为空',
               ];
    }
}
