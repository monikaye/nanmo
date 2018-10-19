<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Requests\MemberInsertRequest;
use PHPExcel;
use PHPExcel_Writer_Excel2007;
use IOFactory;
use PHPExcel_Cell;
// use ZipArchive;
// use Session;
// use Input;
class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {    
        
        //获取全部商店
        $shop   = DB::table('ly_admin_shop')
                    ->select('shopname','id')
                    ->orderBy('shopname')
                    ->get();
        // dd($shop);
        //获取全部刷单人
        $fuser  = DB::table('ly_admin_fuser')
                    ->where('status', '=', 1)
                    ->select('id as fid', 'username as fname')
                    ->orderBy('username')
                    ->get();
        //获取全部货号
        $huohao = DB::table('ly_admin_huohao')
                    ->select('id', 'huohao')
                    ->orderBy('huohao')
                    ->get();
        //获取手机编号
        $phone  = DB::table('ly_admin_phone')
                    ->select('id', 'phonenum')
                    ->orderBy('phonenum')
                    ->get();
           // var_dump($request->input());
           // exit;
        $map = [];
        
        if($request->input('bigt')) {
            $map[1] = ['m.tqnum', '>', $request->input('bigt')];
            session(['bigt'=>$request->input('bigt')]);
        }else{
            $request->session()->forget('bigt');
        }

        if($request->input('smallt')) {
            $map[2] = ['m.tqnum', '<', $request->input('smallt')];
            session(['smallt'=>$request->input('smallt')]);
        }else{
            $request->session()->forget('smallt');
        }

        if($request->input('phoneid')) {
            $map[3] = ['m.phoneid', '=', $request->input('phoneid')];
            session(['phoneid'=>$request->input('phoneid')]);
        }else{
            $request->session()->forget('phoneid');
        }

        if($request->input('username')) {
            $map[4] = ['m.username', 'like', '%'.$request->input('username').'%'];
            session(['uname'=>$request->input('username')]);
        }else{
            $request->session()->forget('uname');
        }
        if($request->input('bigy')) {
            $map[5] = ['m.ymoney', '>', $request->input('bigy')];
            session(['bigy'=>$request->input('bigy')]);
        }else{
            $request->session()->forget('bigy');
        }
        if($request->input('smally')) {
            $map[6] = ['m.ymoney', '<', $request->input('smally')];
            session(['bigy'=>$request->input('smally')]);
        }else{
            $request->session()->forget('smally');
        }
        if($request->input('ifyuan')) {
            $map[7] = ['m.ifyuan', '=', $request->input('ifyuan')];
            session(['ifyuan'=>$request->input('ifyuan')]);
        }else{
            $request->session()->forget('ifyuan');
        }
        if($request->input('wwname')) {
            $map[8] = ['m.wwname', 'like', '%'.$request->input('wwname').'%'];
            session(['wwname'=>$request->input('wwname')]);
        }else{
            $request->session()->forget('wwname');
        }
        if($request->input('bigj')) {
            $map[9] = ['m.jixiao', '>', $request->input('bigj')];
            session(['bigj'=>$request->input('bigj')]);
        }else{
            $request->session()->forget('bigj');
        }
        if($request->input('smallj')) {
            $map[10] = ['m.jixiao', '<', $request->input('smallj')];
            session(['smallj'=>$request->input('smallj')]);
        }else{
            $request->session()->forget('smallj');
        }
        if($request->input('fphone')) {
            $map[11] = ['m.fphone', '=', $request->input('fphone')];
            session(['fphone'=>$request->input('fphone')]);
        }else{
            $request->session()->forget('fphone');
        }
        if($request->input('orders')) {
            $map[12] = ['m.orders', '=', $request->input('orders')];
            session(['orders'=>$request->input('orders')]);
        }else{
            $request->session()->forget('orders');
        }
        if($request->input('bigf')) {
            $map[13] = ['m.fmoney', '>', $request->input('bigf')];
            session(['bigf'=>$request->input('bigf')]);
        }else{
            $request->session()->forget('bigf');
        }
        if($request->input('smallf')) {
            $map[14] = ['m.fmoney', '<', $request->input('smallf')];
            session(['smallf'=>$request->input('smallf')]);
        }else{
            $request->session()->forget('smallf');
        }
        if($request->input('ifsuper')) {
            $map[15] = ['m.ifsuper', '=', $request->input('ifsuper')];
            session(['ifsuper'=>$request->input('ifsuper')]);
        }else{
            $request->session()->forget('ifsuper');
        }
        if($request->input('gift')) {
            $map[16] = ['m.gift', 'like', '%'.$request->input('gift').'%'];
            session(['gift'=>$request->input('gift')]);
        }else{
            $request->session()->forget('gift');
        }
        if($request->input('bige')) {
            $map[17] = ['m.extra', '>', $request->input('bige')];
            session(['bige'=>$request->input('bige')]);
        }else{
            $request->session()->forget('bige');
        }
        if($request->input('smalle')) {
            $map[18] = ['m.extra', '<', $request->input('smalle')];
            session(['smalle'=>$request->input('smalle')]);
        }else{
            $request->session()->forget('smalle');
        }
        if($request->input('fuserid')) {
            $map[19] = ['m.fuserid', '=', $request->input('fuserid')];
            session(['fuserid'=>$request->input('fuserid')]);
        }else{
            $request->session()->forget('fuserid');
        }
        if($request->input('remark')) {
            $map[20] = ['m.remark', 'like', '%'.$request->input('remark').'%'];
            session(['remark'=>$request->input('remark')]);
        }else{
            $request->session()->forget('remark');
        }
        if($request->input('start')) {
            $map[21] = ['m.shuadan_time', '>=', $request->input('start')];
            session(['start'=>$request->input('start')]);
        }else{
            $request->session()->forget('start');
        }
        if($request->input('stop')) {
            $map[22] = ['m.shuadan_time', '<=', $request->input('stop')];
            session(['stop'=>$request->input('stop')]);
        }else{
            $request->session()->forget('stop');
        }
        if($request->input('sex')) {
            $map[23] = ['m.sex', '=', $request->input('sex')];
            session(['sex'=>$request->input('sex')]);
        }else{
            $request->session()->forget('sex');
        }
        if($request->input('shopid')) {
            $shid    = DB::table('ly_admin_shop')
                             ->where('shopname', '=', $request->input('shopid')) 
                             ->value('id');
            $map[24] = ['m.shopid', '=', $shid];

            session(['shid'=>$request->input('shopid')]);
        }else{
            $request->session()->forget('shid');
        }

