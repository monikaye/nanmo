@extends("Admin.AdminPublic.adminpublic")
@section("admin")
<div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     <h2>售后信息</h2>
                </div>
                <div id="dataTables-example_filter" class="dataTables_filter" >
                    <form action="/saled"  method="post" enctype="multipart/form-data" style="padding:15px;">
                        <label>微信名</label>
                        <label>
                            <input type="search" class="form-control input-sm date" value="{{$map[1][2] or ''}}" name='wxname'>
                        </label>
                       <label>本金金额</label>
                        <label>
                            <input type="search" class="form-control input-sm date" value="{{$map[2][2] or ''}}" placeholder='大于'  name='fbig'>
                        </label>
                        <label>
                            <input type="search" class="form-control input-sm date" value="{{$map[3][2] or ''}}" placeholder='小于'  name='fsmall'>
                        </label>
                        <label>
                            <select class="form-control input-sm" name="phoneid">
                                <option value="">所在手机编号</option>
                                @foreach($phone as $va)
                                <option value="{{$va->id}}" @if($va->id==session('pid')) selected @endif >{{$va->phonenum}}</option>
                                @endforeach
                            </select>
                        </label>
                        <label>
                            <select class="form-control input-sm" name="fphone">
                                <option value="">赔偿手机编号</option>
                                @foreach($phone as $vc)
                                <option value="{{$vc->id}}"  @if($vc->id==session('fpid')) selected @endif>{{$vc->phonenum}}</option>
                                @endforeach
                            </select>
                        </label>
                        <br>
                        <label>旺旺号</label>
                        <label>
                            <input type="search" class="form-control input-sm date" value="{{$map[6][2] or ''}}"  name='wname'>
                        </label>
                        <label>赔偿金额</label>
                        <label>
                            <input type="search" class="form-control input-sm date" value="{{$map[7][2] or ''}}"  placeholder='大于'  name='sbig'>
                        </label>
                        <label>
                            <input type="search" class="form-control input-sm date" value="{{$map[8][2] or ''}}"  placeholder='小于'  name='ssmall'>
                        </label>
                        <label>
                            <select class="form-control input-sm" name="fuserid">
                                <option value="">请选择放单人</option>
                                @foreach($fuser as $value)
                                <option value="{{$value->fid}}" @if($value->fid==session('fud')) selected @endif>{{$value->fname}}</option>
                                @endforeach
                            </select>
                        </label>
                        <label>
                            <select class="form-control input-sm" name="result">
                                <option value="">处理结果</option>
                                <option value="1" @if(session('result')==1) selected @endif>处理成功</option>
                                <option value="2" @if(session('result')==2) selected @endif>处理中</option>
                                <option value="3" @if(session('result')==3) selected @endif>处理失败</option>
                            </select>
                        </label>
                        <br>
                        <label>订单号</label>
                        <label>
                            <input type="search" class="form-control input-sm date" value="{{$map[11][2] or ''}}"  name='orders'>
                        </label>
                        <label>发生日期</label>
                        <label>
                            <input type="search" class="form-control input-sm date" value="{{$map[12][2] or ''}}"  placeholder='开始:20180911' name='hbig'>
                        </label>
                        <label>
                            <input type="search" class="form-control input-sm date" value="{{$map[13][2] or ''}}"  placeholder='结束:20180911' name='hsmall'>
                        </label>
                        <label>
                            <select class="form-control input-sm" name="huohao">
                                <option value="">货号</option>
                                @foreach($huohao as $val)
                                <option value="{{$val->id}}" @if($val->id==session('hh')) selected @endif>{{$val->huohao}}</option>
                                @endforeach
                            </select>
                        </label>
                        <label>
                            <select class="form-control input-sm sh" name="shopid">
                                <option value="">店铺</option>
                                @foreach($shop as $ve)
                                <option value="{{$ve->id}}" @if($val->id==session('shp')) selected @endif>{{$ve->shopname}}</option>
                                @endforeach
                            </select>
                        </label>
                        <label>
                            {{csrf_field()}}
                            <input type="submit" class="form-control input-sm date"  value='搜索'>
                        </label>
                            <a href="/saled_daochu" class="btn btn-info">导出</a>
                    </form>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>微信备注名</th>
                                    <th>所在手机编号</th>
                                    <th>旺旺号</th>
                                    <th>店铺名称</th>
                                    <th>货号</th>
                                    <th>发生日期</th>
                                    <th>放单人</th>
                                    <th>本金</th>
                                    <th>订单号</th>
                                    <th>赔偿手机</th>
                                    <th>原因</th>
                                    <th>处理结果</th>
                                    <th>赔偿金额</th>
                                    <th>完结日期</th>
                                    <th>处理人</th>
                                    <th>操作时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
								@foreach($info as $value)
                                <tr class="odd gradeX">
                                    <td>{{$value->wxname}}</td>
                                    <td>{{$value->phonenum}}</td>
                                    <td>{{$value->wwname}}</td>
                                    <td>{{$value->shopname}}</td>
                                    <td>{{$value->huohao}}</td>
                                    <td>{{$value->hap_time}}</td>
                                    <td>{{$value->username}}</td>
                                    <td>{{$value->fmoney}}</td>
                                    <td>{{$value->orders}}</td>
                                    <td>{{$value->fphone}}</td>
                                    <td>{{$value->why}}</td>
                                    @if($value->result==1)
                                    <td>处理成功</td>
                                    @elseif($value->result==2)
                                    <td>处理中</td>
                                    @elseif($value->result==3)
                                    <td>处理失败</td>
                                    @else
                                    <td></td>
                                    @endif
                                    <td>{{$value->smoney}}</td>
                                    <td>{{$value->over_time}}</td>
                                    <td>{{$value->uname}}</td>
                                    <td><?php echo Date("Y-m-d H:i:s", $value->create_time); ?></td>
                                    <td>
                                    	<form action="/saled/{{$value->id}}" method="post" class="btn">
							                <button class="btn btn-danger">删除</button>{{csrf_field()}}{{method_field("DELETE")}}
							            </form>
                                        <a href="/saled/{{$value->id}}/edit" class="btn btn-info">修改</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="javascript:void(0)" onclick="page(<?php echo $prev ?>)" class="btn btn-info"><<</a>
                    @if($sums <= 10)
                        @foreach($pp as $key=>$val)
                            @if($val == $page)
                            {{$val}}
                            @else
                            <a href="javascript:void(0)" onclick="page({{$val}})">{{$val}}</a>
                            @endif
                        @endforeach
                    @else
                        
                        @if($page<=3)
                            @if($page==1)
                            1
                            @else
                            <a href="javascript:void(0)" onclick="page(1)">1</a>
                            @endif
                            @if($page==2)
                            2
                            @else
                            <a href="javascript:void(0)" onclick="page(2)">2</a>
                            @endif
                            @if($page==3)
                            3
                            @else
                            <a href="javascript:void(0)" onclick="page(3)">3</a>
                            @endif
                            <a href="javascript:void(0)">...</a>
                            <a href="javascript:void(0)" onclick="page(<?php echo $sums ?>)">{{$sums}}</a>
                            @elseif($page>3 && ($sums-$page) >=3)
                            <a href="javascript:void(0)" onclick="page(1)">1</a>
                            <a href="javascript:void(0)">...</a>
                            <a href="javascript:void(0)" onclick="page(<?php echo $prev ?>)"><?php echo $prev; ?></a>
                            {{$page}}
                            
                            <a href="javascript:void(0)" onclick="page(<?php echo $next ?>)"><?php echo $next; ?></a>
                            <a href="javascript:void(0)">...</a>
                            <a href="javascript:void(0)" onclick="page(<?php echo $sums ?>)">{{$sums}}</a>
                            @elseif(($sums-$page) <3)
                            <a href="javascript:void(0)" onclick="page(1)">1</a>
                            <a href="javascript:void(0)">...</a>
                            @if($page==($sums-2))
                                {{$sums-2}}
                            @else
                            <a href="javascript:void(0)" onclick="page(<?php echo $sums-2 ?>)">{{$sums-2}}</a>
                            @endif
                            @if($page==($sums-1))
                                {{$sums-1}}
                            @else
                            <a href="javascript:void(0)" onclick="page(<?php echo $sums-1 ?>)">{{$sums-1}}</a>
                            @endif
                            @if($page==$sums)
                                {{$sums}}
                            @else
                            <a href="javascript:void(0)" onclick="page(<?php echo $sums ?>)">{{$sums}}</a>
                            @endif
                        @endif
                            
                    @endif
                    <a href="javascript:void(0)" onclick="page(<?php echo $next ?>)" class="btn btn-info">>></a>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
