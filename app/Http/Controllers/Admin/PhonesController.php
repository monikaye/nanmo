<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Requests\PhonesInsertRequest;
class PhonesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        //获取手机编号
        $phones = DB::table('ly_admin_phone')
                        ->select('id', 'phonenum')
                        ->get();
        //获取银行卡
        $cards  = DB::table('ly_admin_card')
                        ->select('id', 'number')
                        ->get();
        
        if ($request->isMethod('post')) {
            if($request->input('bigd') || $request->input('smalld') ||$request->input('phoneid') ||$request->input('bigc') ||$request->input('smallc') ||$request->input('cardid') ||$request->input('start') ||$request->input('stop') ||$request->input('shopid')){
                $map = [];
                if($request->input('bigd')) {
                    $map[] = ['countday', '>', $request->input('bigd')];
                }
                if($request->input('smalld')) {
                    $map[] = ['countday', '<', $request->input('smalld')];
                }
                if($request->input('phoneid')) {
                    $map[] = ['phoneid', '=', $request->input('phoneid')];
                }
                if($request->input('bigc')) {
                    $map[] = ['fcard', '>', $request->input('bigc')];
                }
                if($request->input('smallc')) {
                    $map[] = ['fcard', '<', $request->input('smallc')];
                }
                if($request->input('cardid')) {
                    $map[] = ['cardid', '=', $request->input('cardid')];
                }
                
                if($request->input('start')) {
                    $map[] = ['create_time', '>=', $request->input('start')];
                }
                if($request->input('stop')) {
                    $map[] = ['create_time', '<=', $request->input('stop')];
                }
               $info = DB::table('ly_admin_phones')
                        ->select('id', 'phoneid', 'shopmark', 'cardid', 'countday', 'fcard', 'userid', 'create_time')
                        ->where($map)
                        ->orderBy('create_time',' desc')
                        ->paginate(10);
                foreach ($info as $k => $v) {
                    $phone = DB::table('ly_admin_phone')->where('id', '=', $v->phoneid)->get();
                    foreach ($phone as $value) {
                        $info[$k]->phonenum = $value->phonenum;
                        $info[$k]->pnumber  = $value->number;
                        $info[$k]->wxnumber = $value->wxnumber;
                       
                    }
                    $card = DB::table('ly_admin_card')->where('id', '=', $v->cardid)->get();
                    foreach ($card as  $values) {
                        $info[$k]->number   = $values->number;
                    }
                    
                }
                return view("Admin.Phones.index", ['info' => $info, 'phone' => $phones, 'card' => $cards, 'request' => $request->all()]);
            } else {
                $info = DB::table('ly_admin_phones')
                        ->select('id', 'phoneid', 'shopmark', 'cardid', 'countday', 'fcard', 'userid', 'create_time')
                        ->orderBy('create_time',' desc')
                        ->paginate(10);
                foreach ($info as $k => $v) {
                    $phone = DB::table('ly_admin_phone')->where('id', '=', $v->phoneid)->get();
                    foreach ($phone as $value) {
                        $info[$k]->phonenum = $value->phonenum;
                        $info[$k]->pnumber  = $value->number;
                        $info[$k]->wxnumber = $value->wxnumber;
                        
                    }
                    $card = DB::table('ly_admin_card')->where('id', '=', $v->cardid)->get();
                    foreach ($card as  $values) {
                        $info[$k]->number   = $values->number;
                    }
                   
                }
                return view("Admin.Phones.index", ['info' => $info, 'phone' => $phones, 'card' => $cards, 'request' => $request->all()]);
            }
        } else {
            $info = DB::table('ly_admin_phones')
                    ->select('id', 'phoneid', 'shopmark', 'cardid', 'countday', 'fcard', 'userid', 'create_time')
                    ->orderBy('create_time',' desc')
                    ->paginate(10);
            foreach ($info as $k => $v) {
                $phone = DB::table('ly_admin_phone')->where('id', '=', $v->phoneid)->get();
                //dd($v);
                foreach ($phone as $value) {
                    $info[$k]->phonenum = $value->phonenum;
                    $info[$k]->pnumber  = $value->number;
                    $info[$k]->wxnumber = $value->wxnumber;
                   
                     //dd($value);
                }
                $card = DB::table('ly_admin_card')->where('id', '=', $v->cardid)->get();
                // dd($v);
                foreach ($card as  $values) {
                    $info[$k]->number   = $values->number;
                }
               
            }
            // dd($info);
            return view("Admin.Phones.index", ['info' => $info, 'phone' => $phones, 'card' => $cards, 'request' => $request->all()]);
        }
        
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
        //获取手机编号
        $phone = DB::table("ly_admin_phone") -> select('phonenum','id')->orderBy('phonenum') -> get();
        
        //获取银行卡
        $card  = DB::table("ly_admin_card") -> select('cardname','id','number') ->where("status", "=", 1)-> get();
        $cards = [];
        foreach($card as $key => $value){
            $cards[$key]             = $value;
            $cards[$key]->cardnumber = $value->cardname . '-' . $value->number;
        }

        //加载添加模板
        return view("Admin.Phones.add", ['phone' => $phone, 'cards' => $cards] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 执行日常刷单任务添加
    public function store(PhonesInsertRequest $request)
    {   
        //获取要添加得数据
        $data                = $request->input();
        $data['create_time'] = time();
        $data['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //获取要修改的数据
        $infomoney['money']  = $request->input('cmoney');
        $infoid              = $request->only('cardid');
        $infophoneid         = $request->only('phoneid');
        $wxmoney             = $request->only('wxmoney');
        $wxmoneys['money']   = $wxmoney['wxmoney'];
        $log                 = [];
        $log['remark']       = '添加了1条手机信息';
        $log['create_time']  = $data['create_time'];
        $log['userid']       = $data['userid'];
        // 执行添加
        try {
            DB::table("ly_admin_phones")
                    ->insert($data);
            DB::table('ly_admin_card')
                    ->where('id',$infoid['cardid'])
                    ->update($infomoney);
            DB::table('ly_admin_phone')
                    ->where('id',$infophoneid['phoneid'])
                    ->update($wxmoneys);
            DB::table('ly_admin_log')
                    ->insert($log);
        } catch (Exception $e) {
            
            return redirect("/phones/create")->with('error',"数据添加失败");
        }
        
        return redirect("/phones")->with('success',"数据添加成功");
        

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
        //获取手机编号
        $phone = DB::table("ly_admin_phone") 
                        -> select('phonenum','id') 
                        -> get();
        
        //获取银行卡
        $card  = DB::table("ly_admin_card") 
                        -> select('cardname','id','number') 
                        -> get();
        $cards = [];
        foreach($card as $key => $value){
            $cards[$key]             = $value;
            $cards[$key]->cardnumber = $value->cardname . '-' . $value->number;
        }
        //获取当前的数据
        $info = DB::table("ly_admin_phones")
                    ->where("id","=",$id)
                    ->first();
        // var_dump($info);
        // exit;
        //展示分类修改页面
        return view("Admin.Phones.edit",["info"=>$info, 'phone' => $phone, 'cards' => $cards]);
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
        $log['remark']      = '修改了1条手机信息';
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //获取要修改得数据
        $data               = $request->except('_method');
        //执行修改
        if (DB::table("ly_admin_phones")->where("id",$id)->update($data)){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/phones")->with("success","修改成功");
        } else {
            return redirect("/phones/edit/{$id}")->with("error","修改失败");
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
        $log['remark']      = '删除了1条手机信息';
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');  
        //删除刷单任务表
        if(DB::table("ly_admin_phones")->where("id","=",$id)->delete()){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/phones")->with("success","删除成功");
        }else{
            return redirect("/phones")->with("error","删除失败");
        }
        
    }
}