        $count  = count(DB::table("ly_admin_member as m")
                        ->join('ly_admin_fuser as f', 'm.fuserid', '=', 'f.id')
                        ->join('ly_admin_phone as p', 'm.phoneid', '=', 'p.id')
                        ->join('ly_admin_phone as pp', 'm.fphone', '=', 'pp.id')
                        ->join('ly_admin_huohao as h', 'm.huohao', '=', 'h.id')
                        ->join('ly_admin_shop as s', 'm.shopid', '=', 's.id')
                        ->join('ly_admin_user as u', 'm.userid', '=', 'u.id')
                        ->select('m.*','f.username as fname','p.phonenum as pnum','pp.phonenum as ppnum', 'h.huohao', 'h.shopid', 's.shopname', 'u.username as uname')
                        ->where($map)
                        ->orderBy('shuadan_time','desc')
                        ->get());
        $rev    = '15';
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
        //7、sql查询数据库
        $data   = Db::table("ly_admin_member as m")
                        ->join('ly_admin_fuser as f', 'm.fuserid', '=', 'f.id')
                        ->join('ly_admin_phone as p', 'm.phoneid', '=', 'p.id')
                        ->join('ly_admin_phone as pp', 'm.fphone', '=', 'pp.id')
                        ->join('ly_admin_huohao as h', 'm.huohao', '=', 'h.id')
                        ->join('ly_admin_shop as s', 'm.shopid', '=', 's.id')
                        ->join('ly_admin_user as u', 'm.userid', '=', 'u.id')
                        ->select('m.*','f.username as fname','p.phonenum as pnum','pp.phonenum as ppnum', 'h.huohao', 'h.shopid', 's.shopname', 'u.username as uname')
                        ->where($map)
                        ->offset($offset)
                        ->limit($rev)
                        ->orderBy('shuadan_time','desc')
                        ->get();
        foreach($data as $k => $v){
            if(DB::table('ly_admin_saled')->where("orders", "=", $v->orders)->first()){
                $data[$k]->saled = 1;
            }else{
                $data[$k]->saled = 0;
            }
        }


