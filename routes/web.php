<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//登陆
Route::get('/login',"Admin\LoginController@login");
Route::post('/dologin',"Admin\LoginController@dologin");
//注销
Route::get('/outlogin',"Admin\LoginController@outlogin");
//主页
Route::get('/',"Admin\AdminController@index")->middleware('adminlogin');
Route::get('/index',"Admin\AdminController@index")->middleware('adminlogin');
//任务管理
Route::resource("/member","Admin\MemberController")->middleware('adminlogin');
//ajax无刷新显示
Route::post("/memb","Admin\MemberController@index")->middleware('adminlogin');
// 导入
Route::post("/daoru","Admin\MemberController@daoru")->middleware('adminlogin');
//导出页面
Route::get("/dao","Admin\MemberController@dao");
//导出
Route::post("/daochu","Admin\MemberController@daochu");
//手动分页
Route::get("/page_pro","Admin\MemberController@page_pro");
Route::get("/page_pro_shop","Admin\ShopController@page_pro_shop");
Route::get("/page_pro_huohao","Admin\HuohaoController@page_pro_huohao");
Route::get("/page_pro_saled","Admin\SaledController@page_pro_saled");
//批量删除
Route::get("/del","Admin\MemberController@del");
//zip打包
Route::get("/zip","Admin\MemberController@zip");
// 批量修改
Route::get("/pledit","Admin\MemberController@pledit");



//手机管理
Route::resource("/phones","Admin\PhonesController")->middleware('adminlogin');
Route::post("/pho","Admin\PhonesController@index")->middleware('adminlogin');
Route::resource("/phone","Admin\PhoneController")->middleware('adminlogin');
//银行卡管理
Route::resource("/card","Admin\CardController")->middleware('adminlogin');
//修改
Route::get("/stacard","Admin\CardController@stacard");
//商店管理
Route::resource("/shop","Admin\ShopController")->middleware('adminlogin');
//商店搜索
Route::post("/spsearch","Admin\ShopController@index");
//放单人管理
Route::resource("/fuser","Admin\FuserController")->middleware('adminlogin');
//放单人工资详情
Route::get("/finfo","Admin\FuserController@finfo");
//制度值日表
Route::resource("/zhidu","Admin\ZhiController")->middleware('adminlogin');
Route::get("/zhidus","Admin\ZhiController@zhidu")->middleware('adminlogin');
Route::get('/zhiridaochuview', "Admin\ZhiController@zhiriview");
//店铺汇总表
Route::get('/szhidu',"Admin\ZhiController@szhidu")->middleware('adminlogin');
Route::post('/szhidu',"Admin\ZhiController@szhidu")->middleware('adminlogin');
//导出页面
Route::get('/shopdaochu',"Admin\ZhiController@shopdaochu");
//导出操作
Route::post('/doshopdaochu',"Admin\ZhiController@doshopdaochu");
//货号管理
Route::resource("/huohao","Admin\HuohaoController")->middleware('adminlogin');
//货号搜索
Route::post("/hhsearch","Admin\HuohaoController@index");

//售后管理
Route::resource("/saled","Admin\SaledController")->middleware('adminlogin');
Route::post("/saled","Admin\SaledController@index");
Route::get("/saled_daochu","Admin\SaledController@saled_daochu");
Route::post("/dosaled_daochu","Admin\SaledController@dosaled_daochu");
Route::post("/saledadd","Admin\SaledController@saledadd");
//试用表转售后
Route::get("/m_saled","Admin\SaledController@m_saled");

//角色分配
Route::get("/rolelist/{id}","Admin\RolelistController@rolelist")->middleware('adminlogin');
//保存角色
Route::post("/saverole","Admin\RolelistController@saverole")->middleware('adminlogin');
//角色管理
Route::resource("/role","Admin\RolelistController")->middleware('adminlogin');
//分配权限
Route::get("/auth/{id}","Admin\RolelistController@auth")->middleware('adminlogin');
//保存权限
Route::post("/saveauth","Admin\RolelistController@saveauth")->middleware('adminlogin');
//节点管理
Route::resource("/node","Admin\NodeController")->middleware('adminlogin');

//管理员用户管理
Route::resource("/user","Admin\UserController")->middleware('adminlogin');
//日志管理
Route::resource("/log","Admin\LogController")->middleware('adminlogin');
// Route::get("/log","Admin\LogController@index");
//银行卡充值管理
Route::resource("/addcard","Admin\AddCardController")->middleware('adminlogin');
//添加
Route::get("/addd","Admin\AddCardController@addd");
//删除
Route::get("/acddel","Admin\AddCardController@acddel");

//底薪添加
Route::get("/adddixin","Admin\DixinController@adddixin");
Route::get("/doadddixin","Admin\DixinController@doadddixin");
//薪资管理1.人员页面展示
Route::resource("/xinzi","Admin\XinziController");
//结算页面
Route::get("/jiesuan","Admin\XinziController@jiesuan");
Route::get("/dojiesuan","Admin\XinziController@dojiesuan");
//结算工资表详情
Route::get("/jiesuaninfo","Admin\XinziController@jiesuaninfo");
Route::get("/jiesuandel","Admin\XinziController@jiesuandel");


//红包管理
Route::resource("/hongbao","Admin\HongbaoController");
//添加红包
Route::get("/addhongbao","Admin\HongbaoController@addhongbao");
Route::get("/dohongbao","Admin\HongbaoController@dohongbao");
//修改红包
Route::get("/edithongbao","Admin\HongbaoController@edithongbao");
Route::get("/doedithongbao","Admin\HongbaoController@doedithongbao");
//删除红包
Route::get("/delhongbao","Admin\HongbaoController@delhongbao");
//值班管理
Route::resource("/zhiban","Admin\ZhibanController");
//值班添加
Route::get("/addzhiban","Admin\ZhibanController@addzhiban");
Route::get("/doaddzhiban","Admin\ZhibanController@doaddzhiban");
//值班修改
Route::get("/editzhiban","Admin\ZhibanController@editzhiban");
Route::get("/doeditzhiban","Admin\ZhibanController@doeditzhiban");
//值班删除
Route::get("/delzhiban","Admin\ZhibanController@delzhiban");


//惩罚管理
Route::resource("/fakuan","Admin\FakuanController");
//新增罚款
Route::get("/addfakuan","Admin\FakuanController@addfakuan");
Route::get("/doaddfakuan","Admin\FakuanController@doaddfakuan");
//修改罚款
Route::get("/editfakuan","Admin\FakuanController@editfakuan");
Route::get("/doeditfakuan","Admin\FakuanController@doeditfakuan");
//删除罚款
Route::get("/delfakuan","Admin\FakuanController@delfakuan");














