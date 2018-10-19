<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Requests\HuohaoInsertRequest;
class HuohaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $map  = [];
        if($request->input('huohao')) {
            $map[] = ['h.huohao', 'like', "%".$request->input('huohao')."%"];
            session(['huohao'=>$request->input('huohao')]);
        }else{
            $request->session()->forget('huohao');
        }
        $count = count(DB::table('ly_admin_huohao as h')
                         ->join('ly_admin_shop as s', 'h.shopid', '=', 's.id')
                         ->select('h.huohao', 'h.zmoney', 's.shopname', 'h.create_time', 'h.id as hid')
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

        $info  = DB::table('ly_admin_huohao as h')
                         ->join('ly_admin_shop as s', 'h.shopid', '=', 's.id')
                         ->select('h.huohao', 'h.zmoney', 's.shopname', 'h.create_time', 'h.id as hid')
                         ->where($map)
                         ->offset($offset)
                         ->limit($rev)
                         ->get();
        //8、数字分页(可有可无)
        $pp     = array();
        for ($i = 1;$i <= $sums;$i++) {
            $pp[$i] = $i;
        }
        
        return view("Admin.Huohao.index", ['info' => $info,'prev'=>$prev,'next'=>$next,'sums'=>$sums,'pp'=>$pp,'page'=>$page]);
    }

    public function page_pro_huohao(Request $request)
    {   
        $map  = [];
        if(session('huohao')) {
            $map[] = ['h.huohao', 'like', "%".session('huohao')."%"];
        }
        $count = count(DB::table('ly_admin_huohao as h')
                         ->join('ly_admin_shop as s', 'h.shopid', '=', 's.id')
                         ->select('h.huohao', 'h.zmoney', 's.shopname', 'h.create_time', 'h.id as hid')
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

        $info  = DB::table('ly_admin_huohao as h')
                         ->join('ly_admin_shop as s', 'h.shopid', '=', 's.id')
                         ->select('h.huohao', 'h.zmoney', 's.shopname', 'h.create_time', 'h.id as hid')
                         ->where($map)
                         ->offset($offset)
                         ->limit($rev)
                         ->get();
        //8、数字分页(可有可无)
        $pp     = array();
        for ($i = 1;$i <= $sums;$i++) {
            $pp[$i] = $i;
        }
        
        return view("Admin.Huohao.page", ['info' => $info,'prev'=>$prev,'next'=>$next,'sums'=>$sums,'pp'=>$pp,'page'=>$page]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //展示添加页面
    public function create()
    {   
        //获取要添加的数据选项
        //获取店铺
        $shop = DB::table("ly_admin_shop") 
                         ->select('shopname','id') 
                         ->get();
        //加载添加模板
        return view("Admin.Huohao.add", ['shop' => $shop] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 执行日常刷单任务添加
    public function store(HuohaoInsertRequest $request)
    {   
        //获取要添加得数据
        $data                = $request->input();
        $data['create_time'] = time();
        $log                 = [];
        $log['remark']       = '添加了1个货号'.$request->input('username');
        $log['create_time']  = $data['create_time'];
        $log['userid']       = DB::table('ly_admin_user')
                                        ->where('username','=', session('username'))
                                        ->value('id');
        // 执行添加
        if(DB::table("ly_admin_huohao")->insert($data)){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/huohao")->with("success","添加成功");
        }else{
            return redirect("/huohao/create")->with("error","添加失败");
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
        $info = DB::table("ly_admin_huohao")
                         ->where("id","=",$id)
                         ->first();
        //获取店铺
        $shop = DB::table("ly_admin_shop") 
                         ->select('shopname','id') 
                         ->get();
        
        //展示分类修改页面
        return view("Admin.Huohao.edit",["info"=>$info, 'shop' => $shop]);
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
        $log['remark']      = '修改了1个货号'.$request->input('username');
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                       ->where('username','=', session('username'))
                                       ->value('id');
        //获取要修改得数据
        $data=$request->except('_method');
        //执行修改
        if (DB::table("ly_admin_huohao")->where("id",$id)->update($data)){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/huohao")->with("success","修改成功");
        } else {
            return redirect("/huohao/edit/{$id}")->with("error","修改失败");
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
        $huohao             = DB::table('ly_admin_huohao')
                                        ->where('id','=', $id)
                                        ->value('huohao');
        $log                = [];
        $log['remark']      = '删除了1个货号'.$huohao;
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                        ->where('username','=', session('username'))
                                        ->value('id');
        //删除刷单任务表
        if (DB::table("ly_admin_huohao")->where("id","=",$id)->delete()){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/huohao")->with("success","删除成功");
        } else {
            return redirect("/huohao")->with("error","删除失败");
        }
        
    }
}
