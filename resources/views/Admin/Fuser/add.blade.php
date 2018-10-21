
@extends("Admin.AdminPublic.adminpublic")
@section("admin")
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    添加放单人
                </div>
                @if(count($errors)>0)
                    @foreach ($errors->all() as $error)
                        <div class="mws-form-message error">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form"  onsubmit="return false" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label>放单人名称</label>
                                    <input class="form-control user" type="text" name="username"/>
                                </div>
                                <!--
                                <div class="form-group">
                                    <label>File input</label>
                                    <input type="file">
                                </div>
                                 -->
                                {{csrf_field()}}
                                <button type="submit" class="btnbtn ">添加</button>
                                <!-- <button type="reset" class="btn btn-default">Reset Button</button> -->
                            </form>
                        </div>

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <script src="/Admin/assets/js/jquery-1.8.3.min.js"></script>
    <script>
        $(".btnbtn").click(function(){

            var user = $(".user").val();


            $.ajax({
                type:"get",
                url:"/fuseradd",
                data:{
                    user:user,
                },
                success:function(msg){
//                    alert(msg);
                    if(msg==1){
                        alert('添加成功');
                        $(".user").val("");
                    }else if(msg == 2){
                        alert("放单人已存在");
                        $(".user").val("");
                    }else if(msg == 0){
                        alert('请填写放单人');
                    }else {
                        alert('添加失败');
                        $(".user").val("");
                    }
                }
            });
        });
    </script>

@endsection
@section('title','放单人添加')