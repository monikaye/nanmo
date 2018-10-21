<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Requests\CardInsertRequest;
class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $info = DB::table('ly_admin_card')
                        ->select()
                        ->orderBy('create_time')
                        ->paginate(15);
	    foreach ($info as $k => $v) {
    		$cmoney = DB::table('ly_admin_phone')
    				        ->where('cardid', '=', $v->id)
    				        ->pluck('money');
            $phos   = DB::table('ly_admin_phone')
                            ->where('cardid', '=', $v->id)
                            ->pluck('phonenum');
            $info[$k]->count = count($phos);                            

            if(count($phos)>0){
                $info[$k]->phonenum = "";
                foreach($phos as $c){
                    $info[$k]->phonenum = $info[$k]->phonenum.",".$c;
                    $info[$k]->phonenum = ltrim($info[$k]->phonenum, ",");
                }
            }else{
                $info[$k]->phonenum = "无手机绑定";
            }

            // dd($cmoney);
    		$a      = 0;
    		foreach ($cmoney as $b) {
    			$a += $b;
    		}
    		$info[$k]->smoney = $a + $v->money;
	    }
        // dd($info);
        return view("Admin.Card.index", ['info' => $info, 'request' => $request->all()]);
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
        return view("Admin.Card.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 执行日常刷单任务添加
    public function store(CardInsertRequest $request)
    {   
        //获取要添加得数据
        $data                = $request->input();
        $data['create_time'] = time();
        $data['userid']      = DB::table('ly_admin_user')
                                    ->where('username', '=', session('username'))
                                    ->value('id');
        $data["status"]      = 1;
        $log                 = [];
        $log['remark']       = '添加了1张银行卡:'.$request->input('number');
        $log['create_time']  = $data['create_time'];
        $log['userid']       = $data['userid'];
        // var_dump($data);exit;
        // 执行添加
        if (DB::table("ly_admin_card")->insert($data)){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/card")->with("success","添加成功");
        } else {
            return redirect("/card/create")->with("error","添加失败");
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
        $info = DB::table("ly_admin_card")
                        ->where("id","=",$id)
                        ->first();
        //获取属于这个银行卡的手机编号和余额
        $pho  = DB::table("ly_admin_phone")
                        ->where("cardid","=", $info->id)
                        ->select('id', "phonenum", "money")
                        ->get();
        //展示分类修改页面
        return view("Admin.Card.edit",["info"=>$info, "pho" => $pho]);
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
        //获取要修改的手机号余额
        $pmoney             = $request->except('number',"cardname","money","_token","_method");
        // dd($pmoney);
        // dd($request->input());
        //获取要修改得数据
        $data               = $request->all('number',"cardname","money","_token");
        $log                = [];
        $log['remark']      = '修改了1张银行卡';
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        foreach($pmoney as $k => $v){
            DB::table("ly_admin_phone")
                    ->where("id", "=", $k)
                    ->update(["money"=>$v]);
        }
        // dd($data);
        //执行修改
        if (DB::table("ly_admin_card")->where("id", "=", $id)->update($data)){
            DB::table('ly_admin_log')->insert($log);
            

            return redirect("/card")->with("success","修改成功");
        } else {
            return redirect("/card/{$id}/edit")->with("error","修改失败");
        }
    }
    //修改状态
    public function stacard(Request $request)
    {   
        if($request->ajax()){
            //获取要修改得数据
            $data               = [];
            $id                 = $request->input("cid");
            $data["status"]     = $request->input("val");
            $log                = [];
            $log['remark']      = '修改了1张银行卡状态';
            $log['create_time'] = time();
            $log['userid']      = DB::table('ly_admin_user')
                                        ->where('username','=', session('username'))
                                        ->value('id');
            //执行修改
            if (DB::table("ly_admin_card")->where("id", '=',$id)->update($data)){
                DB::table('ly_admin_log')->insert($log);
                echo 1;
                
            } 
            
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
        $num                = DB::table('ly_admin_card')
                                    ->where('id','=', $id)
                                    ->value('number');
        $log                = [];
        $log['remark']      = '删除了1张银行卡,卡号为:'.$num;
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //删除刷单任务表
        if (DB::table("ly_admin_card")->where("id","=",$id)->delete()){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/card")->with("success","删除成功");
        } else {
            return redirect("/card")->with("error","删除失败");
        }
        
    }
}