</div>
<script src="/Admin/assets/js/jquery-1.8.3.min.js"></script>
<script>
    function page(page){
        // alert(page);
        $.ajax({
            type:"get",
            url:"/page_pro_saled",
            data:{
            page:page,
        },
        success:function(msg){
                if(msg){
                    $(".panel-body").html(msg)
                }else {
                    
                    alert('无输出');
                }
            }
        });
    }
    function daochu(){
        var wxname  = $('input[name="wxname"]').val();
        var wwname  = $('input[name="wwname"]').val();
        var orders  = $('input[name="orders"]').val();
        var fbig    = $('input[name="fbig"]').val();
        var fsmall  = $('input[name="fsmall"]').val();
        var sbig    = $('input[name="sbig"]').val();
        var ssmall  = $('input[name="ssmall"]').val();
        var hbig    = $('input[name="hbig"]').val();
        var hsmall  = $('input[name="hsmall"]').val();
        var phoneid = $('select[name="phoneid"]').val();
        var fuserid = $('select[name="fuserid"]').val();
        var huohao  = $('select[name="huohao"]').val();
        var fphone  = $('select[name="fphone"]').val();
        var reslut  = $('select[name="reslut"]').val();
        var shopid  = $('select[name="shopid"]').val();
        $.ajax({
            type:"get",
            url:"/saled_daochu",
            data:{
            wxname : wxname,
            wwname : wwname,
            orders : orders,
            fbig   : fbig,
            fsmall : fsmall,
            sbig   : sbig,
            ssmall : ssmall,
            hbig   : hbig,
            hsmall : hsmall,
            phoneid: phoneid,
            fuserid: fuserid,
            huohao : huohao,
            fphone : fphone,
            reslut : reslut,
            shopid : shopid
        },
        success:function(msg){
                if(msg){
                    // $(".panel-body").html(msg)
                    // alert(msg);
                }else {
                    
                    alert(2);
                }
            }
        });
    }


</script>
@endsection
@section('title','售后')