<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
date_default_timezone_set("Asia/Shanghai");
// use App\Http\Requests\PhoneInsertRequest;
class XinziController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $count  = count(DB::table('ly_admin_fuser')->where('status', '=', 1)->get());
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
        $info   = DB::table('ly_admin_fuser')
                        ->select('id', 'username')
                        ->where('status', '=', 1)
                        ->offset($offset)
                        ->limit($rev)
                        ->get();
       
        return view("Admin.Xinzi.index", ['info' => $info, 'prev'=>$prev,'next'=>$next,'sums'=>$sums,'pp'=>$pp,'page'=>$page]);
    }
    

    public function jiesuan(Request $request)
    {   
        $id    = $request->input('id');
        $name  = DB::table('ly_admin_fuser')
                    ->where('id', '=', $id)
                    ->value('username');
        $dixin = DB::table('ly_admin_dixin')
                    ->select( 'id', 'dixin')
                    ->orderBy('dixin',' desc')
                    ->get();


        return view("Admin.Xinzi.jiesuan",['dixin' => $dixin, 'id' => $id, 'name' => $name]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    // 执行添加
    public function dojiesuan(Request $request)
    {   
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);
        //获取放单人id
        $data["fuserid"]     = $request->input('fid');
        $fuserid             = $data["fuserid"];
        //获取评测金
        $data["test"]        = $request->input('pc') != "" ? $request->input('pc') : 0;
        //获取底薪
        if($request->input('dx')){
            $data['dixin'] = DB::table('ly_admin_dixin')
                                    ->where('id', '=', $request->input('dx'))
                                    ->value('dixin');
        }else{
            $data['dixin'] = 0;
        }
        // dd($data);
        //获取上上个月的年
        $ppyear          = date('Y',strtotime("-2 month"));
        //获取上个月的年
        $pyear          = date('Y',strtotime("-1 month"));
        //获取上个月
        $prevMouth     = date("m",strtotime("-1 month"));
        //获取上个月的年月
        $prevMouthyear = date("Ym",strtotime("-1 month"));

        //这里判断该人工资是否已经结算完成了;
        if(DB::table('ly_admin_salary')->where('fuserid', '=', $fuserid)->where('js_time', '=', $prevMouthyear)->first()){
            echo 3;exit;
        }
        // dd($prevMouth);
        if($request->input('chengfa')){
            //获取罚金
            $fj = DB::table('ly_admin_error')
                        ->select(DB::raw('sum(money)'))
                        ->where('bcfuserid', '=', $fuserid)
                        ->where('shuadan_time', 'like', $prevMouthyear.'%')
                        ->value('money');
            //获取监督奖金
            $jj = DB::table('ly_admin_error')
                        ->select(DB::raw('sum(money)'))
                        ->where('cfuserid', '=', $fuserid)
                        ->where('shuadan_time', 'like', $prevMouthyear.'%')
                        ->value('money');
            $data['famoney']     = $fj ? $fj :0;
            $data['addmoney']    = $jj ? $jj :0;
        }else{
            $data['famoney']  = 0;
            $data['addmoney'] = 0;
        }
        //获取绩效
        $jx = $request->input('jx');
        // dd($jx);
        if($jx){
            //这是组员绩效
            if($jx == 1){
                $j_xiao = DB::table('ly_admin_member')
                                ->select(DB::raw('sum(jixiao)'))
                                ->where('fuserid', '=', $fuserid)
                                ->where('shuadan_time', 'like', $prevMouthyear.'%')
                                ->value('jixiao');
                $data['jixiao'] = $j_xiao;
            }
            // dd($data);
            //这是小组长绩效
            if($jx == 2){
                //获取他所有的刷单时间
                $s_time  = DB::table('ly_admin_member')
                                ->where('fuserid', '=', $fuserid)
                                ->where('shuadan_time', 'like', $prevMouthyear.'%')
                                ->groupBy('shuadan_time')
                                ->pluck('shuadan_time');

                //获取他值班小组长的时间
                $z_time  = DB::table('ly_admin_zhiban')
                                ->where('fuserid', '=', $fuserid)
                                ->where('shuadan_time', 'like', $prevMouthyear.'%')
                                ->pluck('shuadan_time');
                // dd($z_time);
                //做小组长的120江景
                $j120    = count($z_time) * 120;
                //获取小组长减半的绩效
                $b_jx    = [];
                $cou     = 0;
                foreach($z_time as $zt){
                    //做组长时的绩效
                    $_jx = DB::table('ly_admin_member')
                                ->select(DB::raw('sum(jixiao)'))
                                ->where('fuserid', '=', $fuserid)
                                ->where('shuadan_time', '=', $zt)
                                ->value('jixiao');
                    $b_jx[] = $_jx / 2;
                    $z_jx   = array_sum($b_jx);
                    //做组长时的绩效加成
                    $cou += count(DB::table('ly_admin_member')->where('shuadan_time', '=', $zt)->get());

                }
                $cou   = $cou * 0.2;
                //获取他不做小组长的时间
                foreach ($z_time as $k => $v) {
                    foreach ($s_time as $key => $value) {
                        if($v == $value){
                            unset($s_time[$key]);
                        }
                    }
                }
                //通过不做小组长的时间算出绩效
                $j_xiao = 0;
                foreach ($s_time as $val) {
                    $j_xiao += DB::table('ly_admin_member')
                                ->select(DB::raw('sum(jixiao)'))
                                ->where('fuserid', '=', $fuserid)
                                ->where('shuadan_time', '=', $val)
                                ->value('jixiao');
                }
                // dd($b_jx);
                //算出总绩效
                $data['jixiao'] = $j_xiao + $cou + $z_jx + $j120;
               // dd($data);
            }
            //这是大组长绩效
            if($jx == 3){
                $j_xiao = DB::table('ly_admin_member')
                                ->select(DB::raw('count(jixiao) as sjx'))
                                ->where('shuadan_time', 'like', $prevMouthyear.'%')
                                ->value('id');
                $data['jixiao'] = $j_xiao * 0.1;
                 // dd($data);
            }
        }else{
            $data['jixiao'] = 0;
        }
        // dd($jx);
        //计算成就
        if($jx == 3 || $jx == ""){
            $data['a_vement'] = 0;
        }else{
            //计算上月日进斗金次数
            $rjdj = 0;
                //获取这个人上月的做单日期
                $m_num   = DB::table("ly_admin_member")
                                ->select('shuadan_time')
                                ->where("shuadan_time", "like", $prevMouthyear.'%')
                                ->where("fuserid", "=", $fuserid)
                                ->groupBy('shuadan_time')
                                ->get();
                // dd($m_num);
                //通过日期获取每日做单量
                foreach ($m_num as $va) {
                    $rzd = count(DB::table('ly_admin_member')->where('shuadan_time', '=', $va->shuadan_time)->where('fuserid', '=', $fuserid)->get());
                    if($rzd >= 110){
                        $rjdj++;
                    }
                }
            // dd($rjdj);
            //计算上月坚挺一周次数
            $j_t_y_z     = 0;
            //获取上上个月
            $p_prevMouth = date("m",strtotime("-2 month"));
            //上个月第一天
            $firstDay    =  $prevMouthyear.'01';
            //获得第一天是星期几
            $firstWeek   = $this->get_week($firstDay);
            //获取上个月天数
            $p_day       = cal_days_in_month(CAL_GREGORIAN, $prevMouth, $pyear);
            if($firstWeek != 1){
                //获取上上个月天数
                $prev_Mday = cal_days_in_month(CAL_GREGORIAN, $p_prevMouth, $ppyear);
                //获取上上月那几天的单数
                $p_m_dl    = 0;
                for ($i = 0; $i < ($firstWeek - 1); $i++) { 
                    $p_m_dl += count(DB::table("ly_admin_member")
                                ->where("shuadan_time", "=", $ppyear.$p_prevMouth.($prev_Mday-$i))
                                ->where("fuserid", "=", $fuserid)
                                ->get());
                }
                //获取上上个月留在上个月的单数
                $n_dl   = 0;
                for ($a = 0; $a <= (7 - $firstWeek); $a ++) { 
                    $n_dl += count(DB::table("ly_admin_member")
                                ->where("shuadan_time", "=", $prevMouthyear.'0'.(1 + $a))
                                ->where("fuserid", "=", $fuserid)
                                ->get());
                }
                // dd($a);
                //第一周单量获取
                $f_w_dl  = $p_m_dl + $n_dl;
                if($f_w_dl >= 600){
                    $j_t_y_z++; 
                }
                //上个月的第二周第一天的前一天日期
                $s_w_day = $prevMouthyear.'0'.$a;
                
                //计算还能凑几个星期
                $xingqi  = floor(($p_day - $a)/7);
                $kk = 1;
                for ($op = 0; $op < $xingqi; $op++) { 
                    $s_dl = 0;
                    for ($lo = 0; $lo <= 6; $lo++) { 
                        $s_dl += count(DB::table("ly_admin_member")
                                        ->where("shuadan_time", "=", $s_w_day + $kk)
                                        ->where("fuserid", "=", $fuserid)
                                        ->get());

                        $kk ++;
                    }
                    if($s_dl >= 600){
                        $j_t_y_z++;
                    }

                }
            }else{
                //计算能凑几个星期
                $xingqi  = floor($p_day/7);
                for ($i = 0; $i < $xingqi; $i++) { 
                    $dl = 0;
                    for ($h = 0; $h <= 6 ; $h++) {
                        $o = $firstDay;
                        $dl += count(DB::table("ly_admin_member")
                                        ->where("shuadan_time", "=", $o)
                                        ->where("fuserid", "=", $fuserid)
                                        ->get());
                        $o++;
                    }
                    if($dl >= 600){
                        $j_t_y_z++;
                    }
                }
            }
            //上月是否为放单达人
                $ydl = count(DB::table('ly_admin_member')
                                    ->where('shuadan_time', '=', $prevMouthyear)
                                    ->where('fuserid', '=', $fuserid)
                                    ->get());
                $f_d_d_r = 0;
                if($ydl / $p_day >= 80){
                    $f_d_d_r = 1;
                }

            //初生牛犊
            //青出于蓝
                //判断并获取该人是否为新人
                $ct = DB::table('ly_admin_fuser')
                            ->where('id', '=', $fuserid)
                            ->value('work_time');
                // $tt = date('Ymd', $ct);
                $ui = [];
                //30天内
                for ($r = 1; $r <= 30; $r ++) { 
                    $ui[]   = date('Ymd',strtotime($ct) + ($r * 24 * 3600));

                }
                //按照入职日期分成就时间状态
                //1.新人是刚好在一号入职的,
                $csnd = 0;
                $qcyl = 0;
                if(substr($ct, 6, 2) == '01'){
                    //代表是一号入职
                    if(substr($ct, 4, 2) == $prevMouth){
                        foreach ($ui as $w) {
                            if(count(DB::table('ly_admin_member')->where('shuadan_time', '=', $w)->where('fuserid', '=', $fuserid)->get()) >= 60){
                                $csnd++;
                                echo count(DB::table('ly_admin_member')->where('shuadan_time', '=', $w)->where('fuserid', '=', $fuserid)->get());
                                break;
                            }
                        }
                        //判断是否获取新人成就
                        if($j_t_y_z > 0 || $rjdj > 0 || $f_d_d_r > 0){
                            $qcyl++;
                        }
                    }
                }else{
                    //代表是其他时间入职
                    if(substr($ct, 4, 2) == $p_prevMouth){
                        foreach ($ui as $wk) {
                            if(count(DB::table('ly_admin_member')->where('shuadan_time', '=', $wk)->where('fuserid', '=', $fuserid)->get()) >= 60){
                                $csnd++;
                                break;
                            }
                        }
                        //判断是否获取新人成就
                        if($j_t_y_z > 0 || $rjdj > 0 || $f_d_d_r > 0){
                            $qcyl++;
                        }
                    }

                }

                $data['a_vement'] = ($rjdj * 30) + ($j_t_y_z * 100) + ($f_d_d_r * 300) + ($csnd * 200) + ($qcyl * 200);
                //把每月完成的成就存起来
                if($redis->get($fuserid)){
                    $chengjiu = json_decode($redis->get($fuserid), true);
                    // dd($chengjiu);
                }else{
                    $chengjiu = [];
                }
                $chengjiu[$prevMouthyear]['rjdj'] = $rjdj;
                $chengjiu[$prevMouthyear]['j_t_y_z'] = $j_t_y_z;
                $chengjiu[$prevMouthyear]['f_d_d_r'] = $f_d_d_r;
                $chengjiu[$prevMouthyear]['csnd'] = $csnd;
                $chengjiu[$prevMouthyear]['qcyl'] = $qcyl;
                $chengjiu = json_encode($chengjiu);
                $redis->set($fuserid, $chengjiu);
        }
        $redis->close();
        $data['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        $data['create_time'] = time();
        $data['js_time']     = $prevMouthyear;

        $log                 = [];
        $log['remark']       = '结算1条工资';
        $log['create_time']  = $data['create_time'];
        $log['userid']       = $data['userid'];
        // dd($data);
        // æ‰§è¡Œæ·»åŠ 
        if (DB::table("ly_admin_salary")->insert($data)){
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
    public function jiesuaninfo(Request $request)
    {   
        $count  = count(DB::table("ly_admin_salary")->get());
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

        $info   = DB::table("ly_admin_salary as s")
                        ->join('ly_admin_fuser as f', 's.fuserid', '=', 'f.id')
                        ->join('ly_admin_user as u', 's.userid', '=', 'u.id')
                        ->select('s.*', 'f.username as fname', 'u.username as uname')
                        ->offset($offset)
                        ->limit($rev)
                        ->orderBy('s.js_time', 'desc')
                        ->get();
        return view("Admin.Xinzi.info",["info" => $info, 'prev'=>$prev,'next'=>$next,'sums'=>$sums,'pp'=>$pp,'page'=>$page]);
    }
    //删除
    public function jiesuandel(Request $request)
    {   
        
        $log                = [];
        $log['remark']      = '删除了1条工资结算信息';
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //åˆ é™¤åˆ·å•ä»»åŠ¡è¡?
        if (DB::table("ly_admin_salary")->where("id","=",$request->input('id'))->delete()){
            DB::table('ly_admin_log')->insert($log);
            echo 1;
        } else {
            echo 2;
        }
        
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

    public function  get_week($date){
        //强制转换日期格式
        $date_str=date('Y-m-d',strtotime($date));
    
        //封装成数组
        $arr=explode("-", $date_str);
         
        //参数赋值
        //年
        $year=$arr[0];
         
        //月，输出2位整型，不够2位右对齐
        $month=sprintf('%02d',$arr[1]);
         
        //日，输出2位整型，不够2位右对齐
        $day=sprintf('%02d',$arr[2]);
         
        //时分秒默认赋值为0；
        $hour = $minute = $second = 0;   
         
        //转换成时间戳
        $strap = mktime($hour,$minute,$second,$month,$day,$year);
         
        //获取数字型星期几
        $number_wk=date("w",$strap);
         
        //自定义星期数组
        $weekArr=array("7","1","2","3","4","5","6");
         
        //获取数字对应的星期
        return $weekArr[$number_wk];
    }
}
