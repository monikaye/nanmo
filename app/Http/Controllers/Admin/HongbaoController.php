<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
date_default_timezone_set("Asia/Shanghai");
// use App\Http\Requests\PhoneInsertRequest;
class HongbaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $count  = count(DB::table('ly_admin_hongbao')->get());
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
        $info   = DB::table('ly_admin_hongbao as h')
                        ->join('ly_admin_phone as p', 'h.phoneid', '=', 'p.id')
                        ->select('h.*', 'p.phonenum')
                        ->orderBy('h.create_time',' desc')
                        ->get();
        foreach($info as $key => $value){
            $info[$key]->sum    = $value->number * $value->hmoney;
            $info[$key]->userid = DB::table('ly_admin_user')
                                        ->where('id', '=', $value->userid)
                                        ->value('username');
        }
       
        return view("Admin.Hongbao.index", ['info' => $info, 'prev'=>$prev,'next'=>$next,'sums'=>$sums,'pp'=>$pp,'page'=>$page]);
    }
    

    public function addhongbao()
    {   
        $phone = DB::table('ly_admin_phone')
                    ->select( 'id', 'phonenum')
                    ->orderBy('phonenum',' desc')
                    ->get();


        return view("Admin.Hongbao.add", ['phone' => $phone]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 执行添加
    public function dohongbao(Request $request)
    {   
        //获取手机id
        $data["phoneid"]     = $request->input('id');
        //获取红包金额
        $data["hmoney"]      = $request->input('hm');
        //获取红包个数
        $data["number"]      = $request->input('nu');
        $data['create_time'] = time();
        $data['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //通过手机id获得银行卡id
        $cardid              = DB::table('ly_admin_phone')
                                    ->where('id', '=', $data["phoneid"])
                                    ->value('cardid');
        //获得原金额
        $oldmoney            = DB::table('ly_admin_card')
                                    ->where('id', "=", $cardid)
                                    ->value('money');
        //获得新金额
        $newmoney            = $oldmoney - ($data["hmoney"] * $data["number"]);
        $card['money']       = $newmoney;

        $log                 = [];
        $log['remark']       = '添加了1条红包数据,'.'个数为:'.$data["number"].'个,单个金额为'.$data["number"];
        $log['create_time']  = $data['create_time'];
        $log['userid']       = $data['userid'];
        // æ‰§è¡Œæ·»åŠ 
        if (DB::table("ly_admin_hongbao")->insert($data)){
            DB::table('ly_admin_log')->insert($log);
            DB::table("ly_admin_card")->where("id", '=', $cardid)->update($card);
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
    public function edithongbao(Request $request)
    {   
        
        $info   = DB::table("ly_admin_hongbao")
                        ->where("id", "=", $request->input('id'))
                        ->first();

        $phone = DB::table('ly_admin_phone')
                        ->select( 'id', 'phonenum')
                        ->orderBy('phonenum',' desc')
                        ->get();
        
        //å±•ç¤ºåˆ†ç±»ä¿®æ”¹é¡µé¢
        return view("Admin.Hongbao.edit",["info" => $info, 'phone' => $phone]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function doedithongbao(Request $request)
    {   
        $id                 = $request->input('id');
        //获取原数据
        $oldhongbao         = DB::table('ly_admin_hongbao')
                                    ->where('id', '=', $id)
                                    ->first();
        if($oldhongbao->hmoney != $request->input('hm')){
            $data['hmoney'] = $request->input('hm');
        }
        if($oldhongbao->number != $request->input('nu')){
            $data['number'] = $request->input('nu');
        }
        //通过手机id获得银行卡id
        $cardid             = DB::table('ly_admin_phone')
                                    ->where('id', '=', $oldhongbao->phoneid)
                                    ->value('cardid');
        //拼接银行卡的余额
        $oldcard            = DB::table('ly_admin_card')
                                    ->where('id', '=', $cardid)
                                    ->value('money');
        $card['money']      = ($oldcard + ($oldhongbao ->hmoney * $oldhongbao ->number)) - ($request->input('nu') * $request->input('hm'));


        $log                = [];
        $log['remark']      = '修改了1条红包';
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //æ‰§è¡Œä¿®æ”¹
        if (DB::table("ly_admin_hongbao")->where("id", '=', $id)->update($data)){
            DB::table('ly_admin_log')->insert($log);
            DB::table("ly_admin_card")->where("id", '=', $cardid)->update($card);
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
    public function delhongbao(Request $request)
    {   
        //获取原数据
        $oldhongbao         = DB::table('ly_admin_hongbao')
                                    ->where('id', '=', $request->input('id'))
                                    ->first();
        //通过手机id获得银行卡id
        $cardid             = DB::table('ly_admin_phone')
                                    ->where('id', '=', $oldhongbao->phoneid)
                                    ->value('cardid');
        //拼接银行卡的余额
        $oldcard            = DB::table('ly_admin_card')
                                    ->where('id', '=', $cardid)
                                    ->value('money');
        $card['money']      = $oldcard + ($oldhongbao ->hmoney * $oldhongbao ->number);
        

        
        $log                = [];
        $log['remark']      = '删除了1条红包信息';
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //åˆ é™¤åˆ·å•ä»»åŠ¡è¡?
        if (DB::table("ly_admin_hongbao")->where("id","=",$request->input('id'))->delete()){
            DB::table('ly_admin_log')->insert($log);
            DB::table("ly_admin_card")->where("id", '=', $cardid)->update($card);
            echo 1;
        } else {
            echo 2;
        }
        
    }
}
