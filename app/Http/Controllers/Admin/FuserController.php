<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Requests\FuserInsertRequest;
date_default_timezone_set("Asia/Shanghai");

class FuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $count  = count(DB::table('ly_admin_fuser')
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
        $info   = DB::table('ly_admin_fuser')
                        ->offset($offset)
                        ->limit($rev)
                        ->orderBy('id',' desc')
                        ->get();
        // //获得当前年
        // $year   = date("Y",time());
        // //货的当前年月
        // $mouth  = date('Ym',time());
        // //货的当前年月日
        // $day    = date('Ymd',time());
        // //获取当月天数
        // $Mouth  = date("m",time());
        // $Mdays  = cal_days_in_month(CAL_GREGORIAN, $Mouth, $year);
        // foreach($info as $key => $value) {
        //     //计算一年总的做单量
        //     $yearsum  = count(DB::table("ly_admin_member")
        //                         ->where("shuadan_time", "like", $year.'%')
        //                         ->where("fuserid", "=", $value->id)
        //                         ->get());
        //     if($yearsum){
        //         $info[$key]->yearsum = $yearsum;
        //     }else{
        //         $info[$key]->yearsum = 0;
        //     }
        //     //计算当月的总单量
        //     $mouthsum = count(DB::table("ly_admin_member")
        //                         ->where("shuadan_time", "like", $mouth.'%')
        //                         ->where("fuserid", "=", $value->id)
        //                         ->get());
        //     if($mouthsum){
        //         $info[$key]->mouthsum = $mouthsum;
        //     }else{
        //         $info[$key]->mouthsum = 0;
        //     }
        //     //计算当日的总单量
        //     $daysum   = count(DB::table("ly_admin_member")
        //                         ->where("shuadan_time", "=", $day)
        //                         ->where("fuserid", "=", $value->id)
        //                         ->get());
        //     if($mouthsum){
        //         $info[$key]->daysum = $daysum;
        //     }else{
        //         $info[$key]->daysum = 0;
        //     }
            
        //     //获取本人一年中的做单日期
        //     $y_num   = DB::table("ly_admin_member")
        //                         ->where("shuadan_time", "like", $year.'%')
        //                         ->where("fuserid", "=", $value->id)
        //                         ->groupBy('shuadan_time')
        //                         ->get();

        //     $d = 0;
        //     //计算日进斗金的年次数
        //     foreach($y_num as $y){
        //         $d_dl = count(DB::table("ly_admin_member")
        //                         ->where("shuadan_time", "=", $y->shuadan_time)
        //                         ->where("fuserid", "=", $value->id)
        //                         ->get());
        //         if($d_dl >= 110){
        //             $d++;
        //         }
        //     }
        //     $info[$key]->yRjdj = $d;

        //     //获取本人一月中的做单日期
        //     $m_num   = DB::table("ly_admin_member")
        //                         ->where("shuadan_time", "like", $mouth.'%')
        //                         ->where("fuserid", "=", $value->id)
        //                         ->groupBy('shuadan_time')
        //                         ->get();

        //     $m = 0;
        //     //计算日进斗金的月次数
        //     foreach($m_num as $ms){
        //         $m_dl = count(DB::table("ly_admin_member")
        //                         ->where("shuadan_time", "=", $ms->shuadan_time)
        //                         ->where("fuserid", "=", $value->id)
        //                         ->get());
        //         if($m_dl >= 110){
        //             $d++;
        //         }
        //     }
        //     $info[$key]->mRjdj = $m;
        //     //当前月第一天
        //     $firstDay  = $mouth  = date('Y-m',time()).'-01';
        //     //获得第一天是星期几
        //     $firstWeek = $this->get_week($firstDay);

        //     $j_t_y_z   = 0;
        //     if($firstWeek != '1'){
        //         //获取上个月天数
        //         $prevMouth = date("m",strtotime("-1 month"));
        //         $prev_Mday = cal_days_in_month(CAL_GREGORIAN, $prevMouth, $year);
        //         //获取前一月那几天的单数
        //         $p_m_dl    = 0;
        //         for ($i = 0; $i < ($firstWeek - 1); $i++) { 
        //             $p_m_dl += count(DB::table("ly_admin_member")
        //                         ->where("shuadan_time", "=", $year.$prevMouth.($prev_Mday-$i))
        //                         ->where("fuserid", "=", $value->id)
        //                         ->get());
        //         }
        //         $n_dl   = 0;
        //         //获取上个月留在这个月的单数
        //         for ($a = 0; $a <= (7 - $firstWeek); $a ++) { 
        //             $n_dl += count(DB::table("ly_admin_member")
        //                         ->where("shuadan_time", "=", $mouth.'0'.(1 + $a))
        //                         ->where("fuserid", "=", $value->id)
        //                         ->get());
        //         }
        //         //当前月的第二周第一天日期
        //         $a += 2;
        //         $s_w_day = $mouth.$a;
        //         //第一周单量获取
        //         $f_w_dl = $p_m_dl + $n_dl;
        //         if($f_w_dl >= 600){
        //             $j_t_y_z++; 
        //         }
        //         $l = 0;
        //         //获取第二周及之后的总单量
        //         for ($d = 0; $d < 4; $d ++) { 
        //             $s_dl = 0;

        //             for ($e = 0; $e <= 6; $e ++) {
        //                 $a = $a + $l;
        //                 if($a < 10){
        //                     $a .= '0';
        //                 }
        //                 $s_dl += count(DB::table("ly_admin_member")
        //                                 ->where("shuadan_time", "=", $mouth.$a)
        //                                 ->where("fuserid", "=", $value->id)
        //                                 ->get());
        //                 $a++;
        //                 $l++;
        //             }

        //             if($s_dl >= 600){
        //                 $j_t_y_z++; 
        //             }

        //         }
        //         if($a > $Mdays){
        //             $j_t_y_z--;
        //         }
        //     }else{
        //         $k = 0;

        //         for ($i = 0; $i < 4; $i++) { 
        //             $dl = 0;
        //             for ($h = 0; $h <= 6 ; $h++) {
        //                 $o = $firstDay;
        //                 $dl += count(DB::table("ly_admin_member")
        //                                 ->where("shuadan_time", "=", $o)
        //                                 ->where("fuserid", "=", $value->id)
        //                                 ->get());
        //                 $o++;
        //             }
        //             if($dl >= 600){
        //                 $j_t_y_z++;
        //             }
        //         }


        //     }
        //     //坚挺一周完成次数
        //     $info[$key]->j_t_y_z = $j_t_y_z;
        // }
        //8、数字分页(可有可无)
        $pp     = array();
        for ($i = 1;$i <= $sums;$i++) {
            $pp[$i] = $i;
        }
        
        return view("Admin.Fuser.index", ['info' => $info, 'prev'=>$prev,'next'=>$next,'sums'=>$sums,'pp'=>$pp,'page'=>$page]);
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
        return view("Admin.Fuser.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 执行放单人添加
    public function store(FuserInsertRequest $request)
    {   
        //获取要添加得数据
        $data                = $request->input();
        $data['create_time'] = time();
        $data['userid']      = DB::table('ly_admin_user')
                                        ->where('username','=', session('username'))
                                        ->value('id');
        $log                 = [];
        $log['remark']       = '添加了1个放单人'.$request->input('username');
        $log['create_time']  = $data['create_time'];
        $log['userid']       = $data['userid'];
        // var_dump($data);exit;
        // 执行添加
        if (DB::table("ly_admin_fuser")->insert($data)) {
            DB::table('ly_admin_log')->insert($log);
            return redirect("/fuser/create")->with("success","添加成功");
        } else {
            return redirect("/fuser/create")->with("error","添加失败");
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
        $info=DB::table("ly_admin_fuser")->where("id","=",$id)->first();
        
        //展示分类修改页面
        return view("Admin.Fuser.edit",["info"=>$info]);
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
        $log['remark']      = '修改了1个放单人'.$request->input('username');
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                        ->where('username','=', session('username'))
                                        ->value('id');
        //获取要修改得数据
        $data = $request->except('_method');
        //执行修改
        if (DB::table("ly_admin_fuser")->where("id",$id)->update($data)) {
            DB::table('ly_admin_log')->insert($log);
            return redirect("/fuser/{$id}/edit")->with("success","修改成功");
        } else {
            return redirect("/fuser/{$id}/edit")->with("error","修改失败");
        }
    }

    public function finfo(Request $request)
    {   
        $count  = count(DB::table('ly_admin_salary')->where('fuserid', '=', $request->input('id'))->get());
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
        $info   = DB::table('ly_admin_salary')
                        ->where('fuserid', '=', $request->input('id'))
                        ->get();
        return view('Admin.Fuser.info',['info' => $info, 'prev'=>$prev,'next'=>$next,'sums'=>$sums,'pp'=>$pp,'page'=>$page]);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $name               = DB::table('ly_admin_fuser')
                                        ->where('id','=', $id)
                                        ->value('username');
        $log                = [];
        $log['remark']      = '删除了1个放单人'.$name;
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                        ->where('username','=', session('username'))
                                        ->value('id');
        //删除刷单任务表
        if (DB::table("ly_admin_fuser")->where("id","=",$id)->delete()){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/fuser")->with("success","删除成功");
        } else {
            return redirect("/fuser")->with("error","删除失败");
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
