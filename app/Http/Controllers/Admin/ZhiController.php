<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use PHPExcel;
use PHPExcel_Writer_Excel2007;
use IOFactory;
use PHPExcel_Cell;
// use App\Http\Requests\Member\PhoneRequest;
class ZhiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        
        //获取全部刷的单子
        $shuadan_time = DB::table('ly_admin_member')
                                ->select('shuadan_time')
                                ->groupBy('shuadan_time')
                                ->orderBy('shuadan_time','desc')
                                ->get();

        return view("Admin.Zhi.index", ['shuadan_time'=>$shuadan_time]);
            
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //处理ajax传值页面
    public function zhidu(Request $request)
    {   
        if ($request->ajax()) {
            $time = $request->input('timeval');
            //通过日期获得刷单人
            $fuserid = DB::table('ly_admin_member')
                                ->select('fuserid')
                                ->where('shuadan_time', '=', $time)
                                ->groupBy('fuserid')
                                ->get();
            $fuser = $fuserid;
            //总计
            $zongji = [];
            foreach($fuserid as $k => $v) {
                $fuserid[$k]->fname = DB::table('ly_admin_fuser')
                                                ->where('id' , '=', $v->fuserid)
                                                ->value('username');
                $zongji[] = count(DB::table('ly_admin_member')->where('fuserid', '=', $v->fuserid)->where('shuadan_time', '=', $time)->get());
            }
            //通过日期获得商店名
            $shopid = DB::table('ly_admin_member')
                                ->select('shopid')
                                ->where('shuadan_time', '=', $time)
                                ->groupBy('shopid')
                                ->get();
            foreach($shopid as $key => $value) {
                $shopid[$key]->sname = DB::table('ly_admin_shop')
                                                ->where('id' , '=', $value->shopid)
                                                ->value('shopname');
                foreach($fuser as $fd){
                    $shopid[$key]->count[] = count(DB::table('ly_admin_member')
                                            ->where('shopid','=',$value->shopid)
                                            ->where('fuserid','=',$fd->fuserid)
                                            ->where('shuadan_time', '=', $time)
                                            ->get());
                }
            }
           // echo count($shopid);
            return view("Admin.Zhi.hui", ['fuserid' => $fuserid, 'shopid' => $shopid, 'zongji' => $zongji]);
        }
            

    }
    //智度值日表导出
    public function zhiriview(Request $request)
    {   
        //获取全部刷的单子
        $time = $request->input('shuadan_time');
        //通过日期获得刷单人
        $fuserid = DB::table('ly_admin_member')
                            ->select('fuserid')
                            ->where('shuadan_time', '=', $time)
                            ->groupBy('fuserid')
                            ->get();
        $fuser = $fuserid;
        $zongji = [];
        foreach($fuserid as $k => $v) {
            $fuserid[$k]->fname = DB::table('ly_admin_fuser')
                                            ->where('id' , '=', $v->fuserid)
                                            ->value('username');
            $zongji[] = count(DB::table('ly_admin_member')->where('fuserid', '=', $v->fuserid)->where('shuadan_time', '=', $time)->get());
        }
        //通过日期获得商店名
        $shopid = DB::table('ly_admin_member')
                            ->select('shopid')
                            ->where('shuadan_time', '=', $time)
                            ->groupBy('shopid')
                            ->get();
        foreach($shopid as $key => $value) {
            $shopid[$key]->sname = DB::table('ly_admin_shop')
                                            ->where('id' , '=', $value->shopid)
                                            ->value('shopname');
            foreach($fuser as $fd){
                $shopid[$key]->count[] = count(DB::table('ly_admin_member')
                                        ->where('shopid','=',$value->shopid)
                                        ->where('fuserid','=',$fd->fuserid)
                                        ->where('shuadan_time', '=', $time)
                                        ->get());
            }
        }
        //获取标题数组
        $fields = [];
        foreach($fuserid as $ckey => $cvalue) {
            $fields[$ckey+1] = $cvalue->fname; 
        }
        //获取值数组
        $list = [];
        foreach($shopid as $skey => $svalue) {
            $list[$skey][] = $svalue->sname;
            // $k0[] = $svalue->count[0];
            
            foreach($svalue->count as $sck => $scv) {
                $list[$skey][] = $scv;

            }
            $list[$skey][] = array_sum($svalue->count);
        }
        //标题字段开头插入放单人
        array_unshift($fields,'放单人');
        //标题字段末尾插入总计
        array_push($fields,'总计');
        
        //数组字段末尾插入空
        array_push($zongji,array_sum($zongji));
        //数组字段开头插入总计
        array_unshift($zongji, '总计');
        $maxlist = count($list);
        $list[$maxlist+1] = $zongji;
        // dd($list);
        // exit;
        ob_end_clean();
        // if(empty($filename)) $filename = time();
        $filename = $time.'值日表';
        if(!is_array($fields)) return false;
        $header_arr  = array('A','B','C','D','E','F','G','H','I','J','K','L','M', 'N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $objPHPExcel = new PHPExcel();
        $objWriter   = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $filename    = $filename.'.xlsx';
        $objActSheet = $objPHPExcel->getActiveSheet();
        $startRow    = 1;
        foreach ($list as $row) {
            // dd($row);exit;
            foreach ($fields as $ky => $value) {
                // var_dump($value);
                // exit;
                
                if($startRow == 1) {
                    

                    $objActSheet->setCellValue($header_arr[$ky].$startRow, $value);
                    // $startRow +=1;
                }

                $objActSheet->setCellValue($header_arr[$ky].($startRow+1), $row[$ky]);
                // var_dump($row[$startRow]);
            }
            // exit;
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


    //店铺汇总表
    public function szhidu(Request $request)
    {   
        //获取商店条件
        $shop = DB::table('ly_admin_shop')
                    ->where('status', '=', '1')
                    ->select( 'id', 'shopname')
                    ->get();
        if ($request->isMethod('post')){
            $map = array();
            if ($request->input('shopid') || $request->input('start') || $request->input('stop')) {
                if($request->input('shopid')) {
                    $map[] = ['shopid', '=', $request->input('shopid')];
                }
                if($request->input('start')) {
                    $map[] = ['shuadan_time', '>=', $request->input('start')];
                }
                if($request->input('stop')) {
                    $map[] = ['shuadan_time', '<=', $request->input('stop')];
                }
                

                $shopid = $request->input('shopid');
                $info = $info = DB::table('ly_admin_member')
                    ->select(DB::raw('huohao,shuadan_time,shopid,sum(fmoney) as f,sum(ymoney) as y, count(*) as num , sum(fmoney)+sum(ymoney) as cou'))
                    ->where($map)
                    ->groupBy('shopid','shuadan_time')
                    ->orderBy('shuadan_time','desc')
                    ->get();
                
                foreach ($info as $k => $v) {
                    $zmoney  = DB::table('ly_admin_huohao')->where('id', '=', $v->huohao)->value('zmoney');
                    $info[$k]->huohao = $zmoney;
                    $info[$k]->cou     = floatval($zmoney) * floatval($info[$k]->num) + floatval($info[$k]->cou);
                    $info[$k]->shopid  = DB::table('ly_admin_shop')->where('id', '=', $v->shopid)->value('shopname');
                }
                return view("Admin.Szhi.table", ['info' => $info, 'shop' => $shop]);
            } else{
                //不搜索时
                $info = DB::table('ly_admin_member')
                        ->select(DB::raw('huohao,shuadan_time,shopid,sum(fmoney) as f,sum(ymoney) as y, count(*) as num , sum(fmoney)+sum(ymoney) as cou'))
                        ->groupBy('shopid','shuadan_time')
                        ->orderBy('shuadan_time','desc')
                        ->get();
                
                foreach ($info as $k => $v) {
                    $zmoney  = DB::table('ly_admin_huohao')->where('id', '=', $v->huohao)->value('zmoney');
                    $info[$k]->huohao = $zmoney;
                    $info[$k]->cou     = floatval($zmoney) * floatval($info[$k]->num) + floatval($info[$k]->cou);
                    $info[$k]->shopid  = DB::table('ly_admin_shop')->where('id', '=', $v->shopid)->value('shopname');
                }
                return view("Admin.Szhi.table", ['info' => $info, 'shop' => $shop]);
            }
        
        } else {
            //不搜索时
            $info = DB::table('ly_admin_member')
                    ->select(DB::raw('huohao,shuadan_time,shopid,sum(fmoney) as f,sum(ymoney) as y, count(*) as num , sum(fmoney)+sum(ymoney) as cou'))
                    // ->select()
                    ->groupBy('shopid','shuadan_time')
                    ->orderBy('shuadan_time','desc')
                    ->get();
            // dd($info);
            foreach ($info as $k => $v) {
                $zmoney  = DB::table('ly_admin_huohao')->where('id', '=', $v->huohao)->value('zmoney');
                $info[$k]->huohao = $zmoney;
                $info[$k]->cou     = floatval($zmoney) * floatval($info[$k]->num) + floatval($info[$k]->cou);
                $info[$k]->shopid  = DB::table('ly_admin_shop')->where('id', '=', $v->shopid)->value('shopname');
            }
            return view("Admin.Szhi.index", ['info' => $info, 'shop' => $shop]);
        }

    }
    //显示导出页面
    public function shopdaochu(Request $request)
    {   
        
        //获取商店条件
        $shop = DB::table('ly_admin_shop')
                    ->where('status', '=', '1')
                    ->select( 'id', 'shopname')
                    ->get();     
                    return view("Admin.Szhi.daochu", ['shop' => $shop]);

    }
    
    //处理导出
    public function doshopdaochu(Request $request)
    {
        $datas  = $request->input();
        // dd($datas);
        //字段
        $fields = [];
        $a      = 1;
        for ($i=0; $i <= count($datas); $i++) { 
            if(array_key_exists($i, $datas)) {
                $fields[$a] = $datas[$i];
                $a++;
            }
        }
        // dd($fields);
        $map    = [];
        //搜索条件
        if ($request->input('start') || $request->input('stop') || $request->input('shopid')) {
            
            
            if($request->input('start')) {
                $map[] = ['shuadan_time', '>=', $request->input('start')];
            }
            if($request->input('stop')) {
                $map[] = ['shuadan_time', '<=', $request->input('stop')];
            }
            
            if($request->input('shopid')) {
                $map[] = ['shopid', '=', $request->input('shopid')];
            }
        }
        //获取字段对应数据
        $info   = DB::table('ly_admin_member')
                    ->select(DB::raw('huohao,shuadan_time,shopid,sum(fmoney) as f,sum(ymoney) as y, count(*) as num , sum(fmoney)+sum(ymoney) as cou'))
                    ->where($map)
                    ->groupBy('shopid','shuadan_time')
                    ->orderBy('shuadan_time','desc')
                    ->get();
        // for ($c=1; $c <= count($fields); $c++) { 
        //          $list = $query->addSelect($fields[$c])->get();
        // }
        $gl = 1;
        foreach ($info as $k => $v) {
                $zmoney  = DB::table('ly_admin_huohao')->where('id', '=', $v->huohao)->value('zmoney');
                $info[$k]->huohao  = $zmoney;
                $info[$k]->cou     = floatval($zmoney) * floatval($info[$k]->num) + floatval($info[$k]->cou);
                $info[$k]->shopid  = DB::table('ly_admin_shop')->where('id', '=', $v->shopid)->value('shopname');
                

            }
        // dd($info);
        $list    = [];
        foreach ($info as $k => $v) {
            for ($c=1; $c <= count($fields); $c++) { 
                $a = $fields[$c];
                if(isset($v->$a)) {
                    $list[$k][$a] = $v->$a; 
                }
            }
            $list[$k]['id'] = $gl;
                $gl++;
        }  
                        // dd($list);
    
        // dd($list);exit;        
        array_unshift($fields, 'id');
        // dd($fields);exit;
        ob_end_clean();
        // if(empty($filename)) $filename = time();
        $filename = $request->input('start').'-'.$request->input('stop').'店铺汇总表';
        if(!is_array($fields)) return false;
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
                    if ($value == 'id') {
                        $vs = '编号';
                    }
                    if ($value == 'shopid') {
                        $vs = '店铺名';
                    }
                    if ($value == 'username') {
                        $vs = '微信备注名';
                    }
                    if ($value == 'f') {
                        $vs = '本金';
                    }
                    if ($value == 'y') {
                        $vs = '礼品红包';
                    }
                    if ($value == 'huohao') {
                        $vs = '操作费';
                    }
                    if ($value == 'num') {
                        $vs = '单数';
                    }
                    if ($value == 'cou') {
                        $vs = '应收款';
                    }
                    if ($value == 'shuadan_time') {
                        $vs = '刷单日期';
                    }

                    $objActSheet->setCellValue($header_arr[$key].$startRow, $vs);
                    // $startRow +=1;
                }

                $objActSheet->setCellValue($header_arr[$key].($startRow+1), $row[$value]);
                // var_dump($row[$startRow]);
            }
            // exit;
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
