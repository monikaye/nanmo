<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Requests\ShopInsertRequest;
date_default_timezone_set("Asia/Shanghai");
class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $count  = count(DB::table('ly_admin_log')
                            ->orderBy('create_time',' desc')
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

        $info = DB::table('ly_admin_log')
                        ->orderBy('create_time',' desc')
                        ->offset($offset)
                        ->limit($rev)
                        ->get();
        //8、数字分页(可有可无)
        $pp     = array();
        for ($i = 1;$i <= $sums;$i++) {
            $pp[$i] = $i;
        }
        foreach ($info as $k => $v) {
            $info[$k]->userid = DB::table('ly_admin_user')
                                    ->where('id', '=', $v->userid)
                                    ->value('username');
        }
        
        return view("Admin.Log.index", ['info' => $info, 'prev'=>$prev,'next'=>$next,'sums'=>$sums,'pp'=>$pp,'page'=>$page]);
    }
    
    
}
