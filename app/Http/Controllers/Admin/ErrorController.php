<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Requests\ShopInsertRequest;
use Mockery\Generator\Method;

date_default_timezone_set("Asia/Shanghai");
class ErrorController extends Controller
{
        //添加错误
    public function add()
    {
        $fuser = DB::table('ly_admin_fuser')
                ->select('id','username')
                ->get();

        $user = DB::table('ly_admin_user')
            ->select('id','username')
            ->get();

       return view("Admin.Error.add" ,['fuser'=>$fuser,'user'=>$user]);
    }


    public function addto(Request $request)
    {

        $data = [];
//dd($request->input());
        $data['bcfuserid'] = $request->input('bcfuserid');
        $data['cfuserid'] = $request->input('cfuserid');
        $data['money'] = $request->input('money');
        $data['remark'] = $request->input('remark');
        $data['shuadan_time'] = $request->input('time');
        $data['create_time'] = time();
        $data['userid'] = $request->input('userid');


        if (DB::table("ly_admin_error")->insert($data)){
           echo 1;
        } else {
            echo 0;
        }
    }


    public function lists()
    {
      $data = DB::table("ly_admin_error as e")
                    ->join('ly_admin_fuser as bcf','e.bcfuserid','=','bcf.id')
                    ->join('ly_admin_fuser as cf','e.cfuserid','=','cf.id')
                    ->join('ly_admin_user as u','e.userid','=','u.id')
                    ->select('e.*','bcf.username as bcfusername','cf.username as cfusername','u.username')
                    ->get();

//      dd($data);
       return view("Admin.Error.index" ,['data'=>$data]);
    }


    public function test()
    {
       dd("this is test");
    }
}