<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Requests\AddCardInsertRequest;
date_default_timezone_set("Asia/Shanghai");
class AddCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $info = DB::table('ly_admin_addcard')
                    ->select('cardid', 'id', 'userid', 'create_time', 'addmoney')
                    ->orderBy('create_time',' desc')
                    ->get();
    	foreach ($info as $k => $v) {
    		$info[$k]->userid = DB::table('ly_admin_user')
    				                ->where('id', '=', $v->userid)
    				                ->value('username');
    		$info[$k]->cardid = DB::table('ly_admin_card')
                                    ->where('id', '=', $v->cardid)
                                    ->value('number');
            $info[$k]->create_time = date('Y-m-d H:i:s', $v->create_time);
    	}
        
        return view("Admin.AddCard.index", ['info' => $info]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //展示添加页面
    public function create()
    {   
        $card = DB::table('ly_admin_card')
                    ->select( 'id', 'number', 'cardname')
                    ->where("status", "=", 1)
                    ->orderBy('number',' desc')
                    ->get();
        foreach($card as $k => $v) {
            $card[$k]->namenumber = $v->cardname.'--' . $v->number;
        } 
        //加载添加模板
        return view("Admin.AddCard.add",['card' => $card]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 执行日常刷单任务添加
    public function addd(Request $request)
    {   
        //获取要添加得数据
        $data["addmoney"]    = $request->input("my");
        $data["cardid"]      = $request->input("id");
        $data["addtime"]     = $request->input("at");
        $data['create_time'] = time();
        $data["_token"]      = md5(time());
        $data['userid']      = DB::table('ly_admin_user')
                                    ->where('username', '=', session('username'))
                                    ->value('id');
        if($request->input('bz')) {
            $data["remark"] = $request->input('bz');
        }
        $number              = DB::table('ly_admin_card')
                                    ->where('id', '=',  $data['cardid'])
                                    ->value('number');
        $log                 = [];
        $log['remark']       = '充值银行卡:'.$number.',金额为'.$data['addmoney'];
        $log['create_time']  = $data['create_time'];
        $log['userid']       = $data['userid'];
        // var_dump($data);exit;
        // 执行添加
        if(DB::table("ly_admin_addcard")->insert($data)){
            DB::table('ly_admin_log')->insert($log);
            $card = DB::table('ly_admin_card')
                    ->select( 'id', 'number')
                    ->orderBy('number',' desc')
                    ->get();
            echo 1;
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
        $info = DB::table("ly_admin_addcard")
                        ->select('id', 'addmoney',"addtime")
                        ->where("id","=",$id)
                        ->first();
        //展示分类修改页面
        return view("Admin.AddCard.edit",["info"=>$info]);
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
        //获取要修改得数据
        $data               =  $request->except('_method');
        $cardid             =  DB::table('ly_admin_addcard')
                                    ->where('id', '=', $id)
                                    ->value('cardid');
        $number             = DB::table('ly_admin_card')
                                    ->where('id', '=', $cardid)
                                    ->value('number');
        $log                = [];
        $log['remark']      = '修改卡号为'.$number.'的充值金额为：'.$data['addmoney'];
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //执行修改
        if(DB::table("ly_admin_addcard")->where("id", "=", $id)->update($data)){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/addcard/{$id}/edit")->with("success","修改成功");
        }else{
            return redirect("/addcard/{$id}/edit")->with("error","修改失败");
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
        $addcard        = DB::table('ly_admin_addcard')
                                ->where('id','=', $id)
                                ->first();
        $num            = DB::table('ly_admin_card')
                                ->where('id', '=', $addcard->cardid)
                                ->value('number');
        $log            = [];
        $log['remark']  = '删除了1条银行卡充值记录,卡号为:'.$num.'金额为'.$addcard->addmoney;
        $log['create_time'] = time();
        $log['userid']  = DB::table('ly_admin_user')
                                ->where('username','=', session('username'))
                                ->value('id');
        //删除刷单任务表
        if(DB::table("ly_admin_addcard")->where("id","=",$id)->delete()){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/addcard")->with("success","删除成功");
        }else{
            return redirect("/addcard")->with("error","删除失败");
        }
        
    }

    //批量删除
    public function acddel(Request $request)
    {
        if($request->ajax()){
            $id             = $request->input('id');
            $addcard        = DB::table('ly_admin_addcard')
                                    ->where('id','=', $id)
                                    ->first();
            $num            = DB::table('ly_admin_card')
                                    ->where('id', '=', $addcard->cardid)
                                    ->value('number');
            $log            = [];
            $log['remark']  = '删除了1条银行卡充值记录,卡号为:'.$num.'金额为'.$addcard->addmoney;
            $log['create_time'] = time();
            $log['userid']  = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
            if(DB::table('ly_admin_addcard')->where('id','=', $id)->delete()){
                DB::table('ly_admin_log')->insert($log);            
                echo 1;
            }
        }
    }
}
