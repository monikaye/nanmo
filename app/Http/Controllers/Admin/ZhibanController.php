<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use App\Http\Requests\UserInsertRequest;
class ZhibanController extends Controller
{
    public function index()
    {
       $data = DB::table('ly_admin_fuser')->select('id','username')->get();

      return view("Admin.Zhiban.zhiban",['data'=>$data]);
    }

 public function add(Request $request)
    {
//       dd(121);
//       dd($request->input());

     $userid = $request->input('fuserid');
     $date = $request->input('date');

     $data = [];
     $data['fuserid'] =$userid;
     $data['shuadan_time'] =$date;
     $data['create_time'] =time();
     $data['update_time'] =time();
     if( DB::table("ly_admin_zhiban")->insert($data)){
         return redirect()->back();
     }
     else{
         echo "添加失败";
     }
    }
    //列表
    public function lists(Request $request)
    {
       $data = DB::table('ly_admin_zhiban as z')
           ->join('ly_admin_fuser as f','z.fuserid','=','f.id' )
           ->select('f.username','z.*')
           ->orderBy('z.create_time')
           ->paginate(20);
//       dd($data);

       return view("Admin.Zhiban.list",['data'=>$data , 'request' => $request->all()]);
    }



    public function delete(Request $request)
    {
       $id = $request->input('id');

        if(DB::table('ly_admin_zhiban')->where('id', '=', $id )->delete()){
            echo 1;
        }

//        return redirect()->back();
    }
    public function xiugai(Request $request)
    {
        $info = DB::table('ly_admin_fuser')->select('id','username')->get();


        $id = $request->input('id');

       $data =  DB::table("ly_admin_zhiban")
                ->where('id','=',$id)
                ->first();

//       dd($data);
        return view("Admin.Zhiban.update",[
            'data'=>$data,
            'info'=>$info
        ]);

//        return redirect()->back();
    }
    public function zhibanupdateok(Request $request)
    {
        //表id
        $id = $request->input('id');//1

        $data= [];

        //查找表数据fuserid
       $info =  DB::table('ly_admin_zhiban')->where('id','=',$id)->first();


       if( $info->fuserid != $request->input('fuseridd') ){
           $data['fuserid']=  $request->input('fuseridd');
       }
       if($info->shuadan_time !=  $request->input('time') ){
           $data['shuadan_time'] =  $request->input('time');
       }

      if(DB::table('ly_admin_zhiban')->where( 'id', '=', $id)->update($data)){
           echo 1;
      } else{
          echo 2;
      }
    }

    public function test()
    {
        dd(11);
    }
}