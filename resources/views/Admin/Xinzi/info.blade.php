
<div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     <h2>已结算的工资信息</h2>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>姓名</th>
                                    <th>绩效</th>
                                    <th>底薪</th>
                                    <th>成就</th>
                                    <th>测评</th>
                                    <th>奖金</th>
                                    <th>罚金</th>
                                    <th>总计</th>
                                    <th>工资日期</th>
                                    <th>结算时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($info as $v)
                                <tr>
                                    <td>{{$v->fname}}</td>
                                    <td>{{$v->jixiao}}</td>
                                    <td>{{$v->dixin}}</td>
                                    <td>{{$v->a_vement}}</td>
                                    <td>{{$v->test}}</td>
                                    <td>{{$v->addmoney}}</td>
                                    <td>{{$v->famoney}}</td>
                                    <td>{{$v->jixiao + $v->dixin + $v->a_vement + $v->test + $v->addmoney + $v->famoney}}</td>
                                    <td>{{$v->js_time}}</td>
                                    <td><?php echo date('Y-m-d H:i:s', $v->create_time) ?></td>
                                    <td>
                                        <a class="btn btn-danger del"  value="{{$v->id}}">删除</a>
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
            url:"/jiesuaninfo",
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

    $('.del').click(function(){
        var id = $(this).attr('value');
        var dl = $(this);
        $.ajax({
            type:"get",
            url:"/jiesuandel",
            data:{
                id:id,
            },
            success:function(msg){
                if(msg == 1){
                    dl.parent().parent().remove();
                    alert('删除成功')
                }else {
                    
                    alert('删除失败');
                }
            }
        });
        
    });
    $('.edit').click(function(){
        var id = $(this).attr('value');
        $.ajax({
            type:"get",
            url:"/editzhiban",
            data:{
                id:id,
            },
            success:function(msg){
                if(msg){
                    $("#page-inner").html(msg)
                }else {
                    
                    alert('无输出');
                }
            }
        });
    });
</script>
                <!-- /. ROW  -->