        //8、数字分页(可有可无)
        $pp     = array();
        for ($i = 1;$i <= $sums;$i++) {
            $pp[$i] = $i;
        }
        // dd($data);
        return view('Admin.Member.index',['data'=>$data,'prev'=>$prev,'next'=>$next,'sums'=>$sums,'pp'=>$pp,'page'=>$page,  'shop' => $shop, 'fuser' => $fuser, 'huohao' => $huohao, 'phone' => $phone, 'map' => $map, 'count' => $count]);

        
            
    }
    
    public function page_pro(Request $request){

        
        //获取全部商店
        $shop   = DB::table('ly_admin_shop')
                    ->select('shopname','id')
                    ->get();
        // dd($shop);
        //获取全部刷单人
        $fuser  = DB::table('ly_admin_fuser')
                    ->where('status', '=', 1)
                    ->select('id as fid', 'username as fname')
                    ->get();
        //获取全部货号
        $huohao = DB::table('ly_admin_huohao')
                    ->select('id', 'huohao')
                    ->get();
        //获取手机编号
        $phone  = DB::table('ly_admin_phone')
                    ->select('id', 'phonenum')
                    ->orderBy('phonenum')
                    ->get();
           // var_dump($request->input());
           // exit;
        $map = [];
       
        if(session('bigt')) {
            $map[] = ['m.tqnum', '>=', session('bigt')];
        }
        if(session('smallt')) {
            $map[] = ['m.tqnum', '<=', session('smallt')];
        }
        if(session('phoneid')) {
            $map[] = ['m.phoneid', '=', session('phoneid')];
        }
        if(session('uname')) {
            $map[] = ['m.username', 'like', '%'.session('uname').'%'];
        }
        if(session('bigy')) {
            $map[] = ['m.ymoney', '>=', session('bigy')];
        }
        if(session('smally')) {
            $map[] = ['m.ymoney', '<=', session('smally')];
        }
        if(session('ifyuan')) {
            $map[] = ['m.ifyuan', '=', session('ifyuan')];
        }
        if(session('wwname')) {
            $map[] = ['m.wwname', 'like', '%'.session('wwname').'%'];
        }
        if(session('bigj')) {
            $map[] = ['m.jixiao', '>', session('bigj')];
        }
        if(session('smallj')) {
            $map[] = ['m.jixiao', '<', session('smallj')];
        }
        if(session('fphone')) {
            $map[] = ['m.fphone', '=', session('fphone')];
        }
        if(session('orders')) {
            $map[] = ['m.orders', '=', session('orders')];
        }
        if(session('bigf')) {
            $map[] = ['m.fmoney', '>', session('bigf')];
        }
        if(session('smallf')) {
            $map[] = ['m.fmoney', '<', session('smallf')];
        }
        if(session('ifsuper')) {
            $map[] = ['m.ifsuper', '=', session('ifsuper')];
        }
        if(session('gift')) {
            $map[] = ['m.gift', 'like', '%'.session('gift').'%'];
        }
        if(session('bige')) {
            $map[] = ['m.extra', '>', session('bige')];
        }
        if(session('extra')) {
            $map[] = ['m.extra', '<', session('extra')];
        }
        if(session('fuserid')) {
            $map[] = ['m.fuserid', '=', session('fuserid')];
        }
        if(session('remark')) {
            $map[] = ['m.remark', 'like', '%'.session('remark').'%'];
        }
        if(session('start')) {
            $map[] = ['m.shuadan_time', '>=', session('start')];
        }
        if(session('stop')) {
            $map[] = ['m.shuadan_time', '<=', session('stop')];
        }
        if(session('sex')) {
            $map[] = ['m.sex', '=', session('sex')];
        }
        if(session('shid')) {
            $shid    = DB::table('ly_admin_shop')
                             ->where('shopname', '=', session('shid')) 
                             ->value('id');
            $map[] = ['m.shopid', '=', $shid];
        }

        $count  = count(DB::table("ly_admin_member as m")
                        ->join('ly_admin_fuser as f', 'm.fuserid', '=', 'f.id')
                        ->join('ly_admin_phone as p', 'm.phoneid', '=', 'p.id')
                        ->join('ly_admin_phone as pp', 'm.fphone', '=', 'pp.id')
                        ->join('ly_admin_huohao as h', 'm.huohao', '=', 'h.id')
                        ->join('ly_admin_shop as s', 'm.shopid', '=', 's.id')
                        ->join('ly_admin_user as u', 'm.userid', '=', 'u.id')
                        ->select('m.*','f.username as fname','p.phonenum as pnum','pp.phonenum as ppnum', 'h.huohao', 'h.shopid', 's.shopname', 'u.username as uname')
                        ->where($map)
                        ->orderBy('shuadan_time','desc')
                        ->get());
        $rev    = '15';
        //3、求总页数
        $sums   = ceil($count/$rev);
        //4、求单前页
        $page   = $request->input('page');
        if (empty($page)) {
            $page = "2";
        }
        //5、设置上一页、下一页
        $prev   = ($page - 1) > 0?$page - 1:1;
        $next   = ($page + 1) < $sums?$page + 1:$sums;
        //6、求偏移量
        $offset = ($page - 1) * $rev;
        //7、sql查询数据库
        $data   = DB::table("ly_admin_member as m")
                        ->join('ly_admin_fuser as f', 'm.fuserid', '=', 'f.id')
                        ->join('ly_admin_phone as p', 'm.phoneid', '=', 'p.id')
                        ->join('ly_admin_phone as pp', 'm.fphone', '=', 'pp.id')
                        ->join('ly_admin_huohao as h', 'm.huohao', '=', 'h.id')
                        ->join('ly_admin_shop as s', 'm.shopid', '=', 's.id')
                        ->join('ly_admin_user as u', 'm.userid', '=', 'u.id')
                        ->select('m.*','f.username as fname','p.phonenum as pnum','pp.phonenum as ppnum', 'h.huohao', 'h.shopid', 's.shopname', 'u.username as uname')
                        ->where($map)
                        ->offset($offset)
                        ->limit($rev)
                        ->orderBy('shuadan_time','desc')
                        ->get();
        foreach($data as $k => $v){
            if(DB::table('ly_admin_saled')->where("orders", "=", $v->orders)->first()){
                $data[$k]->saled = 1;
            }else{
                $data[$k]->saled = 0;
            }
        }
        //8、数字分页(可有可无)
        $pp     = array();
        for ($i = 1;$i <= $sums;$i++) {
            $pp[$i] = $i;
        }


        return view('Admin.Member.page',['data'=>$data,'prev'=>$prev,'next'=>$next,'sums'=>$sums,'pp'=>$pp,'page'=>$page,  'shop' => $shop, 'fuser' => $fuser, 'huohao' => $huohao, 'phone' => $phone]);

    }
    //批量删除
    public function del(Request $request)
    {
        if($request->ajax()){
            $a = $request->input('a');
            $a = rtrim($a,',');
            $a = explode(',',$a);
            
            foreach($a as $o => $p) {
                //获取要删除的数据
                $info   = DB::table('ly_admin_member')
                            ->select(DB::raw('(ymoney + fmoney + extra) as zongjia, fphone'))
                            ->where('id','=', $p)
                            ->first();
                // dd($info);
                //获得银行卡id
                $cardid = DB::table("ly_admin_phone")
                                ->where("id", '=', $info->fphone)
                                ->value('cardid');
                //获取银行卡原余额
                $old    = DB::table("ly_admin_card")
                                ->where("id", "=", $cardid)
                                ->value("money");
                $new    = $old + $info->zongjia;

                $del    = DB::table('ly_admin_member')
                            ->where('id','=', $p)
                            ->delete();
                $data = [];
                $data["money"] = $new;
                DB::table("ly_admin_card")
                        ->where("id", "=", $cardid)
                        ->update($data);
            }
            
            if($del) {
                
                


                echo 1;
            }
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
        //获取手机编号
        $phone  = DB::table("ly_admin_phone") 
                    -> select('phonenum','id') 
                    -> get();
        //获取货号
        $huohao = DB::table('ly_admin_huohao')
                    -> select('id', 'huohao', 'shopid') 
                    -> get();
        //获取放单人
        $fuser  = DB::table("ly_admin_fuser") 
                    -> select('username','id') 
                    -> get();
        //加载添加模板
        return view("Admin.Member.add", ['phone' => $phone, 'huohao' => $huohao, 'fuser' => $fuser, ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 执行日常刷单任务添加
    public function store(MemberInsertRequest $request)
    {   
        //获取要添加得数据
        $data                = $request->input();
        // dd($data);
        $data["create_time"] = time();
        //获取shopid
        $huohaoid            = $request->input('huohao');
        $data['shopid']      = DB::table("ly_admin_huohao")
                                    ->where('id', '=', $huohaoid)
                                    ->value('shopid');
        // dd(22);
        $data['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        $log                 = [];
        $log['remark']       = '添加了一单任务'.'订单号为'.$data['orders'];
        $log['create_time']  = $data["create_time"];
        $log['userid']       = $data['userid'];
        // 执行添加
        if (DB::table("ly_admin_member")->insert($data)){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/member")->with("success","添加成功");
        } else {
            return redirect("/member/create")->with("error","添加失败");
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
        //获取手机编号
        $phone  = DB::table("ly_admin_phone") 
                        ->select('phonenum','id') 
                        ->get();
        //获取货号
        $huohao = DB::table('ly_admin_huohao')
                        ->select('id', 'huohao', 'shopid') 
                        ->get();
        //获取当前的数据
        $info   =DB::table("ly_admin_member")
                        ->where("id","=",$id)
                        ->first();
        
        //展示分类修改页面
        return view("Admin.Member.edit",["info"=>$info, 'phone' => $phone, 'huohao' => $huohao]);
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
        // dd($request -> input());
        //获取要修改得数据
        $data               = $request->except('_method');
        //获取shopid
        $huohaoid           = $request->input('huohao');
        $data['shopid']     = DB::table("ly_admin_huohao")
                                    ->where('id', '=', $huohaoid)
                                    ->value('shopid');
        // dd($data);
        $log                = [];
        $log['remark']      = '修改了一单任务';
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        // dd($log);
        //执行修改
        if (DB::table("ly_admin_member")->where("id", '=',$id)->update($data)){
            DB::table('ly_admin_log')->insert($log);
            return redirect("/member/{$id}/edit")->with("success","修改成功");
        } else {
            return redirect("/member/{$id}/edit")->with("error","修改失败");
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
        $log['remark']      = '删除了一单任务';
        $log['create_time'] = time();
        $log['userid']      = DB::table('ly_admin_user')
                                    ->where('username','=', session('username'))
                                    ->value('id');
        //获取要删除的数据
        $info   = DB::table('ly_admin_member')
                    ->select(DB::raw('(ymoney + fmoney + extra) as zongjia, fphone'))
                    ->where('id','=', $id)
                    ->first();
        // dd($info);
        //获得银行卡id
        $cardid = DB::table("ly_admin_phone")
                        ->where("id", '=', $info->fphone)
                        ->value('cardid');
        //获取银行卡原余额
        $old    = DB::table("ly_admin_card")
                        ->where("id", "=", $cardid)
                        ->value("money");
        $new    = $old + $info->zongjia;
        //删除刷单任务表
        if (DB::table("ly_admin_member")->where("id","=",$id)->delete()){
            DB::table('ly_admin_log')->insert($log);
            $data = [];
            $data["money"] = $new;
            DB::table("ly_admin_card")
                    ->where("id", "=", $cardid)
                    ->update($data);
            return redirect("/member")->with("success","删除成功");
        } else {
            return redirect("/member")->with("error","删除失败");
        }
        
    }

    //导入
    public function daoru(Request $request)
    {   
       // dd($request->file);
       $cishu =  count($_FILES['file']['name']);
       // dd($cishu);
       for ($h = 0; $h < $cishu; $h++) { 
           $objPHPExcel = new PHPExcel();
           $tmp_file    = $_FILES['file']['tmp_name'][$h];
           $file_types  = explode(".", $_FILES['file']['name'][$h]);
           $file_type   = $file_types[count($file_types) - 1];
           //判断是不是.xls文件
           if (strtolower($file_type) != "xls") {
            die('请传入.xls,亲不要把原来的xlsx改为xls，那也是无效的');
           }
           $userid = DB::table('ly_admin_user')
                            ->where('username', '=', session('username'))
                            ->value('id');
           $savePath    = "./excel/";
           //已时间来命名上传的文件
           $str         = date('ymdhis');
           $file_name   = $str . "." . $file_type;
           // var_dump($file_name);
           $request->file('file')[$h]->move($savePath, $file_name);
           //获取新的文件路劲——名字
           $fullpath    = $savePath.$file_name;
           $re          = $this->read($fullpath, 'utf-8');
           $g           = 0;
           foreach($re as $ood => $loc) {
                $bb = strlen(implode(',',$loc));
                if ($bb == 18) {
                    unset($re[$ood]);
                }
           }
           $bb = [];
           foreach($re as $ood => $loc) {
                $bb[] = implode(',',$loc);
                
           }
           $cc = array_unique($bb);
           // var_dump($cc);
           $dd = [];
           $ddd = 1;
           foreach($cc as $kb => $vb) {
                $dd[$ddd] = explode(',',$vb);
                $ddd++;
           }

           $re = $dd;
           // var_dump($re);
           // exit;


           //第一遍判断是否符合导入格式
           for($i = 1;$i < count($re); $i++){
                if($re[$i + 1][0] != null ) {
                    //获取所在手机id
                    $phoneid  = DB::table('ly_admin_phone')
                                        ->where('phonenum', '=', $re[$i + 1][1])
                                        ->value('id');
                    if(!isset($phoneid)){
                        return '所在手机'.$re[$i + 1][1].'不存在';
                    }
                    //判断刷单日期格式
                    if(!preg_match('/^[\d]{8}$/',$re[$i + 1][18])){
                        return '试单日期:'.$re[$i + 1][18].',格式不正确';
                    }
                    // echo "<script> confirm( '检测到试用日期与今天日期不符');</script>";
                    // sleep(2);
                    // echo 666;
                    // exit;
                    //获取店铺id
                    $shopid   = DB::table("ly_admin_shop")
                                        ->where('shopname', '=', $re[$i + 1][5])
                                        ->value('id');
                    if(!isset($shopid)){
                        return '店铺'.$re[$i + 1][5].'不存在';
                    }
                    //获取放单人id
                    $fuserid  = DB::table("ly_admin_fuser")
                                        ->where('username', '=', $re[$i + 1][12])
                                        ->value('id');
                    if(!isset($fuserid)){
                        return '放单人'.$re[$i + 1][12].'不存在';
                    }
                    //获取货号id
                    $huohao   = DB::table("ly_admin_huohao")
                                        ->where('huohao', '=', $re[$i + 1][14])
                                        ->value('id');
                    if(!isset($huohao)){
                        return '货号'.$re[$i + 1][14].'不存在';
                    }
                    $huohaos  = DB::table("ly_admin_huohao")
                                        ->where('huohao', '=', $re[$i + 1][14])
                                        ->where('shopid', '=', $shopid)
                                        ->first();
                    //判断货号的shopid和shopid是否一致
                    if(!$huohaos) {
                        return '货号'.$re[$i + 1][14].'与商铺'.$re[$i + 1][5].'不匹配';
                    }
                    // dd(11);
                    //获取付款手机id
                    $fphoneid = DB::table('ly_admin_phone')
                                        ->where('phonenum', '=', $re[$i + 1][16])
                                        ->value('id');
                    if(!isset($fphoneid)){
                        return '付款手机'.$re[$i + 1][16].'不存在';
                    }
                    $orders = $re[$i + 1][3];
                    if(count(DB::table('ly_admin_member')->where('orders','=', $orders)->get())>0){
                        return '订单号：'.$orders.'已存在';
                    }
                }
                    
                // var_dump($re);
                // exit;
            }

            for($i = 1;$i < count($re); $i++){
                if($re[$i + 1][0] != null ) {
                    //获取所在手机id
                    $phoneid  = DB::table('ly_admin_phone')
                                        ->where('phonenum', '=', $re[$i + 1][1])
                                        ->value('id');
                    //获取店铺id
                    $shopid   = DB::table("ly_admin_shop")
                                        ->where('shopname', '=', $re[$i + 1][5])
                                        ->value('id');
                    //获取放单人id
                    $fuserid  = DB::table("ly_admin_fuser")
                                        ->where('username', '=', $re[$i + 1][12])
                                        ->value('id');
                    //获取货号id
                    $huohao   = DB::table("ly_admin_huohao")
                                        ->where('huohao', '=', $re[$i + 1][14])
                                        ->value('id');
                    //获取付款手机id
                    $fphoneid = DB::table('ly_admin_phone')
                                        ->where('phonenum', '=', $re[$i + 1][16])
                                        ->value('id');
                    //性别
                    if($re[$i + 1][6] == '男') {
                        $re[$i + 1][6] = 1;
                    }
                    if($re[$i + 1][6] == '女') {
                        $re[$i + 1][6] = 2;
                    }
                    if($re[$i + 1][6] == '未知') {
                        $re[$i + 1][6] = 3;
                    }
                    if($re[$i + 1][6] == '') {
                        $re[$i + 1][6] = 3;
                    }
                    //偏远地区
                    if($re[$i + 1][7] == '是') {
                        $re[$i + 1][7] = 1;
                    }
                    if($re[$i + 1][7] == '不是') {
                        $re[$i + 1][7] = 2;
                    }
                    if($re[$i + 1][7] == '未知') {
                        $re[$i + 1][7] = 3;
                    }
                    if($re[$i + 1][7] == '') {
                        $re[$i + 1][7] = 3;
                    }
                    //超级会员
                    if($re[$i + 1][9] == '是') {
                        $re[$i + 1][9] = 1;
                    }
                    if($re[$i + 1][9] == '不是') {
                        $re[$i + 1][9] = 2;
                    }
                    if($re[$i + 1][9] == '未知') {
                        $re[$i + 1][9] = 3;
                    }
                    if($re[$i + 1][9] == '') {
                        $re[$i + 1][9] = 3;
                    }
                    //礼物
                    if ($re[$i + 1][11] == null) {
                        $re[$i + 1][11] = '无';
                    } 
                    //备注
                    if ($re[$i + 1][15] == '') {
                        $re[$i + 1][15] = '无';
                    } 
                    //额外付款金额
                    if ($re[$i + 1][17] == null) {
                        $re[$i + 1][17] = 0.0;
                    }
		            if ($re[$i + 1][8] == null) {
                        $re[$i + 1][8] = 0.0;
                    }
		            if ($re[$i + 1][10] == null) {
                        $re[$i + 1][10] = 0.0;
                    }

		            $re8    = floatval($re[$i + 1][8]);
		            $re10   = floatval($re[$i + 1][10]);
		            $re17   = floatval($re[$i + 1][17]);
                    //计算要付款的总金额
                    $zongjine = $re8 + $re10  + $re17;
                    // dd($zongjine);
                    //获取要付款的银行卡号
                    $fcardid  = DB::table("ly_admin_phone")
                                        ->where("phonenum", '=', $re[$i + 1][16])
                                        ->value("cardid");
                    //获取付款银行卡原余额
                    $oldjine  = DB::table("ly_admin_card")
                                        ->where("id", "=", $fcardid)
                                        ->value("money");
                    // dd($fcardid);s
                    $newjine  = $oldjine-$zongjine;
                    // dd($newjine);
                    $jine["money"] = $newjine;
                    $adds = DB::table('ly_admin_member')->insert(['username' => $re[$i + 1][0], 'phoneid' =>$phoneid, 'wwname' => $re[$i + 1][2], 'orders'=> $re[$i + 1][3], 'tqnum' => $re[$i + 1][4], 'shopid' => $shopid, 'sex' => $re[$i + 1][6], 'ifyuan' => $re[$i + 1][7], 'fmoney' => $re[$i + 1][8], 'ifsuper' => $re[$i + 1][9], 'ymoney' => $re[$i + 1][10], 'gift' => $re[$i + 1][11], 'fuserid' => $fuserid, 'jixiao' => $re[$i + 1][13], 'huohao' => $huohao, 'remark' => $re[$i + 1][15], 'fphone' => $fphoneid, 'extra' => $re[$i + 1][17], 'shuadan_time' => $re[$i + 1][18], '_token' => md5(time()), 'create_time' => time(), 'userid' => $userid]);

                    
                        DB::table("ly_admin_card")
                                ->where("id", '=', $fcardid)
                                ->update($jine);
                    

                    $g++;
                } else {
                    $adds = '';
                }
            }
            
            
            
       }
          if($adds){
                $log                = [];
                $log['remark']      = '导入了'.$g*$cishu.'条任务';
                $log['create_time'] = time();
                $log['userid']      = DB::table('ly_admin_user')
                                            ->where('username','=', session('username'))
                                            ->value('id');
                DB::table('ly_admin_log')->insert($log);
                return redirect("/member")->with("success","导入成功");
            }

       
    }

    public function dao(){
        //获取全部商店
        $shop   = DB::table('ly_admin_shop')
                    ->select('shopname','id')
                    ->get();
        //获取全部刷单人
        $fuser  = DB::table('ly_admin_fuser')
                    ->where('status', '=', 1)
                    ->select('id as fid', 'username as fname')
                    ->get();
        //获取全部货号
        $huohao = DB::table('ly_admin_huohao')
                    ->select('id', 'huohao')
                    ->get();
        //获取手机编号
        $phone  = DB::table('ly_admin_phone')
                    ->select('id', 'phonenum')
                    ->get();
        return view("Admin.Member.daochu",[ 'shop' => $shop, 'fuser' => $fuser, 'huohao' => $huohao, 'phone' => $phone]);
    }
    //批量修改
    public function pledit(Request $request)
    {
        if($request->ajax()){
            // echo $request->input('a');
            // 获取id数组
            $id = explode(',',rtrim($request->input('a'),','));
            //组件修改的数组
            $data = [];
            //所在手机编号
            if($request->input('pd')){
                $data['phoneid'] = $request->input('pd');
            }
            $shopid = '';
            //货号
            if($request->input('hh')){
                $data['huohao'] = $request->input('hh');
                $shopid         = DB::table('ly_admin_member')
                                        ->where('id', '=', $request->input('hh'))
                                        ->value('shopid');
            }
            //店铺
            if($request->input('sd')){
                $data['shopid'] = $request->input('sd');
                if($shopid != ""){
                    if($shopid != $data['shopid']){
                        echo 2;exit;
                    }
                }
            }
            //付款金额
            if($request->input('fy')){
                $data['fmoney'] = $request->input('fy');
            }
            // 佣金
            if($request->input('yy')){
                $data['ymoney'] = $request->input('yy');
            }
            //礼物
            if($request->input('gt')){
                $data['gift'] = $request->input('gt');
            }
            //放单人
            if($request->input('fd')){
                $data['fuserid'] = $request->input('fd');
            }
            //绩效
            if($request->input('jx')){
                $data['jixiao'] = $request->input('jx');
            }
            //备注
            if($request->input('bz')){
                $data['remark'] = $request->input('bz');
            }
            //付款手机
            if($request->input('fpd')){
                $data['fphone'] = $request->input('fpd');
            }
            //额外付款金额
            if($request->input('ey')){
                $data['extra'] = $request->input('ey');
            }
            //试用日期
            if($request->input('sm')){
                $data['shuadan_time'] = $request->input('sm');
            }

            //进行遍历单条修改
            foreach($id as $key => $value) {
                $update = DB::table('ly_admin_member')
                                    ->where('id', '=', $value)
                                    ->update($data);
            }

            if($update){
                echo 1;
                // exit;
            }


        }
    }


    public function daochu(Request $request)
    {   
        $datas  = $request->input();
        // dd($datas);
        //字段
        $fields = [];
        $a      = 1;
        for ($i=0; $i <= count($datas); $i++) { 
            if(array_key_exists($i, $datas)) {
                // if($datas[$i] != "zmoney"){
                    $fields[$a] = $datas[$i];
                // }
                $a++;
            }
        }

        // dd($fields);
        $a = 1;
        if($request->input('start') == $request->input('stop') && $request->input('start')!= null){
            $filedate = $request->input('start')?$request->input('start'):$request->input('stop');
        }else {
            $filedate = $request->input('start').'-'.$request->input('stop');
        }
        // dd($datas);
        // var_dump($datas);
        //判断商铺名字
        if($request->input('shopid')){
            $ns = count($request->input('shopid'));
        } else {
            $ns = 0;
        }
        if($ns > 1) {
            $sids     = $request->input('shopid');
            // dd($sids);
            $oldname = [];
            $newname = [];
            foreach($sids as $opp => $sb) {
                    // var_dump($sb);
                    // sleep(3);
                    $fns = DB::table('ly_admin_shop')
                                        ->where('id', '=', $sb)
                                        ->value('shopname');
                    //搜索条件
                    $map    = [];
                    if ($request->input('bigt') || $request->input('smallt') || $request->input('phoneid') || $request->input('username') || $request->input('bigy') || $request->input('smally') || $request->input('ifyuan') || $request->input('wwname') || $request->input('bigj') || $request->input('smallj') || $request->input('fphone') || $request->input('orders') || $request->input('bigf') || $request->input('smallf') || $request->input('ifsuper') || $request->input('gift') || $request->input('bige') || $request->input('smalle') || $request->input('fuserid') || $request->input('remark') || $request->input('start') || $request->input('stop') || $request->input('shopid') || $request->input('sex')||$request->input('userid')) {
                        if($request->input('bigt')) {
                            $map[] = ['tqnum', '>', $request->input('bigt')];
                        }
                        if($request->input('smallt')) {
                            $map[] = ['tqnum', '<', $request->input('smallt')];
                        }
                        if($request->input('phoneid')) {
                            $map[] = ['phoneid', '=', $request->input('phoneid')];
                        }
                        if($request->input('username')) {
                            $map[] = ['username', 'like', '%'.$request->input('username').'%'];
                        }
                        if($request->input('bigy')) {
                            $map[] = ['tqnum', '>', $request->input('bigt')];
                        }
                        if($request->input('smally')) {
                            $map[] = ['tqnum', '<', $request->input('smallt')];
                        }
                        if($request->input('ifyuan')) {
                            $map[] = ['ifyuan', '=', $request->input('ifyuan')];
                        }
                        if($request->input('wwname')) {
                            $map[] = ['wwname', 'like', '%'.$request->input('wwname').'%'];
                        }
                        if($request->input('bigj')) {
                            $map[] = ['jixiao', '>', $request->input('bigj')];
                        }
                        if($request->input('smallj')) {
                            $map[] = ['jixiao', '<', $request->input('smallj')];
                        }
                        if($request->input('fphone')) {
                            $map[] = ['fphone', '=', $request->input('fphone')];
                        }
                        if($request->input('orders')) {
                            $map[] = ['orders', '=', $request->input('orders')];
                        }
                        if($request->input('bigf')) {
                            $map[] = ['fmoney', '>', $request->input('bigf')];
                        }
                        if($request->input('smallf')) {
                            $map[] = ['fmoney', '<', $request->input('smallf')];
                        }
                        if($request->input('ifsuper')) {
                            $map[] = ['ifsuper', '=', $request->input('ifsuper')];
                        }
                        if($request->input('gift')) {
                            $map[] = ['gift', 'like', '%'.$request->input('gift').'%'];
                        }
                        if($request->input('bige')) {
                            $map[] = ['extra', '>', $request->input('bige')];
                        }
                        if($request->input('smalle')) {
                            $map[] = ['extra', '<', $request->input('smalle')];
                        }
                        if($request->input('fuserid')) {
                            $map[] = ['fuserid', '=', $request->input('fuserid')];
                        }
                        if($request->input('remark')) {
                            $map[] = ['remark', 'like', '%'.$request->input('remark').'%'];
                        }
                        if($request->input('start')) {
                            $map[] = ['shuadan_time', '>=', $request->input('start')];
                        }
                        if($request->input('stop')) {
                            $map[] = ['shuadan_time', '<=', $request->input('stop')];
                        }
                        if($request->input('sex')) {
                            $map[] = ['sex', '=', $request->input('sex')];
                        }
                        if($request->input('shopid')) {
                            $map[] = ['shopid', '=', $sb];
                        }
                    }
                    //获取字段对应数据
                    $query   = DB::table('ly_admin_member')
                                    ->where($map)
                                    ->select('id');
                    if($request->input(21)){
                        array_pop($fields);
                    }   
                    // dd($fields);
                    for ($c=1; $c <= count($fields); $c++) { 
                            $list = $query->addSelect($fields[$c])->get();
                    }
                    ///若果是财务对账,再把操作费拼回去
                    if($request->input(21)){
                        $fields[] = "zmoney";
                    }
                    // dd($fields);
                    $gl = 1;
                    foreach($list as $kl => $vl) {
                        $list[$kl]->id = $gl;
                        $gl++;
                    }
                    // var_dump($list);
                    if(count($list)>1){
                        $danliang = count($list);
                        // echo 1;
                        foreach ($list as $jian => $zhi) {
                            
                            if(isset($zhi->sex)) {
                                if($zhi->sex == 1) {
                                    $list[$jian]->sex = '男';
                                }
                                if($zhi->sex == 2) {
                                    $list[$jian]->sex = '女';
                                }
                                if($zhi->sex == 3) {
                                    $list[$jian]->sex = '未知';
                                }

                            }
                            if(isset($zhi->ifyuan)) {
                                if($zhi->ifyuan == 1) {
                                    $list[$jian]->ifyuan = '是';
                                }
                                if($zhi->ifyuan == 2) {
                                    $list[$jian]->ifyuan = '不是';
                                }
                                if($zhi->ifyuan == 3) {
                                    $list[$jian]->ifyuan = '未知';
                                }
                                if($zhi->ifyuan == 0) {
                                    $list[$jian]->ifyuan = '未知';
                                }

                            }
                            if(isset($zhi->ifsuper)) {
                                if($zhi->ifsuper == 1) {
                                    $list[$jian]->ifsuper = '是';
                                }
                                if($zhi->ifsuper == 2) {
                                    $list[$jian]->ifsuper = '不是';
                                }
                                if($zhi->ifsuper == 3) {
                                    $list[$jian]->ifsuper = '未知';
                                }
                                if($zhi->ifsuper == 0) {
                                    $list[$jian]->ifsuper = '未知';
                                }
                            }
                            if(isset($zhi->shopid)) {
                                $list[$jian]->shopid = DB::table('ly_admin_shop')
                                                                ->where('id', '=', $zhi->shopid)
                                                                ->value('shopname');
                            }
                            if(isset($zhi->phoneid)) {
                                $list[$jian]->phoneid = DB::table('ly_admin_phone')
                                                                ->where('id', '=', $zhi->phoneid)
                                                                ->value('phonenum');
                            }    
                            if(isset($zhi->fuserid)) {
                                $list[$jian]->fuserid = DB::table('ly_admin_fuser')
                                                                ->where('id', '=', $zhi->fuserid)
                                                                ->value('username');
                            }
                            if($request->input(21)) {
                                $list[$jian]->zmoney = DB::table('ly_admin_huohao')
                                                                ->where('id', '=', $zhi->huohao)
                                                                ->value('zmoney');
                            }
                            if(isset($zhi->huohao)) {
                                $list[$jian]->huohao = DB::table('ly_admin_huohao')
                                                                ->where('id', '=', $zhi->huohao)
                                                                ->value('huohao');
                            }
                            
                            if(isset($zhi->fphone)) {
                                $list[$jian]->fphone = DB::table('ly_admin_phone')
                                                                ->where('id', '=', $zhi->fphone)
                                                                ->value('phonenum');
                            }
                            if(isset($zhi->userid)) {
                                $list[$jian]->userid = DB::table('ly_admin_user')
                                                                ->where('id', '=', $zhi->userid)
                                                                ->value('username');
                            }
                        }
                        // dd($list);
                        array_unshift($fields, 'id'); 
                        // ob_end_clean();
                        if(empty($filename)) $filename = time();
                        if(!is_array($fields)) return false;
                        $header_arr  = array('A','B','C','D','E','F','G','H','I','J','K','L','M', 'N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
                        $objPHPExcel = new PHPExcel();
                        $objWriter   = new PHPExcel_Writer_Excel2007($objPHPExcel);
                        // $filename    = $filename.'.xlsx';
                        $objActSheet = $objPHPExcel->getActiveSheet();
                        $startRow    = 1;
                        foreach ($list as $row) {
                            // dd($row);
                            // exit;
                            foreach ($fields as $key => $value) {
                                // var_dump($value);
                                // exit;
                                $vs  = '';
                                if($startRow == 1) {
                                    if ($value == 'id') {
                                        $vs = '编号';
                                    }
                                    if ($value == 'username') {
                                        $vs = '微信备注名';
                                    }
                                    if ($value == 'phoneid') {
                                        $vs = '所在手机编号';
                                    }
                                    if ($value == 'orders') {
                                        $vs = '订单号';
                                    }
                                    if ($value == 'tqnum') {
                                        $vs = '淘气值';
                                    }
                                    if ($value == 'wwname') {
                                        $vs = '旺旺号';
                                    }
                                    if ($value == 'shopid') {
                                        $vs = '店铺名';
                                    }
                                    if ($value == 'sex') {
                                        $vs = '性别';
                                    }
                                    if ($value == 'ifyuan') {
                                        $vs = '是否偏远地区';
                                    }
                                    if ($value == 'fmoney') {
                                        $vs = '付款金额';
                                    }
                                    if ($value == 'ifsuper') {
                                        $vs = '超级会员';
                                    }
                                    if ($value == 'ymoney') {
                                        $vs = '佣金';
                                    }
                                    if ($value == 'fuserid') {
                                        $vs = '放单人';
                                    }
                                    if ($value == 'jixiao') {
                                        $vs = '绩效';
                                    }
                                    if ($value == 'huohao') {
                                        $vs = '货号';
                                    }
                                    if ($value == 'remark') {
                                        $vs = '备注';
                                    }
                                    if ($value == 'fphone') {
                                        $vs = '付款手机';
                                    }
                                    if ($value == 'extra') {
                                        $vs = '额外付款金额';
                                    }
                                    if ($value == 'shuadan_time') {
                                        $vs = '刷单日期';
                                    }
                                    if ($value == 'userid') {
                                        $vs = '录入人';
                                    }
                                    if ($value == 'gift') {
                                        $vs = '礼物';
                                    }
                                    if($value == "zmoney") {
                                        $vs = "操作费";
                                    }
                                    $objActSheet->setCellValue($header_arr[$key].$startRow, $vs);
                                    // $startRow +=1;
                                }
                                
                                if($value == 'orders') {
                                    $row->$value .= ' ';
                                }
                                $objActSheet->setCellValue($header_arr[$key].($startRow+1), $row->$value);
                                // var_dump($header_arr[$key]);
                            }
                            // exit;
                            $startRow++;
                        }
                        unset($fields[0]);
                        $oldname[] = 'exl/'.$filename.$a.'.xls';
                        $newname[] = $filedate.$fns.$danliang.'反馈表.xls';
                        $objWriter->save('exl/'.$filename.$a.'.xls');
                        $a++;
                    }
            }
            $zipnames = $this->zip($oldname, $newname);
            if($zipnames == 'failed') {
                return '导出失败';
            }
            header ( "Cache-Control: max-age=0" );
            header ( "Content-Description: File Transfer" );
            header ( 'Content-disposition: attachment; filename=' . basename ( $zipnames ) ); // 文件名
            header ( "Content-Type: application/zip" ); // zip格式的
            header ( "Content-Transfer-Encoding: binary" ); // 告诉浏览器，这是二进制文件
            header ( 'Content-Length: ' . filesize ( $zipnames ) ); // 告诉浏览器，文件大小
            @readfile ( $zipnames );//输出文件;
        } else {
            $map    = [];

            //搜索条件
            if ($request->input('bigt') || $request->input('smallt') || $request->input('phoneid') || $request->input('username') || $request->input('bigy') || $request->input('smally') || $request->input('ifyuan') || $request->input('wwname') || $request->input('bigj') || $request->input('smallj') || $request->input('fphone') || $request->input('orders') || $request->input('bigf') || $request->input('smallf') || $request->input('ifsuper') || $request->input('gift') || $request->input('bige') || $request->input('smalle') || $request->input('fuserid') || $request->input('remark') || $request->input('start') || $request->input('stop') || $request->input('shopid') || $request->input('sex')||$request->input('userid')) {
                if($request->input('bigt')) {
                    $map[] = ['tqnum', '>', $request->input('bigt')];
                }
                if($request->input('smallt')) {
                    $map[] = ['tqnum', '<', $request->input('smallt')];
                }
                if($request->input('phoneid')) {
                    $map[] = ['phoneid', '=', $request->input('phoneid')];
                }
                if($request->input('username')) {
                    $map[] = ['username', 'like', '%'.$request->input('username').'%'];
                }
                if($request->input('bigy')) {
                    $map[] = ['tqnum', '>', $request->input('bigt')];
                }
                if($request->input('smally')) {
                    $map[] = ['tqnum', '<', $request->input('smallt')];
                }
                if($request->input('ifyuan')) {
                    $map[] = ['ifyuan', '=', $request->input('ifyuan')];
                }
                if($request->input('wwname')) {
                    $map[] = ['wwname', 'like', '%'.$request->input('wwname').'%'];
                }
                if($request->input('bigj')) {
                    $map[] = ['jixiao', '>', $request->input('bigj')];
                }
                if($request->input('smallj')) {
                    $map[] = ['jixiao', '<', $request->input('smallj')];
                }
                if($request->input('fphone')) {
                    $map[] = ['fphone', '=', $request->input('fphone')];
                }
                if($request->input('orders')) {
                    $map[] = ['orders', '=', $request->input('orders')];
                }
                if($request->input('bigf')) {
                    $map[] = ['fmoney', '>', $request->input('bigf')];
                }
                if($request->input('smallf')) {
                    $map[] = ['fmoney', '<', $request->input('smallf')];
                }
                if($request->input('ifsuper')) {
                    $map[] = ['ifsuper', '=', $request->input('ifsuper')];
                }
                if($request->input('gift')) {
                    $map[] = ['gift', 'like', '%'.$request->input('gift').'%'];
                }
                if($request->input('bige')) {
                    $map[] = ['extra', '>', $request->input('bige')];
                }
                if($request->input('smalle')) {
                    $map[] = ['extra', '<', $request->input('smalle')];
                }
                if($request->input('fuserid')) {
                    $map[] = ['fuserid', '=', $request->input('fuserid')];
                }
                if($request->input('remark')) {
                    $map[] = ['remark', 'like', '%'.$request->input('remark').'%'];
                }
                if($request->input('start')) {
                    $map[] = ['shuadan_time', '>=', $request->input('start')];
                }
                if($request->input('stop')) {
                    $map[] = ['shuadan_time', '<=', $request->input('stop')];
                }
                if($request->input('sex')) {
                    $map[] = ['sex', '=', $request->input('sex')];
                }
                if($request->input('shopid')) {
                    $map[] = ['shopid', '=', $request->input('shopid')];
                }
            }
            //获取字段对应数据
            $query   = DB::table('ly_admin_member')
                            ->where($map)
                            ->select('id');
            if($request->input(21)){
                        array_pop($fields);
            }   
            // var_dump($query);exit;
            for ($c=1; $c <= count($fields); $c++) { 
                $list = $query->addSelect($fields[$c])->get();
            }
            ///若果是财务对账,再把操作费拼回去
            if($request->input(21)){
                $fields[] = "zmoney";
            }
            $gl = 1;
            foreach($list as $kl => $vl) {

                $list[$kl]->id = $gl;
                $gl++;
            }
            // var_dump($list);exit; 
            foreach ($list as $jian => $zhi) {
                
                if(isset($zhi->sex)) {
                    if($zhi->sex == 1) {
                        $list[$jian]->sex = '男';
                    }
                    if($zhi->sex == 2) {
                        $list[$jian]->sex = '女';
                    }
                    if($zhi->sex == 3) {
                        $list[$jian]->sex = '未知';
                    }

                }
                if(isset($zhi->ifyuan)) {
                    if($zhi->ifyuan == 1) {
                        $list[$jian]->ifyuan = '是';
                    }
                    if($zhi->ifyuan == 2) {
                        $list[$jian]->ifyuan = '不是';
                    }
                    if($zhi->ifyuan == 3) {
                        $list[$jian]->ifyuan = '未知';
                    }
                    if($zhi->ifyuan == 0) {
                        $list[$jian]->ifyuan = '未知';
                    }

                }
                if(isset($zhi->ifsuper)) {
                    if($zhi->ifsuper == 1) {
                        $list[$jian]->ifsuper = '是';
                    }
                    if($zhi->ifsuper == 2) {
                        $list[$jian]->ifsuper = '不是';
                    }
                    if($zhi->ifsuper == 3) {
                        $list[$jian]->ifsuper = '未知';
                    }
                    if($zhi->ifsuper == 0) {
                        $list[$jian]->ifsuper = '未知';
                    }
                }
                if(isset($zhi->shopid)) {
                    $list[$jian]->shopid = DB::table('ly_admin_shop')
                                                    ->where('id', '=', $zhi->shopid)
                                                    ->value('shopname');
                }
                if(isset($zhi->phoneid)) {
                    $list[$jian]->phoneid = DB::table('ly_admin_phone')
                                                    ->where('id', '=', $zhi->phoneid)
                                                    ->value('phonenum');
                }    
                if(isset($zhi->fuserid)) {
                    $list[$jian]->fuserid = DB::table('ly_admin_fuser')
                                                    ->where('id', '=', $zhi->fuserid)
                                                    ->value('username');
                }
                if($request->input(21)) {
                                $list[$jian]->zmoney = DB::table('ly_admin_huohao')
                                                                ->where('id', '=', $zhi->huohao)
                                                                ->value('zmoney');
                }
                if(isset($zhi->huohao)) {
                    $list[$jian]->huohao = DB::table('ly_admin_huohao')
                                                    ->where('id', '=', $zhi->huohao)
                                                    ->value('huohao');
                }
                if(isset($zhi->fphone)) {
                    $list[$jian]->fphone = DB::table('ly_admin_phone')
                                                    ->where('id', '=', $zhi->fphone)
                                                    ->value('phonenum');
                }
                if(isset($zhi->userid)) {
                    $list[$jian]->userid = DB::table('ly_admin_user')
                                                    ->where('id', '=', $zhi->userid)
                                                    ->value('username');
                }
            }
            // var_dump($list);exit;        
            array_unshift($fields, 'id');
            // dd($fields);exit;
            ob_end_clean();
            $danliang = count($list);

            if($request->input('shopid')) {
                $fns = DB::table('ly_admin_shop')
                                        ->where('id', '=', $request->input('shopid'))
                                        ->value('shopname');
                $filename = $request->input('start').'-'.$request->input('stop').$fns.'单量'.$danliang;
            }else{
                $filename = $request->input('start').'-'.$request->input('start').'单量'.$danliang;
            }
            // if(empty($filename)) $filename = time();
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
                        if ($value == 'username') {
                            $vs = '微信备注名';
                        }
                        if ($value == 'phoneid') {
                            $vs = '所在手机编号';
                        }
                        if ($value == 'orders') {
                            $vs = '订单号';
                        }
                        if ($value == 'tqnum') {
                            $vs = '淘气值';
                        }
                        if ($value == 'wwname') {
                            $vs = '旺旺号';
                        }
                        if ($value == 'shopid') {
                            $vs = '店铺名';
                        }
                        if ($value == 'sex') {
                            $vs = '性别';
                        }
                        if ($value == 'ifyuan') {
                            $vs = '是否偏远地区';
                        }
                        if ($value == 'fmoney') {
                            $vs = '付款金额';
                        }
                        if ($value == 'ifsuper') {
                            $vs = '超级会员';
                        }
                        if ($value == 'ymoney') {
                            $vs = '佣金';
                        }
                        if ($value == 'fuserid') {
                            $vs = '放单人';
                        }
                        if ($value == 'jixiao') {
                            $vs = '绩效';
                        }
                        if ($value == 'huohao') {
                            $vs = '货号';
                        }
                        if ($value == 'remark') {
                            $vs = '备注';
                        }
                        if ($value == 'fphone') {
                            $vs = '付款手机';
                        }
                        if ($value == 'extra') {
                            $vs = '额外付款金额';
                        }
                        if ($value == 'shuadan_time') {
                            $vs = '刷单日期';
                        }
                        if ($value == 'userid') {
                            $vs = '录入人';
                        }
                        if ($value == 'gift') {
                            $vs = '礼物';
                        }
                        if($value == "zmoney") {
                            $vs = "操作费";
                        }
                        $objActSheet->setCellValue($header_arr[$key].$startRow, $vs);
                        // $startRow +=1;
                    }
                    if($value == 'orders') {
                            $row->$value .= ' ';
                    }
                    $objActSheet->setCellValue($header_arr[$key].($startRow+1), $row->$value);
                    // var_dump($header_arr[$key]);
                }
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

    public function read($filename,$encode='utf-8')
    {
     
            //include_once('../app/libs/phpexcel/phpexcel/IOFactory.php');
     
            // $this->load ->library('PHPExcel/IOFactory');
     
            $objReader    = IOFactory::createReader('Excel5');
     
            $objReader->setReadDataOnly(true);
     
            $objPHPExcel  = $objReader->load($filename);
     
            $objWorksheet = $objPHPExcel->getActiveSheet();
     
            $highestRow   = $objWorksheet->getHighestRow();
     
            //echo$highestRow;die;
     
            $highestColumn = $objWorksheet->getHighestColumn();
     
            //echo$highestColumn;die;
     
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
     
            $excelData = array();
     
            for($row = 1;$row <= $highestRow; $row++) {
     
                for ($col= 0; $col < $highestColumnIndex; $col++) {
     
                       $excelData[$row][]=(string)$objWorksheet->getCellByColumnAndRow($col,$row)->getValue();
     
                 }
     
            }
     
            return $excelData;
     
    }

    public function zip(array $oldname ,array $newname) {
            // dd($oldname);
            // dd($newname);

            // 实例化一个zip对象
            $zipObj   = new \ZipArchive();
            // 压缩文件的保存地址
            $zip_path = 'tmp/'.time().'.zip';
            if (file_exists($zip_path)) {
            // 如果压缩文件已经存在，就覆盖
                $res  = $zipObj->open($zip_path, \ZipArchive::OVERWRITE);
            } else {
                // 如果不存在，就创建
                $res  = $zipObj->open($zip_path, \ZipArchive::CREATE);
            }
            if ($res  === true) {
                $a = 0;
                // 添加一个文件到压缩文件，第二个参数可对该文件重命名（可省略)
                foreach($oldname as $key => $value) {
                    $zipObj->addFile($value,$newname[$a]);
                    $a++;
                }
                
                // $zipObj->addFile('/b.txt');
                // 添加一个文件到压缩文件，第二个参数为该文件的内容
                // $zipObj->addFromString('exl/20181005-20181006莱洁旗舰店42.xls', "this is a instruction file");
                $zipObj->close();
                return $zip_path;
            } else {
                echo 'failed';
            }
    }
}
