<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaledInsertRequest extends FormRequest
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
            //设置微信备注名
            'wxname'=>'required',
            //付款手机编号
            'fphone'=>'required',
            //付款手机编号
            'phoneid'=>'required',
            //原因
            'why'=>'required',
            //对应店铺
            // 'shopid'=>'required',
            //发生日期
            'hap_time'=>'required',
            //赔偿完结日期
            // 'over_time'=>'required',
            //放单人
            'fuserid'=>'required',
            //赔偿金额
            'smoney'=>'required|regex:/[0-9]+\.?[0-9]+/',
            
        ];
    }

    //自定义错误信息
    public function messages(){
        return [
            'wxname.required'=>'微信号不能为空',

            'fphone.required'=>'付款手机编号',
            'phoneid.required'=>'所在手机编号',

            'why.required'=>'原因不能为空',

            // 'shopid.required'=>'请选择店铺',

            'hap_time.required'=>'请输入发生日期',
            // 'over_time.required'=>'请输入完结日期',

            'fuserid.required'=>'请选择放单人',

            'smoney.required'=>'赔偿金额不能为空',
            'smoney.regex'=>'赔偿金额格式不正确',

               ];
    }
}
