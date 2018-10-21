@extends("Admin.AdminPublic.adminpublic")
@section("admin")
<div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     <h2>银行卡信息</h2>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>银行卡号</th>
                                    <th>银行卡卡主</th>
                                    <th>卡内额余</th>
				                    <th>总额余</th>
                                    <th>已绑定手机数量</th>
                                    <th>手机编号</th>
                                    <th>状态</th>
                                    <th>添加时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
								@foreach($info as $value)
                                <tr class="odd gradeX">
									
                                    <td>{{$value->number}}</td>
                                    <td>{{$value->cardname}}</td>
                                    <td>{{$value->money}}</td>
				                    <td>{{$value->smoney}}</td>
                                    <td>{{$value->count}}</td>
                                    <td>{{$value->phonenum}}</td>
                                    @if($value->status==1)
                                    <td value="0" ddd="{{$value->id}}" class="status">开启中</td>
                                    @else
                                    <td value="1" ddd="{{$value->id}}" class="status">已禁用</td>
                                    @endif
                                    <td><?php echo date('Y-m-d',$value->create_time) ?></td>
                                    <td>
                                    	<form action="/card/{{$value->id}}" method="post" class='btn'>
							                <button class="btn btn-danger">删除</button>{{csrf_field()}}{{method_field("DELETE")}}
							            </form>
                                        <a href="/card/{{$value->id}}/edit" class="btn btn-info">修改</a>
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!!$info->appends($request)->render()!!}
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
</div>
<script src="/Admin/assets/js/jquery-1.8.3.min.js"></script>
<script>
    $(".status").click(function(){
        // alert($(this).attr("ddd"));
        var sta = $(this);
        //获取cardid
        var cid = sta.attr("ddd");
        //获取要更改的值
        var val = sta.attr("value");
        $.ajax({
            type:"get",
            url:"/stacard",
            data:{
                cid:cid,
                val:val,
            },
            success:function(msg){
                if(msg == 1 ){
                    location.reload();
                    alert('修改状态成功');
                }else {
                    alert("修改状态失败");
                }
            }
        });
    });


</script>
                <!-- /. ROW  -->
@endsection
@section('title','银行卡信息表')