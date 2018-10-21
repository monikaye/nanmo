<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class RolelistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //获取所有角色数据
        $datal = DB::table("ly_admin_role")
                        ->get();
        return view("Admin.Role.index",["datal"=>$datal]);
    }

    //权限分配
    public function auth($id){
        //获取要分配的角色信息
        $role = DB::table("ly_admin_role")
                        ->where("id","=",$id)
                        ->first();
        //获取所有的权限信息
        $node = DB::table("ly_admin_node")
                        ->get();
        //获取要分配的角色原有的权限信息
        $data = DB::table("ly_admin_role_node")
                        ->where("rid","=",$id)
                        ->get();
        if(count($data)){
            foreach($data as $v){
                $nids[] = $v->nid;
            }
            return view("Admin.Role.auth",["role"=>$role,"node"=>$node,"nids"=>$nids]);
        }else{
            return view("Admin.Role.auth",["role"=>$role,"node"=>$node,"nids"=>array()]);
        }
    }

    //保存权限
    public function saveauth(Request $request){
        //获取分配的权限id
        $nids = $_POST['nids'];
        //获取要分配的角色的ID
        $rid  = $request->input("rid");
        //删除原来的权限
        DB::table("ly_admin_role_node")
                ->where("rid","=",$rid)
                ->delete();
        //遍历
        foreach($nids as $vv){
            //新的权限数组
            $dates["rid"] = $rid;
            $dates["nid"] = $vv;
            //插入新的权限
            DB::table("ly_admin_role_node")
                    ->insert($dates);
        }
        return redirect("/role")->with("success","权限分配成功");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //显示角色添加页面
        return view("Admin.Role.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data           = $request->only("name");
        $data["status"] = 0;
        if(DB::table("ly_admin_role")->insert($data)){
            return redirect("/role")->with("success","添加成功");
        }else{
            return redirect("/role")->with("error","添加失败");

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
        //获取角色信息
        $data = DB::table("ly_admin_role")
                        ->where("id","=",$id)
                        ->first();
        return view("Admin.Role.edit",["data"=>$data]);
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
        //获取需要修改的数据
        $list           = $request->only("name");
        $list["status"] = 0;
        //执行修改
        if(DB::table("ly_admin_role")->where("id","=",$id)->update($list)){
            return redirect("/role")->with("success","修改成功");
        }else{
            return redirect("/role")->with("error","修改失败");
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
        if(DB::table("ly_admin_role")->where("id","=",$id)->delete()){
            return redirect("/role")->with("success","删除成功");
        }else{
            return redirect("/role")->with("error","删除失败");
        }
    }

    //分配角色
    public function rolelist($id){
        //获取管理员信息
        $info = DB::table("ly_admin_user")
                        ->where("id",'=',$id)
                        ->first();
        //获取所有的角色信息
        $role = DB::table("ly_admin_role")
                        ->get();
        //获取当前用户所具有的角色信息
        $data = DB::table("ly_admin_user_role")
                        ->where("uid",'=',$id)
                        ->get();
        // dd($data);
        if(count($data)){
            //遍历
            foreach($data as $v){
                $rids[]=$v->rid;
            }
        //
            // echo $id;
            //加载分配角色模板
            return view("Admin.User.rolelist",['info'=>$info,'role'=>$role,'rids'=>$rids]);
        }else{
            //加载分配角色模板
            return view("Admin.User.rolelist",['info'=>$info,'role'=>$role,'rids'=>array()]);
        }
        
    }

    //保存角色
    public function saverole(Request $request){
        //获取新角色的ID
        $role   = $_POST['rids'];
        //获取用户ID
        $uid    = $request->input("uid");
        //把角色已有用户信息删除
        DB::table("ly_admin_user_role")
                ->where("uid","=",$uid)
                ->delete();
        foreach($role as $v){
            $data["uid"] = $uid;
            $data["rid"] = $v;
            //插入新角色
            DB::table("ly_admin_user_role")
                ->insert($data);

        }
        return redirect("/user")->with("success","角色分配成功");

    }
}
