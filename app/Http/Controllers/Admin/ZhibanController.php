<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
date_default_timezone_set("Asia/Shanghai");
// use App\Http\Requests\PhoneInsertRequest;
class ZhibanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $count  = count(DB::table('ly_admin_zhiban')->get());
        $rev    = '20';
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
        //8、数字分页(可有可无)
        $pp     = array();
        for ($i = 1;$i <= $sums;$i++) {
            $pp[$i] = $i;
        }
        $info   = DB::table('ly_admin_zhiban as z')
                        ->join('ly_admin_fuser as f', 'z.fuserid', '=', 'f.id')
                        ->select('z.*', 'f.username')
                        ->orderBy('z.shuadan_time',' desc')
                        ->get();
        foreach($info as $key => $value){
            $info[$key]->userid = DB::table('ly_admin_user')
                                        ->where('id', '=', $value->userid)
                                        ->value('username');
        }
       
        return view("Admin.Zhiban.index", ['info' => $info, 'prev'=>$prev,'next'=>$next,'sums'=>$sums,'pp'=>$pp,'page'=>$page]);
    }
    

    public function addzhiban()
    {   
        $fuser = DB::table('ly_admin_fuser')
                    ->select( 'id', 'username')
                    ->orderBy('id',' desc')
                    ->get();


        return view("Admin.Zhiban.add", ['fuser' => $fuser]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 执行添加
    public function doaddzhiban(Request $request)
    {   
        //获取放单人id
        $data["fuserid"]     = $request->input('id');
        //获取刷单日期
        $data["shuadan_time"]= $request->input('st');
        $data['create_time'] = time();
        $data['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');

        $log                 = [];
        $log['remark']       = '安排了一条值班';
        $log['create_time']  = $data['create_time'];
        $log['userid']       = $data['userid'];
        // æ‰§è¡Œæ·»åŠ 
        if (DB::table("ly_admin_zhiban")->insert($data)){
            DB::table('ly_admin_log')->insert($log);
            echo 1;
        } else {
            echo 2;
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
    public function editzhiban(Request $request)
    {   
        
        $info   = DB::table("ly_admin_zhiban")
                        ->where("id", "=", $request->input('id'))
                        ->first();
        $fuser  = DB::table('ly_admin_fuser')
                        ->select( 'id', 'username')
                        ->orderBy('id',' desc')
                        ->get();
        return view("Admin.Zhiban.edit",["info" => $info, 'fuser' => $fuser]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function doeditzhiban(Request $request)
    {   
        $id                 = $request->input('id');
        //获取原数据
        $oldzhiban          = DB::table('ly_admin_zhiban')
                                    ->where('id', '=', $id)
                                    ->first();
        if($oldzhiban->fuserid != $request->input('fid')){
            $data['fuserid']      = $request->input('fid');
        }
        if($oldzhiban->shuadan_time != $request->input('st')){
            $data['shuadan_time'] = $request->input('st');
        }

        $log                = [];
        $log['remark']      = '修改了1一条值班小组长信息';
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //æ‰§è¡Œä¿®æ”¹
        if (DB::table("ly_admin_zhiban")->where("id", '=', $id)->update($data)){
            DB::table('ly_admin_log')->insert($log);
            echo 1;
        } else {
            echo 2;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delzhiban(Request $request)
    {   
        
        $log                = [];
        $log['remark']      = '删除了1条值班信息';
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //åˆ é™¤åˆ·å•ä»»åŠ¡è¡?
        if (DB::table("ly_admin_zhiban")->where("id","=",$request->input('id'))->delete()){
            DB::table('ly_admin_log')->insert($log);
            echo 1;
        } else {
            echo 2;
        }
        
    }
}
