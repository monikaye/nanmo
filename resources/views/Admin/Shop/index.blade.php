@extends("Admin.AdminPublic.adminpublic")
@section("admin")
<div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     <h2>店铺信息</h2>
                </div>
                <div id="dataTables-example_filter" class="dataTables_filter" >
                    <form action="/spsearch"  method="post" enctype="multipart/form-data" style="padding:15px;">
                        
                        <label>店铺名字</label>
                        <label>
                            <input type="search" class="form-control input-sm date" value="{{session('sn')}}" name='shopname'>
                        </label>
                        <label>
                            {{csrf_field()}}
                            <input type="submit" class="form-control input-sm date"  value='搜索'>
                        </label>
                    </form>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>店铺名称</th>
                                    <th>店铺编码</th>
                                    <th>已绑定的货号</th>
                                    <th>店铺地址</th>
                                    <th>店铺礼品</th>
                                    <th>特殊备注</th>
                                    <th>后台账号备注</th>
                                    <th>状态</th>
                                    <th>添加时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
								@foreach($info as $value)
                                <tr class="odd gradeX">
									
                                    <td>{{$value->shopname}}</td>
                                    <td>{{$value->bianma}}</td>
                                    <td>{{$value->huohao}}</td>
                                    <td>{{$value->address}}</td>
                                    <td>{{$value->gift}}</td>
                                    <td>{{$value->remark}}</td>
                                    <td>{{$value->htzh}}</td>
                                    @if($value->status==1)
                                    <td>开启</td>
                                    @else
                                    <td>关闭</td>
                                    @endif
                                    <td><?php echo date('Y-m-d',$value->create_time) ?></td>
                                    <td>
                                    	<form action="/shop/{{$value->id}}" method="post" class='btn'>
							                <button class="btn btn-danger">删除</button>{{csrf_field()}}{{method_field("DELETE")}}
							            </form>
                                        <a href="/shop/{{$value->id}}/edit" class="btn btn-info">修改</a>
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
            url:"/page_pro_shop",
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



</script>

@endsection
@section('title','银行卡信息表')