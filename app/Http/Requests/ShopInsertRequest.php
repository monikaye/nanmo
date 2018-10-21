<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopInsertRequest extends FormRequest
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
            //店铺名称
            'shopname'=>'required|unique:ly_admin_shop',
            //店铺地址
            'address'=>'required',
        ];
    }

    //自定义错误信息
    public function messages(){
        return [
            'shopname.required'=>'店铺名称不能为空',
            'shopname.unique'=>'店铺名称已经存在',
            'address.required'=>'店铺地址不能为空',

               ];
    }
}
