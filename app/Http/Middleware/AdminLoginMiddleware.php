<?php

namespace App\Http\Middleware;

use Closure;

class AdminLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if($request->session()->has("username")){
            //获取访问的控制器和方法
            $action     = $request->route()->getActionMethod();
            $actions    = explode("\\",\Route::current()->getActionName());
            $modelName  = $actions[count($actions)-2]=='Controllers'?null:$actions[count($actions)-2];
            $func       = explode("@",$actions[count($actions)-1]);
            //获取控制器的名字
            $controller = $func[0];
            $actionName = $func[1];
            //获取当前用户的登录权限
            $nodelist   = session("nodelist");
            //判断是否有权限访问
            if(empty($nodelist[$controller]) || !in_array($action,$nodelist[$controller])){
                return redirect("/")->with('error','抱歉,你没有权限访问该模块,请联系超级管理员');
            }
            return $next($request);
        }else{
            return redirect("/login");
        }



        
    }
}
