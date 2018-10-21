<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserInsertRequest extends FormRequest
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
            
            //账号
            'username'=>'required|unique:ly_admin_user',
            //密码
            'password'=>'required|regex:/\w{4,20}/',
            //确认密码
            'repassword'=>'required|regex:/\w{4,20}/|same:password',
            
        ];
    }

    //自定义错误信息
    public function messages(){
        return [

            

            'username.required'=>'账号不能为空',
            'username.unique'=>'账号已经存在',

            'password.required'=>'密码不能为空',
            'password.regex'=>'请输入4-20位密码',

            'repassword.required'=>'确认密码不能为空',
            'repassword.same'=>'两次密码不一致',
            
           
               ];
    }
}
