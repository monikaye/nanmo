<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
date_default_timezone_set("Asia/Shanghai");
// use App\Http\Requests\PhoneInsertRequest;
class FakuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $count  = count(DB::table('ly_admin_error')->get());
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
        $info   = DB::table('ly_admin_error as r')
                        ->join('ly_admin_fuser as bcf', 'r.bcfuserid', '=', 'bcf.id')
                        ->join('ly_admin_fuser as cf', 'r.cfuserid', '=', 'cf.id')
                        ->select('r.*', 'bcf.username as bcname', 'cf.username as cname')
                        ->orderBy('r.shuadan_time',' desc')
                        ->get();
        foreach($info as $key => $value){
            $info[$key]->userid = DB::table('ly_admin_user')
                                        ->where('id', '=', $value->userid)
                                        ->value('username');
        }
       
        return view("Admin.Fakuan.index", ['info' => $info, 'prev'=>$prev,'next'=>$next,'sums'=>$sums,'pp'=>$pp,'page'=>$page]);
    }
    

    public function addfakuan()
    {   
        $fuser = DB::table('ly_admin_fuser')
                    ->select( 'id', 'username')
                    ->orderBy('id',' desc')
                    ->get();


        return view("Admin.Fakuan.add", ['fuser' => $fuser]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 执行添加
    public function doaddfakuan(Request $request)
    {   
        //获取被惩罚人id
        $data["bcfuserid"]     = $request->input('bcid');
        //获取监督人id
        $data["cfuserid"]      = $request->input('cid');
        //获取惩罚日期
        $data["shuadan_time"]  = $request->input('st');
        //获取罚款金额
        $data['money']         = $request->input('fj');
        //获取备注
        $data['remark']        = $request->input('rk') != "" ? $request->input('rk') : '无';

        $data['create_time']   = time();
        $data['userid']        = DB::table('ly_admin_user')
                                        ->where('username','=', session('username'))
                                        ->value('id');

        $log                   = [];
        $log['remark']         = '添加一条惩罚信息';
        $log['create_time']    = $data['create_time'];
        $log['userid']         = $data['userid'];
        // æ‰§è¡Œæ·»åŠ 
        if (DB::table("ly_admin_error")->insert($data)){
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
    public function editfakuan(Request $request)
    {   
        
        $info   = DB::table("ly_admin_error")
                        ->where("id", "=", $request->input('id'))
                        ->first();

        $fuser  = DB::table('ly_admin_fuser')
                        ->select( 'id', 'username')
                        ->orderBy('id',' desc')
                        ->get();
        return view("Admin.Fakuan.edit",["info" => $info, 'fuser' => $fuser]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function doeditfakuan(Request $request)
    {   
        $id                 = $request->input('id');
        //获取原数据
        $oldfakuan          = DB::table('ly_admin_error')
                                    ->where('id', '=', $id)
                                    ->first();
        if($oldfakuan->bcfuserid != $request->input('bcfid')){
            $data['bcfuserid']      = $request->input('bcfid');
        }
        if($oldfakuan->cfuserid != $request->input('cfid')){
            $data['cfuserid'] = $request->input('cfid');
        }
        if($oldfakuan->money != $request->input('fj')){
            $data['money'] = $request->input('fj');
        }
        if($oldfakuan->shuadan_time != $request->input('st')){
            $data['shuadan_time'] = $request->input('st');
        }
        if($oldfakuan->remark != $request->input('rk')){
            $data['remark'] = $request->input('rk');
        }

        $log                = [];
        $log['remark']      = '修改了1一条罚款信息';
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //æ‰§è¡Œä¿®æ”¹
        if (DB::table("ly_admin_error")->where("id", '=', $id)->update($data)){
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
    public function delfakuan(Request $request)
    {   
        
        $log                = [];
        $log['remark']      = '删除了1条罚款信息';
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //åˆ é™¤åˆ·å•ä»»åŠ¡è¡?
        if (DB::table("ly_admin_error")->where("id","=",$request->input('id'))->delete()){
            DB::table('ly_admin_log')->insert($log);
            echo 1;
        } else {
            echo 2;
        }
        
    }
}
