@extends("Admin.AdminPublic.adminpublic")
@section("admin")
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>错误中心</h2>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>错误人</th>
                                <th>备注</th>
                                <th>金额</th>
                                <th>下单日期</th>
                                <th>监督人</th>
                                <th>入录人</th>
                                <th>创建时间</th>

                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $value)
                                <tr class="odd gradeX">

                                    <td>{{$value->bcfusername}}</td>
                                    <td>{{$value->remark}}</td>
                                    <td>{{$value->money}}</td>
                                    <td>{{$value->shuadan_time}}</td>
                                    <td>{{$value->cfusername}}</td>
                                    <td>{{$value->username}}</td>
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
                    {{--{!!$data->appends($request)->render()!!}--}}
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
@section('title','错误中心')