<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
//导入校验请求类
class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    //主页
    public function login(){
        return view("Admin.Login.index");
    }
    
    public function dologin(Request $request){
    	//获取数据库信息对比
        $user = DB::table("ly_admin_user")
                    ->where("username","=",$request->input("username"))
                    ->first();
        if(!$user){
            return redirect("/login")->with('errors',"账号不存在");
        }
        if(Hash::check($request->input('password'),$user->password)){
            //把用户信息上传session
            session(['username' => $request->username]);
            //获取当前用户所有的权限node表信息 控制器名字 方法名字
            $list = DB::select("select n.name,n.mname,n.aname from ly_admin_user_role as ur,ly_admin_role_node as rn,ly_admin_node as n where ur.rid = rn.rid and rn.nid = n.id and uid ={$user->id}");
            //权限初始化 让所有的管理员具有后台访问权限
            $nodelist["AdminController"][] = "index";
            //遍历
            foreach($list as $v){
                //把所有全选写入nodelist
                $nodelist[$v->mname][] = $v->aname;
                //如果权限列表里有create 方法 添加store
                if($v->aname == "create"){
                    $nodelist[$v->mname][] = "store";
                }
                //如果权限列表里有edit方法 添加update
                if($v->aname == "edit"){
                    $nodelist[$v->mname][] = "update";
                }
                if($v->aname == "daoru"){
                    $nodelist[$v->mname][] = "read";
                }
                if($v->aname == "dao"){
                    $nodelist[$v->mname][] = "daoru";
                }

            }
            // 把初始化的权限信息 放置在session里
            session(['nodelist' => $nodelist]);
            return redirect("/index");
        }else{
            return redirect("/login")->with('errors',"密码或账号不正确");
            
        }

    }
    //注销
    public function outlogin(Request $request){
        //删除session数据username
        $request->session()->pull("username");
        $request->session()->pull("nodelist");
        return redirect("/login");
    }
    
}
