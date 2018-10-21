<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
//导入校验请求类
use App\Http\Requests\LoginRequest;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    //主页
    public function index(){
        return view("Admin.Index.index");
    }
    
    
}
