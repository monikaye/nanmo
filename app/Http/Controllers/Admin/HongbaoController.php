<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Requests\PhoneInsertRequest;
class HongbaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $count = count(DB::table('ly_admin_hongbao as h')
                        ->join('ly_admin_phone as p', 'h.phoneid', '=', 'p.id')
                        ->select('h.*', 'p.phonenum')
                        ->get());
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

        $info   = DB::table('ly_admin_hongbao as h')
                        ->join('ly_admin_phone as p', 'h.phoneid', '=', 'p.id')
                        ->select('h.*', 'p.phonenum')
                        ->orderBy('h.create_time.phonenum',' desc')
                        ->get();
         //8、数字分页(可有可无)
        $pp     = array();
        for ($i = 1;$i <= $sums;$i++) {
            $pp[$i] = $i;
        }
       
        return view("Admin.Hongbao.index", ['info' => $info, 'prev'=>$prev,'next'=>$next,'sums'=>$sums,'pp'=>$pp,'page'=>$page]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //å±•ç¤ºæ·»åŠ é¡µé¢
    public function create()
    {   
        //èŽ·å–è¦æ·»åŠ çš„æ•°æ®é€‰é¡¹

        //èŽ·å–é“¶è¡Œå?
        $card   = DB::table("ly_admin_card")
                        ->where("status", '=', 1) 
                        -> select('cardname','id','number') 
                        -> get();
        
        $cards  = [];
        foreach($card as $key => $value){
            $cards[$key]             = $value;
            $cards[$key]->cardnumber = $value->cardname . '-' . $value->number;
        }

        //åŠ è½½æ·»åŠ æ¨¡æ¿
        return view("Admin.Phone.add", ['cards' => $cards] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // æ‰§è¡Œæ—¥å¸¸åˆ·å•ä»»åŠ¡æ·»åŠ 
    public function store(PhoneInsertRequest $request)
    {   
        //èŽ·å–è¦æ·»åŠ å¾—æ•°æ®
        $data                = $request->input();
        $data['create_time'] = time();
        $data['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        $log                 = [];
        $log['remark']       = '添加了1个手机'.$request->input('number');
        $log['create_time']  = $data['create_time'];
        $log['userid']       = $data['userid'];
        // æ‰§è¡Œæ·»åŠ 
        if (DB::table("ly_admin_phone")->insert($data)){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/phone")->with("success","添加成功");
        } else {
            return redirect("/phone/create")->with("error","添加失败");
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
        
        //èŽ·å–å½“å‰çš„æ•°æ?
        $info  = DB::table("ly_admin_phone")
                        ->where("id","=",$id)->first();
        //èŽ·å–åº—é“º
        $shop  = DB::table("ly_admin_shop") 
                        ->select('shopname','id') -> get();
        //èŽ·å–é“¶è¡Œå?
        $card  = DB::table("ly_admin_card") 
                        ->select('cardname','id','number') 
                        ->get();
        $cards = [];
        foreach($card as $key => $value){
            $cards[$key]             = $value;
            $cards[$key]->cardnumber = $value->cardname . '-' . $value->number;
        }
        //å±•ç¤ºåˆ†ç±»ä¿®æ”¹é¡µé¢
        return view("Admin.Phone.edit",["info"=>$info, 'shop' => $shop, 'cards' => $cards]);
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
        $log['remark']      = '修改了1个手机'.$request->input('username');
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        $data               = $request->except('_method');
        //æ‰§è¡Œä¿®æ”¹
        if (DB::table("ly_admin_phone")->where("id",$id)->update($data)){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/phone")->with("success","修改成功");
        } else {
            return redirect("/phone/edit/{$id}")->with("error","修改失败");
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
        $shouji             = DB::table('ly_admin_phone')
                                    ->where('id','=', $id)
                                    ->value('number');
        $log                = [];
        $log['remark']      = '删除了1个手机'.$shouji;
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //åˆ é™¤åˆ·å•ä»»åŠ¡è¡?
        if (DB::table("ly_admin_phone")->where("id","=",$id)->delete()){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/phone")->with("success","删除成功");
        } else {
            return redirect("/phone")->with("error","删除失败");
        }
        
    }
}
