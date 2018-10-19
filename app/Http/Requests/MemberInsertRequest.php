<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberInsertRequest extends FormRequest
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
            //unique:adminUser |regex:/\w{4,8}
            // 'repassword'=>'required|regex:/\w{4,8}/|same:password',
            // 'email'=>'required|email|unique:adminUser',
            //设置微信备注名 required 数据不能为空 其他规则用|隔开
            'username'=>'required',
            //手机编号
            'phoneid'=>'required',
            //刷单人旺旺号
            'wwname'=>'required',
            //订单号
            'orders'=>'required|regex:/[0-9]{1,11}/',
            //淘气值
            'tqnum'=>'required|regex:/[0-9]{1,11}/',
            //货号
            'huohao'=>'required',
            //付款金额
            'fmoney'=>'required|regex:/[0-9]+\.?[0-9]+/',
            //佣金
            'ymoney'=>'regex:/[0-9]+\.?[0-9]+/',
            //放单人
            'fuserid'=>'required',
            //绩效
            'jixiao'=>'regex:/[0-9]+\.?[0-9]+/',
            //刷单时间
            'shuadan_time'=>'required|',
            //付款手机
            'fphone'=>'required',
            //额外付款金额
            'extra'=>'regex:/[0-9]+\.?[0-9]+/',

            
        ];
    }

    //自定义错误信息
    public function messages(){
        return [

            'username.required'=>'微信备注名不能为空',
            // 'username.unique'=>'用户名已经存在',
            'phoneid.required'=>'请选择手机编号',
            'wwname.required'=>'刷单人旺旺号不能为空',
            'wwname.required'=>'订单号不能为空',
            'wwname.regex'=>'订单号必须为1-11为数字',
            'tqnum.required'=>'淘气值不能为空',
            'tqnum.regex'=>'淘气值必须为1-11为数字',
            'huohao.required'=>'请选择货号',
            'fmoney.required'=>'付款金额不能为空',
            'fmoney.regex'=>'付款金额格式不正确',
            'ymoney.regex'=>'用金额格式不正确',
            'fuserid.required'=>'请选择放单人',
            'jixiao.regex'=>'绩效金额格式不正确',
            'shuadan_time.required'=>'刷单时间不能为空格式为20180917',
            'fphone.required'=>'请选择付款手机',




            // 'password.regex'=>'密码必须为4-8任意的数字字母下划线',
            // 'repassword.required'=>'确认密码不能为空',
            // 'repassword.regex'=>'确认密码必须为4-8任意的数字字母下划线',
            // 'repassword.same'=>'两次密码不一致',
            // 'email.required'=>'邮箱不能为空',
            // 'email.email'=>'邮箱格式不对',
            // 'email.unique'=>'邮箱重复',
               ];
    }
}
