
<div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     <h2>值班</h2>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>值班小组长</th>
                                    <th>值班日期</th>
                                    <th>录入人</th>
                                    <th>添加时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
								@foreach($info as $value)
                                <tr class="odd gradeX">
                                    <td>{{$value->username}}</td>
                                    <td>{{$value->shuadan_time}}</td>
                                    <td>{{$value->userid}}</td>
                                    <td>
                                        <?php echo date('Y-m-d H:i:s',$value->create_time);?>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger del"  value="{{$value->id}}">删除</a>
                                        <a class="btn btn-info edit" value="{{$value->id}}">修改</a>
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
            url:"/zhiban",
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
            url:"/delzhiban",
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

