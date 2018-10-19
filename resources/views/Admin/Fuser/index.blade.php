
<div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     <h2>放单人信息</h2>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>放单人姓名</th>
                                    <th>状态</th>
                                    <th>本日单量</th>
                                    <th>本月单量</th>
                                    <th>本年单量</th>
                                    <th>日进斗金月次数</th>
                                    <th>日进斗金年次数</th>
                                    <th>坚挺一周次数</th>
                                    <th>积分</th>
                                    <th>成就</th>
                                    <th>添加时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
								@foreach($info as $value)
                                <tr class="odd gradeX">
									
                                    <td>{{$value->username}}</td>
                                    @if($value->status==1)
                                    <td>开启</td>
                                    @else
                                    <td>关闭</td>
                                    @endif
                                    <td>{{$value->daysum}}</td>
                                    <td>{{$value->mouthsum}}</td>
                                    <td>{{$value->yearsum}}</td>
                                    <td>{{$value->mRjdj}}</td>
                                    <td>{{$value->yRjdj}}</td>
                                    <td>{{$value->j_t_y_z}}</td>
                                    <td>积分</td>
                                    <td>成就</td>
                                    <td><?php echo date('Y-m-d',$value->create_time) ?></td>
                                    <td>
                                    	<form action="/fuser/{{$value->id}}" method="post" class='btn'>
							                <button class="btn btn-danger">删除</button>{{csrf_field()}}{{method_field("DELETE")}}
							            </form>
                                        <a href="/fuser/{{$value->id}}/edit" class="btn btn-info">修改</a>
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
                <!-- /. ROW  -->
<script src="/Admin/assets/js/jquery-1.8.3.min.js"></script>
<script>
    function page(page){
        // alert(page);
        $.ajax({
            type:"get",
            url:"/fuser",
            data:{
            page:page,
        },
        success:function(msg){
                if(msg){
                    $("#page-inner").html(msg)
                }else {
                    
                    alert('无输出');
                }
            }
        });
    }



</script>
@section('title','放单人信息表')