
@extends("Admin.AdminPublic.adminpublic")
@section("admin")
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    创建失误
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
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label>失误人</label>
                                    <select class="form-control bcfuserid bf" name="bcfuserid" onblur="renz(bcfuserid)" data-test="失误人">
                                        <option value="">请选择</option>
                                        @foreach($fuser as $value)
                                            <option  value="{{$value->id}}">{{ $value->username }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label>刷单时间</label>
                                    <input class="form-control time bf" type="text" name="time" onblur="renz(time)"  data-test="刷单时间"/>
                                </div>
                                <div class="form-group ">
                                    <label>金额</label>
                                    <input class="form-control remark money" type="text" name="money" onblur="renz(money)"  data-test="金额"/>
                                </div>
                                <div class="form-group ">
                                    <label>描述</label>
                                    <input class="form-control remark bf" type="text" name="remark" onblur="renz(remark)"  data-test="描述"/>
                                </div>
                                <div class="form-group ">
                                    <label>监督人</label>
                                    <select class="form-control cfuserid bf" name="cfuserid" onblur="renz(cfuserid)" data-test="监督人">
                                        <option value="">请选择</option>
                                        @foreach($fuser as $value)
                                            <option  value="{{$value->id}}">{{ $value->username }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label>入录人</label>
                                    <select class="form-control userid bf" name="userid" onblur="renz(userid)" data-test="入录人">
                                        <option value="">请选择</option>
                                        @foreach($user as $value)
                                            <option  value="{{$value->id}}">{{ $value->username }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btnbtn ">添加</button>
                                {{--type="submit"--}}
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

        //        function renz(a) {
        ////            alert(a);
        //            $(a).parent().append('<div>'+'必填'+'</div>');
        //        }


        $(".bcfuserid").change(function(){
            if($(this).val() == ""){
                $(this).css("background-color","#D6D6FF");
                alert("请选择失误人");
                return false;
            }else{
                $(this).css("background-color","#fff");
            }
        });

        $(".time").blur(function(){
            if($(this).val()==""){
                $(this).css("background-color","#D6D6FF");
                alert("请填写时间");
                return false;
            }else{
                $(this).css("background-color","#fff");
            }

        });

        $(".money").blur(function() {
            if($(this).val()==""){
                $(this).css("background-color", "#D6D6FF");
                alert("请填写金额");
                return false;
            }else{
                $(this).css("background-color","#fff");
            }
        });

        $(".remark").blur(function() {
            if($(this).val()==""){
                $(this).css("background-color", "#D6D6FF");
                alert("请填写描述");
                return false;
            }else{
                $(this).css("background-color","#fff");
            }
        });

        $(".cfuserid").change(function(){
            if($(this).val() == ""){
                $(this).css("background-color","#D6D6FF");
                alert("请填写监督人");
                return false;
            }else{
                $(this).css("background-color","#fff");
            }
        });

        $(".userid").change(function() {
            if ($(this).val() == "") {
                $(this).css("background-color","#D6D6FF");
                alert("请填写入录人");
                return false;
            }else{
                $(this).css("background-color","#fff");
            }
        });


        $(".btnbtn").click(function(){
//            alert(121);
            // alert($(this).attr("ddd"));
            var bcfuserid = $(".bcfuserid").val();
            if(bcfuserid == ""){
                alert("请选择失误人");
                return false;
            }

            var time = $(".time").val();
            if(time == ""){
                alert("请填写时间");
                return false;
            }

            var money = $(".money").val();
            if(money == ""){
                alert("请填写金额");
                return false;
            }

            var remark = $(".remark").val();
            if(remark == ""){
                alert("请填写描述");
                return false;
            }

            var cfuserid = $(".cfuserid").val();
            if(cfuserid == ""){
                alert("请选择监督人");
                return false;
            }

            var userid = $(".userid").val();
            if(userid == ""){
                alert("请选择入录人");
                return false;
            }
            $.ajax({
                type:"get",
                url:"/errorcreate",
                data:{
                    bcfuserid:bcfuserid,
                    cfuserid:cfuserid,
                    time:time,
                    money:money,
                    remark:remark,
                    userid:userid,
                },

                success:function(msg){
                    if(msg == 1 ){
                        alert('添加成功');
                        location.reload();
                    }else {
                        alert("添加失败");
                    }
                }
            });
        });

    </script>

@endsection
@section('title','添加失误')
