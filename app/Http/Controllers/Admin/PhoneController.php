<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Requests\PhoneInsertRequest;
class PhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $info = DB::table('ly_admin_phone')
                    ->join('ly_admin_card', 'ly_admin_phone.cardid', '=', 'ly_admin_card.id')
                    ->select('ly_admin_phone.phonenum as pnum', 'ly_admin_phone.number as pnumber', 'ly_admin_phone.wxnumber', 'ly_admin_card.cardname', 'ly_admin_phone.money as pmoney', 'ly_admin_phone.create_time', 'ly_admin_card.number as cnumber', 'ly_admin_card.money as cmoney', 'ly_admin_phone.id as pid')
                    ->orderBy('ly_admin_phone.phonenum',' desc')
                    ->paginate(10);

       
        return view("Admin.Phone.index", ['info' => $info, 'request' => $request->all()]);
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
