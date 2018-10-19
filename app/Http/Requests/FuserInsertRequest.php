<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FuserInsertRequest extends FormRequest
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
            //设置放单人名称 required 数据不能为空 其他规则用|隔开
            'username'=>'required|unique:ly_admin_fuser',
        ];
    }

    //自定义错误信息
    public function messages(){
        return [

            'username.required'=>'放单人名称不能为空',
            'username.unique'=>'放单人名称已经存在',
               ];
    }
}
