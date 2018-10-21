<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use App\Http\Requests\UserInsertRequest;
class UserController extends Controller
{
    //
    //列表方法
    public function index(Request $request){
        //获取用户数据
        $info = DB::table("ly_admin_user")
                        ->where('id', '!=', '1')
                        ->paginate(12);
    	return view("Admin.User.index",["info"=>$info,"request"=>$request->all()]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //加载模板页面
        return view("Admin.User.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserInsertRequest $request)
    {
        $info                = $request -> except('repassword');
        $info['password']    = Hash::make($info["password"]);
        $info['create_time'] = time();
        $info['status']      = 1; 
        $log                 = [];
        $log['remark']       = '添加了1个用户:'.$request->input('username');
        $log['create_time']  = $info['create_time'];
        $log['userid']       = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        // 执行添加
        if (DB::table("ly_admin_user")->insert($info)) {
            DB::table('ly_admin_log')->insert($log);
            return redirect("/user")->with("success","添加成功");
        } else {
            return redirect("/user/create")->with("error","添加失败");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        if ($id == 1) {
            return redirect("/user")->with("error","超级管理员无法修改");
        }
        //获取当前的数据
        $info = DB::table("ly_admin_user")
                        ->where("id","=",$id)
                        ->first();
        
        //展示分类修改页面
        return view("Admin.User.edit",["info"=>$info]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        if ($id==1) {
            return redirect("/user")->with("error","超级管理员无法修改");
        }
        $log                = [];
        $log['remark']      = '修改了1个用户'.$request->input('username');
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //获取要修改得数据
        $data               = $request->except('_method', 'repassword');
        $data['password']   = Hash::make($data["password"]);
        //执行修改
        if (DB::table("ly_admin_user")->where("id",$id)->update($data)) {
            DB::table('ly_admin_log')->insert($log);
            return redirect("/user")->with("success","修改成功");
        } else {
            return redirect("/user/edit/{$id}")->with("error","修改失败");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        if ($id == 1) {
            return redirect("/user")->with("error","删除失败");
        }
        $user               = DB::table('ly_admin_user')
                                    ->where('id','=', $id)
                                    ->value('username');
        $log                = [];
        $log['remark']      = '删除了1个用户'.$user;
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //删除刷单任务表
        if(DB::table("ly_admin_user")->where("id","=",$id)->delete()){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/user")->with("success","删除成功");
        }else{
            return redirect("/user")->with("error","删除失败");
        }
    }

    
}
