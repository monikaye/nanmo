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



</script>
