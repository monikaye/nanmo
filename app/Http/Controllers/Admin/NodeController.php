<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class NodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        //获取节点数据
        $data = DB::table("ly_admin_node")
                    ->paginate(10);
        //展示主页
        return view("Admin.Node.index",["data"=>$data,"request"=>$request->all()]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Admin.Node.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //获取添加数据
        $list           = $request->except("_token");
        $list["status"] = 0;
        //执行添加
        if (DB::table("ly_admin_node")->insert($list)){
            return redirect("/node")->with("success","添加成功");
        } else {
            return redirect("/node/create")->with("error","添加失败");
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
        //获取修改的数据
        $node = DB::table("ly_admin_node")
                    ->where("id","=",$id)
                    ->first();
        //显示模板
        return view("Admin.Node.edit",["node"=>$node]);
        
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
        //获取修改的数据
        $nodes = $request->only("name","mname","aname","status");
        //执行修改
        if (DB::table("ly_admin_node")->where("id","=",$id)->update($nodes)){
            return redirect("/node")->with("success","修改成功");
        } else {
            return redirect("/node")->with("error","修改失败");
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
        //执行删除
        if (DB::table("ly_admin_node")->where("id","=",$id)->delete()){
            return redirect("/node")->with("success","删除成功");
        } else {
            return redirect("/node")->with("error","删除失败");
        }
    }
}
