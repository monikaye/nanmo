@extends("Admin.AdminPublic.adminpublic")
@section("admin")

    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>值班员列表</h2>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>姓名</th>
                                <th>日期</th>
                                <th>创建时间</th>
                                {{--<th>修改时间</th>--}}
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $value)
                                <tr class="odd gradeX">

                                    <td>{{$value->username}}</td>
                                    <td>{{$value->shuadan_time}}</td>
                                    <td><?php echo date('Y-m-d',$value->create_time) ?></td>

                                    <td>
                                            <button class="btn btndelect" value="{{$value->id}}">删除</button>
                                        <a class="btn btnedit" value="{{$value->id}}">修改</a>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!!$data->appends($request)->render()!!}
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    <script src="/Admin/assets/js/jquery-1.8.3.min.js"></script>
    <script>
        $(".btndelect").click(function(){
//            alert(121);
            // alert($(this).attr("ddd"));
            var id = $(this).attr('value');
            var btndel = $(this);

            $.ajax({
                type:"get",
                url:"/zhibandel",
                data:{
                    id:id,

                },
                success:function(msg){
                    if(msg == 1 ){
                        btndel.parent().parent().remove();
                        alert('删除成功');
                    }else {
                        alert("删除失败");
                    }
                }
            });
        });


        $(".btnedit").click(function () {
//            alert(123);
            var id = $(this).attr('value');
//            var btnedit = $(this);
//            alert(id);
            $.ajax({
                type:"get",
                url:"/zhibanupdate",
                data:{
                    id:id
                },
                success:function(msg){
                    if(msg){
                        $("#page-inner").html(msg)
                    }else {
                        alert("删除失败");
                    }
                }
            })

        })
    </script>
    <!-- /. ROW  -->
@endsection
@section('title','小组长列表')

