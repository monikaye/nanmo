<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Requests\ShopInsertRequest;
class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $map  = [];
        if($request->input('shopname')) {
            $map[] = ['shopname', 'like', "%".$request->input('shopname')."%"];
            session(['sn'=>$request->input('shopname')]);
        }else{
            $request->session()->forget('sn');
        }
        $count = count(DB::table('ly_admin_shop')
                        ->where($map)
                        ->get());
        $rev    = '15';
        //3、求总页数
        $sums   = ceil($count/$rev);
        //4、求单前页
        $page   = $request->input('page');
        if (empty($page)) {
            $page = "1";
        }
        //5、设置上一页、下一页
        $prev   = ($page - 1) > 0?$page - 1:1;
        $next   = ($page + 1) < $sums?$page + 1:$sums;
        //6、求偏移量
        $offset = ($page - 1) * $rev;


        $info  = DB::table('ly_admin_shop')
                    ->where($map)
                    ->offset($offset)
                    ->limit($rev)
                    ->orderBy('id',' desc')
                    ->get();
        foreach ($info as $key => $value) {
            $huohao = DB::table("ly_admin_huohao")
                            ->where("shopid", "=", $value->id)
                            ->pluck("huohao");
            if(count($huohao)>0){
                $huo = "";
                foreach ($huohao as $k => $v) {
                    $huo = $huo.",".$v;
                }

                $info[$key]->huohao = ltrim($huo, ",");
            }else{
                $info[$key]->huohao = "无";
            }

        }
        //8、数字分页(可有可无)
        $pp     = array();
        for ($i = 1;$i <= $sums;$i++) {
            $pp[$i] = $i;
        }
        // dd($info);
        return view("Admin.Shop.index", ['info' => $info,'prev'=>$prev,'next'=>$next,'sums'=>$sums,'pp'=>$pp,'page'=>$page]);
    }


    public function page_pro_shop(Request $request)
    {   
        $map  = [];
        if(session('sn')) {
            $map[] = ['shopname', 'like', "%".session('sn')."%"];
        }
        $count = count(DB::table('ly_admin_shop')
                        ->where($map)
                        ->get());
        $rev    = '15';
        //3、求总页数
        $sums   = ceil($count/$rev);
        //4、求单前页
        $page   = $request->input('page');
        if (empty($page)) {
            $page = "1";
        }
        //5、设置上一页、下一页
        $prev   = ($page - 1) > 0?$page - 1:1;
        $next   = ($page + 1) < $sums?$page + 1:$sums;
        //6、求偏移量
        $offset = ($page - 1) * $rev;


        $info  = DB::table('ly_admin_shop')
                    ->where($map)
                    ->offset($offset)
                    ->limit($rev)
                    ->orderBy('id',' desc')
                    ->get();
        foreach ($info as $key => $value) {
            $huohao = DB::table("ly_admin_huohao")
                            ->where("shopid", "=", $value->id)
                            ->pluck("huohao");
            if(count($huohao)>0){
                $huo = "";
                foreach ($huohao as $k => $v) {
                    $huo = $huo.",".$v;
                }

                $info[$key]->huohao = ltrim($huo, ",");
            }else{
                $info[$key]->huohao = "无";
            }

        }
        //8、数字分页(可有可无)
        $pp     = array();
        for ($i = 1;$i <= $sums;$i++) {
            $pp[$i] = $i;
        }
        // dd($info);
        return view("Admin.Shop.page", ['info' => $info,'prev'=>$prev,'next'=>$next,'sums'=>$sums,'pp'=>$pp,'page'=>$page]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //展示添加页面
    public function create()
    {   
        //加载添加模板
        return view("Admin.Shop.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 执行店铺添加
    public function store(ShopInsertRequest $request)
    {   
        //获取要添加得数据
        $data                = $request->input();
        $data['create_time'] = time();
        $data['userid']      = DB::table('ly_admin_user')
                                     ->where('username','=', session('username'))
                                     ->value('id');
        $log                 = [];
        $log['remark']       = '添加了1个店铺:'.$request->input('shopname');
        $log['create_time']  = $data['create_time'];
        $log['userid']       = $data['userid'];
        // var_dump($data);exit;
        // 执行添加
        if (DB::table("ly_admin_shop")->insert($data)){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/shop")->with("success","添加成功");
        } else {
            return redirect("/shop/create")->with("error","添加失败");
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
        
        //获取当前的数据
        $info = DB::table("ly_admin_shop")
                        ->where("id","=",$id)
                        ->first();
        
        //展示分类修改页面
        return view("Admin.Shop.edit",["info"=>$info]);
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
        $log                = [];
        $log['remark']      = '修改了1个店铺'.$request->input('shopname');
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //获取要修改得数据
        $data               = $request->except('_method');
        //执行修改
        if (DB::table("ly_admin_shop")->where("id", '=', $id)->update($data)){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/shop")->with("success","修改成功");
        } else {
            return redirect("/shop/{$id}/edit")->with("error","修改失败");
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
        $shop               = DB::table('ly_admin_shop')
                                    ->where('id','=', $id)
                                    ->value('shopname');
        $log                = [];
        $log['remark']      = '删除了1个店铺:'.$shop;
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //删除刷单任务表
        if (DB::table("ly_admin_shop")->where("id","=",$id)->delete()){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/shop")->with("success","删除成功");
        } else {
            return redirect("/shop")->with("error","删除失败");
        }
        
    }
}
