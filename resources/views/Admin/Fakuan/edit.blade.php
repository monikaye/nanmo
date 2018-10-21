
<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    edit
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
                            <form role="form" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label>被罚款人</label>
                                    <select class="form-control bcfuserid" name="bcfuserid">
                                        @foreach($fuser as $value)
                                        <option value="{{$value->id}}" @if($value->id == $info->bcfuserid) selected @endif>{{$value->username}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>监督人</label>
                                    <select class="form-control cfuserid" name="cfuserid">
                                        @foreach($fuser as $v)
                                        <option value="{{$v->id}}" @if($v->id == $info->cfuserid) selected @endif>{{$v->username}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>罚款金额</label>
                                    <input class="form-control" type="text" name="money" value='{{$info->money}}'>
                                </div>
                                <input type="hidden" value='{{$info->id}}' class='di'>
                                <div class="form-group">
                                    <label>罚款日期</label>
                                    <input class="form-control" type="text" name="shuadan_time" value='{{$info->shuadan_time}}' placeholder='格式为:20181011'/>
                                </div>
                                <div class="form-group">
                                    <label>备注</label>
                                    <input class="form-control" type="text" name="remark" value='{{$info->remark}}'>
                                </div>
                                <!-- 
                                <div class="form-group">
                                    <label>File input</label>
                                    <input type="file">
                                </div>
                                 -->
                                <a  class="btn" >修改</a>
                                <!-- <button type="reset" class="btn btn-default">Reset Button</button> -->
                            </form>
                        </div>
                        <script src="/Admin/assets/js/jquery-1.8.3.min.js"></script>
                        <script>
                        // alert($);
                            $('.btn').click(function(){
                                //获得要修改的id
                                var  id   = $('.di').val();
                                //获取要被罚款人id
                                var bcfid = $(".bcfuserid").val();
                                //获得监督人id
                                var cfid  = $(".cfuserid").val();
                                //获得罚款金额
                                var fj    = $("input[name='money']").val();
                                //获得罚款日期
                                var st    = $("input[name='shuadan_time']").val();
                                //获取备注
                                var rk    = $("input[name='remark']").val();
                                //判断
                                if(bcfid == "") {
                                    alert("请选择被罚款人");
                                    return false;
                                }
                                if(cfid  == "") {
                                    alert("请选择监督人");
                                    return false;
                                }
                                if(fj    == "") {
                                    alert("请输入罚款金额");
                                    return false;
                                }
                                if(st    == "" ){
                                    alert("请输入罚款时间");
                                    return false;
                                }
                                $.ajax({
                                    type:"get",
                                    url:"/doeditfakuan",
                                    data:{
                                        id:id,
                                        bcfid:bcfid,
                                        cfid:cfid,
                                        fj:fj,
                                        st:st,
                                        rk:rk
                                    },
                                    success:function(msg){
                                        if(msg == 1){
                                            alert("修改成功");
                                        }else {
                                            alert('修改失败');
                                        }
                                    }
                                });
                            });
                        </script>
                        
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
</div>


