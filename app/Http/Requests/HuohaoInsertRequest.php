<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HuohaoInsertRequest extends FormRequest
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
            //店铺选择
            'shopid'=>'required',
            //货号
            'huohao'=>'required',
            // 操作费
            'zmoney'=>'required|regex:/[0-9]+\.?[0-9]+/',
            
        ];
    }

    //自定义错误信息
    public function messages(){
        return [

            'shopid.required'=>'请选择店铺',
            'huohao.required'=>'货号不能为空',
	    // 'huohao.unique'=>'货号已经存在',
            'zmoney.required'=>'操作费不能为空',
            'zmoney.regex'=>'请输入正确的金额格式',
               ];
    }
}
