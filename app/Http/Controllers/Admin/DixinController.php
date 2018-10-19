<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Requests\ShopInsertRequest;
date_default_timezone_set("Asia/Shanghai");
class DixinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adddixin()
    {   
        return view("Admin.Dixin.add");
    }
    
    public function doadddixin(Request $request)
    {
        $newdixin = $request->input('dixin');
        if(DB::table('ly_admin_dixin')->where('dixin', '=', $newdixin)->first()){
            echo 2;
            exit;
        }
        $data['dixin']       = $newdixin;
        $data['create_time'] = time();
        $data['update_time'] = 0;
        $data['userid']      = DB::table('ly_admin_user')
                                    ->where('username', '=', session('username'))
                                    ->value('id');
        $log                 = [];
        $log['remark']       = '添加了一个底薪为:'.$request->input('dixin').'元';
        $log['create_time']  = $data['create_time'];
        $log['userid']       = $data['userid'];
        if (DB::table("ly_admin_dixin")->insert($data)){
            DB::table('ly_admin_log')->insert($log);
            echo 1;
        }

    }
}
