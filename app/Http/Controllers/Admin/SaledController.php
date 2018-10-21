<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Requests\SaledInsertRequest;
use PHPExcel;
use PHPExcel_Writer_Excel2007;
use IOFactory;
use PHPExcel_Cell;
date_default_timezone_set("Asia/Shanghai");
class SaledController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   

        // if($request->isMethod("post")){
        //     dd($request->input());
        // }
        $map = [];
        if($request->input("wxname")){
            $map[1] = ["sa.wxname" ,'=', $request->input("wxname")];
            session(['wxname'=>$request->input('wxname')]);
        }else{
            $request->session()->forget('wxname');
        }
        if($request->input("fbig")){
            $map[2] = ["sa.fmoney" ,'>=', $request->input("fbig")];
            session(['fbig'=>$request->input('fbig')]);
        }else{
            $request->session()->forget('fbig');
        }
        if($request->input("fsmall")){
            $map[3] = ["sa.fmoney" ,'<=', $request->input("fsmall")];
            session(['fsmall'=>$request->input('fsmall')]);
        }else{
            $request->session()->forget('fsmall');
        }
        if($request->input("phoneid")){
            $map[4] = ["sa.phoneid" ,'=', $request->input("phoneid")];
            session(['pid'=>$request->input('phoneid')]);
        }else{
            $request->session()->forget('pid');
        }
        if($request->input("fphone")){
            $map[5] = ["sa.fphone" ,'=', $request->input("fphone")];
            session(['fpid'=>$request->input('fphone')]);
        }else{
            $request->session()->forget('fpid');
        }
        if($request->input("wname")){
            $map[6] = ["sa.wwname" ,'=', $request->input("wname")];
            session(['wname'=>$request->input('wname')]);
        }else{
            $request->session()->forget('wname');
        }
        if($request->input("sbig")){
            $map[7] = ["sa.smoney" ,'>=', $request->input("sbig")];
            session(['sbig'=>$request->input('sbig')]);
        }else{
            $request->session()->forget('sbig');
        }
        if($request->input("ssmall")){
            $map[8] = ["sa.smoney" ,'<=', $request->input("ssmall")];
            session(['ssmall'=>$request->input('ssmall')]);
        }else{
            $request->session()->forget('ssmall');
        }
        if($request->input("fuserid")){
            $map[9] = ["sa.fuserid" ,'=', $request->input("fuserid")];
            session(['fud'=>$request->input('ssmall')]);
        }else{
            $request->session()->forget('fud');
        }
        if($request->input("result")){
            $map[10] = ["sa.result" ,'=', $request->input("result")];
            session(['result'=>$request->input('result')]);
        }else{
            $request->session()->forget('result');
        }
        if($request->input("orders")){
            $map[11] = ["sa.orders" ,'=', $request->input("orders")];
            session(['ods'=>$request->input('orders')]);
        }else{
            $request->session()->forget('ods');
        }
        if($request->input("hbig")){
            $map[12] = ["sa.hap_time" ,'>=', $request->input("hbig")];
            session(['hbig'=>$request->input('hbig')]);
        }else{
            $request->session()->forget('hbig');
        }
        if($request->input("hsmall")){
            $map[13] = ["sa.hap_time" ,'<=', $request->input("hsmall")];
            session(['hsmall'=>$request->input('hsmall')]);
        }else{
            $request->session()->forget('hsmall');
        }
        if($request->input("huohao")){
            $map[14] = ["sa.huohaoid" ,'=', $request->input("huohao")];
            session(['hh'=>$request->input('huohao')]);
        }else{
            $request->session()->forget('hh');
        }
        if($request->input("shopid")){
            $map[15] = ["sa.shopid" ,'=', $request->input("shopid")];
            session(['shp'=>$request->input('shopid')]);
        }else{
            $request->session()->forget('shp');
        }


        //获取全部商店
        $shop   = DB::table('ly_admin_shop')
                    ->select('shopname','id')
                    ->orderBy('id',"shopname")
                    ->get();
        // dd($shop);
        //获取全部刷单人
        $fuser  = DB::table('ly_admin_fuser')
                    ->where('status', '=', 1)
                    ->select('id as fid', 'username as fname')
                    ->orderBy('username')
                    ->get();
        //获取全部货号
        $huohao = DB::table('ly_admin_huohao')
                    ->select('id', 'huohao')
                    ->orderBy('huohao')
                    ->get();
        //获取手机编号
        $phone  = DB::table('ly_admin_phone')
                    ->select('id', 'phonenum')
                    ->orderBy('phonenum')
                    ->get();
        $count  = count(DB::table('ly_admin_saled as sa')
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

        $info = DB::table('ly_admin_saled as sa')
                        ->leftjoin('ly_admin_shop as sh',  'sa.shopid', '=' , 'sh.id')
                        ->leftjoin('ly_admin_phone as p',  'sa.phoneid', '=' , 'p.id')
                        ->leftjoin('ly_admin_fuser as f',  'sa.fuserid', '=', 'f.id')
                        ->leftjoin('ly_admin_huohao as h',  'sa.huohaoid', '=', 'h.id')
                        ->leftjoin('ly_admin_phone as fp',  'sa.fphone', '=' , 'fp.id')
                        ->leftjoin('ly_admin_user as u',  'sa.userid', '=', 'u.id')
                        ->select('sa.wxname', 'sa.why', 'sa.result', 'sa.smoney', 'p.phonenum', 'sh.shopname', 'f.username', 'sa.create_time', 'sa.id', 'h.huohao',"sa.wwname","sa.fmoney","sa.orders","fp.phonenum as fphone","sa.over_time","sa.userid","sa.hap_time","u.username as uname")
                        ->where($map)
                        ->offset($offset)
                        ->limit($rev)
                        ->orderBy('sa.create_time',' desc')
                        ->get();
        //8、数字分页(可有可无)
        $pp     = array();
        for ($i = 1;$i <= $sums;$i++) {
            $pp[$i] = $i;
        }
        // var_dump($info);
        // exit;
        return view("Admin.Saled.index", ['info' => $info, 'shop' => $shop, 'fuser' => $fuser, 'huohao' => $huohao, 'phone' => $phone, "map" => $map,'prev'=>$prev,'next'=>$next,'sums'=>$sums,'pp'=>$pp,'page'=>$page]);
    }
    
    public function page_pro_saled(Request $request)
    {   

        // if($request->isMethod("post")){
        //     dd($request->input());
        // }
        $map = [];
        if(session('wxname')) {
            $map[] = ['sa.wxname', '=', session('wxname')];
        }
        if(session('fbig')) {
            $map[] = ['sa.fmoney', '>=', session('fbig')];
        }

        if(session('fsmall')) {
            $map[] = ['sa.fmoney', '<=', session('fsmall')];
        }

        if(session('pid')) {
            $map[] = ['sa.phoneid', '=', session('pid')];
        }
        
        if(session('fpid')) {
            $map[] = ['sa.fphone', '=', session('fpid')];
        }
        
        if(session('wname')) {
            $map[] = ['sa.wwname', '=', session('wname')];
        }

        if(session('sbig')) {
            $map[] = ['sa.smoney', '>=', session('sbig')];
        }

        if(session('ssmall')) {
            $map[] = ['sa.smoney', '<=', session('ssmall')];
        }
        
        if(session('fud')) {
            $map[] = ['sa.fuserid', '=', session('fud')];
        }

        if(session('result')) {
            $map[] = ['sa.result', '=', session('result')];
        }
        
        if(session('ods')) {
            $map[] = ['sa.orders', '=', session('ods')];
        }

        if(session('hbig')) {
            $map[] = ['sa.hap_time', '>=', session('hbig')];
        }

        if(session('hsmall')) {
            $map[] = ['sa.hap_time', '<=', session('hsmall')];
        }

        if(session('hh')) {
            $map[] = ['sa.huohaoid', '=', session('hh')];
        }

        if(session('shp')) {
            $map[] = ['sa.shopid', '=', session('shp')];
        }


        //获取全部商店
        $shop   = DB::table('ly_admin_shop')
                    ->select('shopname','id')
                    ->orderBy('id',"shopname")
                    ->get();
        // dd($shop);
        //获取全部刷单人
        $fuser  = DB::table('ly_admin_fuser')
                    ->where('status', '=', 1)
                    ->select('id as fid', 'username as fname')
                    ->orderBy('username')
                    ->get();
        //获取全部货号
        $huohao = DB::table('ly_admin_huohao')
                    ->select('id', 'huohao')
                    ->orderBy('huohao')
                    ->get();
        //获取手机编号
        $phone  = DB::table('ly_admin_phone')
                    ->select('id', 'phonenum')
                    ->orderBy('phonenum')
                    ->get();
        $count  = count(DB::table('ly_admin_saled as sa')
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

        $info = DB::table('ly_admin_saled as sa')
                        ->leftjoin('ly_admin_shop as sh',  'sa.shopid', '=' , 'sh.id')
                        ->leftjoin('ly_admin_phone as p',  'sa.phoneid', '=' , 'p.id')
                        ->leftjoin('ly_admin_fuser as f',  'sa.fuserid', '=', 'f.id')
                        ->leftjoin('ly_admin_huohao as h',  'sa.huohaoid', '=', 'h.id')
                        ->leftjoin('ly_admin_phone as fp',  'sa.fphone', '=' , 'fp.id')
                        ->leftjoin('ly_admin_user as u',  'sa.userid', '=', 'u.id')
                        ->select('sa.wxname', 'sa.why', 'sa.result', 'sa.smoney', 'p.phonenum', 'sh.shopname', 'f.username', 'sa.create_time', 'sa.id', 'h.huohao',"sa.wwname","fp.phonenum as fphone","sa.orders","sa.fmoney","sa.over_time","sa.userid","sa.hap_time","u.username as uname")
                        ->where($map)
                        ->offset($offset)
                        ->limit($rev)
                        ->orderBy('sa.create_time',' desc')
                        ->get();
        //8、数字分页(可有可无)
        $pp     = array();
        for ($i = 1;$i <= $sums;$i++) {
            $pp[$i] = $i;
        }
        // var_dump($info);
        // exit;
        return view("Admin.Saled.page", ['info' => $info, 'shop' => $shop, 'fuser' => $fuser, 'huohao' => $huohao, 'phone' => $phone,'prev'=>$prev,'next'=>$next,'sums'=>$sums,'pp'=>$pp,'page'=>$page]);
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
        $shop  = DB::table("ly_admin_shop") 
                        -> select('shopname','id') 
                        -> get();
        //获取货号
        $huohao  = DB::table("ly_admin_huohao") 
                        -> select('huohao','id') 
                        -> get();
        //获取手机
        $phone = DB::table("ly_admin_phone") 
                        -> select('phonenum','id') 
                        -> orderBy("phonenum", "desc")
                        -> get();
        //获取放单人
        $fuser = DB::table("ly_admin_fuser") 
                        -> select('username','id') 
                        -> get();
        //加载添加模板
        return view("Admin.Saled.add", ['shop' => $shop, "huohao" => $huohao, 'phone' => $phone, 'fuser' => $fuser]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 执行日常刷单任务添加
    public function saledadd(SaledInsertRequest $request)
    {   
        //获取要添加得数据
        // dd($request->input());
        $data['userid']     = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        $data["wxname"]     = $request->input('wxname')?$request->input('wxname'):"无";
        $data["wwname"]     = $request->input('wwname')?$request->input('wwname'):"无";
        $data["shopid"]     = $request->input('shopid')?$request->input('shopid'):"0";
        $data["phoneid"]    = $request->input('phoneid');
        $data["huohaoid"]   = $request->input('huohaoid')?$request->input('huohaoid'):"0";
        $data["hap_time"]   = $request->input('hap_time');
        $data["fuserid"]    = $request->input('fuserid');
        $data["fmoney"]     = $request->input('fmoney')?$request->input('fmoney'):"0";
        $data["orders"]     = $request->input('orders')?$request->input('orders'):"无";
        $data["fphone"]     = $request->input('fphone');
        $data["why"]        = $request->input('why');
        $data["result"]     = $request->input('result');
        $data["smoney"]     = $request->input('smoney');
        $data["over_time"]  = $request->input('over_time')?$request->input('over_time'):"";
        $data["_token"]     = $request->input("_token");
        $data['create_time']= time();
        $log                = [];
        $log['remark']      = '添加了1条售后信息';
        $log['create_time'] = $data['create_time'];
        $log['userid']      = $data['userid'];
        // var_dump($data);
        // exit;
        // 执行添加
        if (DB::table("ly_admin_saled")->insert($data)){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/saled")->with("success","添加成功");
        } else {
            return redirect("/saled/create")->with("error","添加失败");
        }

    }

    //试用转售后
    public function m_saled(Request $request)
    {
        if($request->ajax()){
            //获取试单信息
            $membid = $request->input("membid");
            $info   = DB::table("ly_admin_member")
                            ->where("id", "=", $membid)
                            ->first();
            $data["wxname"]         = $info->username;
            $data["phoneid"]        = $info->phoneid;
            $data["wwname"]         = $info->wwname;
            $data["shopid"]         = $info->shopid;
            $data["huohaoid"]       = $info->huohao;
            $data["hap_time"]       = $info->shuadan_time;
            $data["fuserid"]        = $info->fuserid;
            $data["fmoney"]         = $info->fmoney;
            $data["orders"]         = $info->orders;
            $data["_token"]         = $info->_token;
            $data['userid']         = DB::table('ly_admin_user')
                                            ->where('username','=', session('username'))
                                            ->value('id');
            $data["create_time"]    = time();

            $adds                   = DB::table("ly_admin_saled")
                                            ->insert($data);
            $log                = [];
            $log['remark']      = '转入1条售后信息';
            $log['create_time'] = time();
            $log['userid']      = DB::table('ly_admin_user')
                                        ->where('username','=', session('username'))
                                        ->value('id');
            if($adds){
                DB::table('ly_admin_log')->insert($log);
                echo 1;
            }

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
        $info   = DB::table("ly_admin_saled")
                        ->where("id","=",$id)
                        ->first();
        //获取店铺
        $shop   = DB::table("ly_admin_shop") 
                        ->select('shopname')
                        ->where("id", "=", $info->shopid) 
                        ->first();
        //获取手机
        $phone  = DB::table("ly_admin_phone") 
                        ->select('phonenum','id')
                        ->orderBy("phonenum")
                        ->get();
        //货号
        $huohao = DB::table("ly_admin_huohao")
                        ->select("huohao")
                        ->where("id","=", $info->huohaoid)
                        ->first();
        //获取放单人
        $fuser  = DB::table("ly_admin_fuser") 
                        ->select('username')
                        ->where("id","=", $info->fuserid) 
                        ->first();
        //展示分类修改页面
        return view("Admin.Saled.edit",["info"=>$info, 'shop' => $shop, 'phone' => $phone, 'fuser' => $fuser, "huohao" => $huohao]);
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
        $data = [];
        // dd($request->input());


        //开始判断获取要修改的信息
        if($request->input("fphone")!= null) {
            $data["fphone"] = $request->input("fphone");
        }
        if($request->input("why")!= null) {
            $data["why"] = $request->input("why");
        }
        if($request->input("result")!= null) {
            $data["result"] = $request->input("result");
        }
        if($request->input("smoney")!= null) {
            $data["smoney"] = $request->input("smoney");
        }
        if($request->input("over_time")!= null) {
            $data["over_time"] = $request->input("over_time");
        }
        if($request->input("oldmoney")){
            $oldmoney = $request->input("oldmoney");
        }else{
            $oldmoney = 0;
        }

        $cardid   = DB::table('ly_admin_phone')
                        ->where("id", "=", $data["fphone"])
                        ->value("cardid");
        $oldsum   = DB::table("ly_admin_card")
                            ->where("id", "=", $cardid)
                            ->value("money");
        $money    = $oldmoney + $oldsum - $data["smoney"];
        $card["money"] = $money;

        $log                = [];
        $log['remark']      = '修改了1条售后信息';
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //获取要修改得数据
        //执行修改
        if (DB::table("ly_admin_saled")->where("id", "=",$id)->update($data)){
            DB::table("ly_admin_card")->where("id", "=",$cardid)->update($card);
            DB::table('ly_admin_log')->insert($log);
            return redirect("/saled/{$id}/edit")->with("success","修改成功");
        } else {
            return redirect("/saled/{$id}/edit")->with("error","修改失败");
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
        $log                = [];
        $log['remark']      = '删除了1个售后信息';
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //获取当前的数据
        $info   = DB::table("ly_admin_saled")
                        ->where("id","=",$id)
                        ->first();
        //获取原赔偿金额
        if($info->smoney != ""){
            $smoney = $info->smoney;
        }else{
            $smoney = 0;
        }
        if($info->fphone != ""){
            $cardid = DB::table("ly_admin_phone")
                            ->where("id","=",$info->fphone)
                            ->value("cardid");
            $cmoney = DB::table("ly_admin_card")
                            ->where("id","=",$cardid)
                            ->value("money");
            $nmoney = $smoney + $cmoney;
            $card["money"] = $nmoney;
        }else{
            $cardid = null;
        }



        //删除刷单任务表
        if (DB::table("ly_admin_saled")->where("id","=",$id)->delete()){
            if($cardid){
                DB::table('ly_admin_card')->where("id","=",$cardid)->update($card);
            }

            DB::table('ly_admin_log')->insert($log);
            return redirect("/saled")->with("success","删除成功");
        } else {
            return redirect("/saled")->with("error","删除失败");
        }
        
    }

    public function saled_daochu(){
        //获取全部商店
        $shop   = DB::table('ly_admin_shop')
                    ->select('shopname','id')
                    ->get();
        //获取全部刷单人
        $fuser  = DB::table('ly_admin_fuser')
                    ->where('status', '=', 1)
                    ->select('id as fid', 'username as fname')
                    ->get();
        //获取全部货号
        $huohao = DB::table('ly_admin_huohao')
                    ->select('id', 'huohao')
                    ->get();
        //获取手机编号
        $phone  = DB::table('ly_admin_phone')
                    ->select('id', 'phonenum')
                    ->get();
        return view("Admin.Saled.daochu",[ 'shop' => $shop, 'fuser' => $fuser, 'huohao' => $huohao, 'phone' => $phone]);
    }


    //售后导出
    public function dosaled_daochu(Request $request)
    {   
        // echo 1;exit;
        $map  = [];
        if($request->input("wxname")){
            $map[1] = ["sa.wxname" ,'=', $request->input("wxname")];
        }
        if($request->input("fbig")){
            $map[2] = ["sa.fmoney" ,'>=', $request->input("fbig")];
        }
        if($request->input("fsmall")){
            $map[3] = ["sa.fmoney" ,'<=', $request->input("fsmall")];
        }
        if($request->input("phoneid")){
            $map[4] = ["sa.phoneid" ,'=', $request->input("phoneid")];
        }
        if($request->input("fphone")){
            $map[5] = ["sa.fphone" ,'=', $request->input("fphone")];
        }
        if($request->input("wname")){
            $map[6] = ["sa.wwname" ,'=', $request->input("wname")];
        }
        if($request->input("sbig")){
            $map[7] = ["sa.smoney" ,'>=', $request->input("sbig")];
        }
        if($request->input("ssmall")){
            $map[8] = ["sa.smoney" ,'<=', $request->input("ssmall")];
        }
        if($request->input("fuserid")){
            $map[9] = ["sa.fuserid" ,'=', $request->input("fuserid")];
        }
        if($request->input("result")){
            $map[10] = ["sa.result" ,'=', $request->input("result")];
        }
        if($request->input("orders")){
            $map[11] = ["sa.orders" ,'=', $request->input("orders")];
        }
        if($request->input("hbig")){
            $map[12] = ["sa.hap_time" ,'>=', $request->input("hbig")];
        }
        if($request->input("hsmall")){
            $map[13] = ["sa.hap_time" ,'<=', $request->input("hsmall")];
        }
        if($request->input("huohao")){
            $map[14] = ["sa.huohaoid" ,'=', $request->input("huohao")];
        }
        if($request->input("shopid")){
            $map[15] = ["sa.shopid" ,'=', $request->input("shopid")];
        }

        $list = DB::table('ly_admin_saled as sa')
                        ->leftjoin('ly_admin_shop as sh',  'sa.shopid', '=' , 'sh.id')
                        ->leftjoin('ly_admin_phone as p',  'sa.phoneid', '=' , 'p.id')
                        ->leftjoin('ly_admin_phone as fp',  'sa.fphone', '=' , 'fp.id')
                        ->leftjoin('ly_admin_fuser as f',  'sa.fuserid', '=', 'f.id')
                        ->leftjoin('ly_admin_huohao as h',  'sa.huohaoid', '=', 'h.id')
                        ->leftjoin('ly_admin_user as u',  'sa.userid', '=', 'u.id')
                        ->select('sa.wxname', 'p.phonenum', "sa.wwname", 'sh.shopname', 'h.huohao', "sa.hap_time", 'f.username', "sa.fmoney", "sa.orders", "fp.phonenum as fphone", 'sa.why', 'sa.result', 'sa.smoney', "sa.over_time", "u.username as uname")
                        ->where($map)
                        ->orderBy('sa.hap_time',' desc')
                        ->get();
        $fields    = [];
        $fields[0] = "wxname";
        $fields[1] = "phonenum";
        $fields[2] = "wwname";
        $fields[3] = "shopname";
        $fields[4] = "huohao";
        $fields[5] = "hap_time";
        $fields[6] = "username";
        $fields[7] = "fmoney";
        $fields[8] = "orders";
        $fields[9] = "fphone";
        $fields[10] = "why";
        $fields[11] = "result";
        $fields[12] = "smoney";
        $fields[13] = "over_time";
        $fields[14] = "uname";
        $filename = "售后";
        ob_end_clean();
        // if(!is_array($fields)) return false;
        $header_arr  = array('A','B','C','D','E','F','G','H','I','J','K','L','M', 'N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $objPHPExcel = new PHPExcel();
        $objWriter   = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $filename    = $filename.'.xlsx';
        $objActSheet = $objPHPExcel->getActiveSheet();
        $startRow    = 1;
        foreach ($list as $row) {
            // dd($row);exit;
            foreach ($fields as $key => $value) {
                // var_dump($value);
                // exit;
                $vs  = '';
                if($startRow == 1) {
                    if ($value == 'wxname') {
                            $vs = '微信备注名';
                    }
                    if ($value == 'phonenum') {
                            $vs = '所在手机编号';
                    }
                    if ($value == 'wwname') {
                            $vs = '旺旺号';
                    }
                    if ($value == 'shopname') {
                            $vs = '店铺名';
                    }
                    if ($value == 'huohao') {
                            $vs = '货号';
                    }
                    if ($value == 'hap_time') {
                            $vs = '发生日期';
                    }
                    if ($value == 'username') {
                            $vs = '放单人';
                    }
                    if ($value == 'fmoney') {
                            $vs = '本金';
                    }
                    if ($value == 'orders') {
                            $vs = '订单';
                    }
                    if ($value == 'fphone') {
                            $vs = '付款手机';
                    }
                    if ($value == 'why') {
                            $vs = '原因';
                    }
                    if ($value == 'result') {
                            $vs = '结果';
                    }
                    if ($value == 'smoney') {
                            $vs = '赔偿金额';
                    }
                    if ($value == 'over_time') {
                            $vs = '完结日期';
                    }
                    if ($value == 'uname') {
                            $vs = '处理人';
                    }
                    $objActSheet->setCellValue($header_arr[$key].$startRow, $vs);
                    // $startRow +=1;
                }
                if($value == 'orders') {
                        $row->$value .= ' ';
                }
                if($value == 'result') {
                    if($row->$value == 1){
                        $row->$value = "处理成功";
                    }else if($row->$value == 2){
                        $row->$value = "处理中";
                    }else if($row->$value == 3){
                        $row->$value = "处理失败";
                    }
                }
                $objActSheet->setCellValue($header_arr[$key].($startRow+1), $row->$value);
                // var_dump($header_arr[$key]);
            }
            $startRow++;

        }

        // exit;
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename='.$filename.'');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');    

    }

}
