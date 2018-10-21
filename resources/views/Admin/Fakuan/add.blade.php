
<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add
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
                                        <option value="">请选择</option>
                                        @foreach($fuser as $v)
                                        <option value="{{$v->id}}">{{$v->username}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>监督人</label>
                                    <select class="form-control cfuserid" name="cfuserid">
                                        <option value="">请选择</option>
                                        @foreach($fuser as $v)
                                        <option value="{{$v->id}}">{{$v->username}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>罚款金额</label>
                                    <input class="form-control" type="text" name="money"/>
                                </div>
                                <div class="form-group">
                                    <label>罚款日期</label>
                                    <input class="form-control" type="text" name="shuadan_time" placeholder='格式为:20181011'/>
                                </div>
                                <div class="form-group">
                                    <label>备注</label>
                                    <input class="form-control" type="text" name="remark"/>
                                </div>
                                <!-- 
                                <div class="form-group">
                                    <label>File input</label>
                                    <input type="file">
                                </div>
                                 -->
                                <a  class="btn" >添加</a>
                                <!-- <button type="reset" class="btn btn-default">Reset Button</button> -->
                            </form>
                        </div>
                        <script src="/Admin/assets/js/jquery-1.8.3.min.js"></script>
                        <script>
                        // alert($);
                            $('.btn').click(function(){
                                //获取要被惩罚人id
                                var bcid = $(".bcfuserid").val();
                                //获取要监督人id
                                var cid  = $(".cfuserid").val();
                                //获得惩罚时间
                                var st   = $('input[name="shuadan_time"]').val();
                                //获得惩罚金额
                                var fj   = $('input[name="money"]').val();
                                //获得备注
                                var rk   = $('input[name="remark"]').val();
                                //判断
                                if(bcid == "") {
                                    alert("请选择被惩罚人");
                                    return false;
                                }
                                if(bcid == cid){
                                    alert("被惩罚人与监督人不能为一个人");
                                    return false;
                                }
                                if(st == ""){
                                    alert("请输入惩罚时间");
                                    return false;
                                }
                                if(fj == ""){
                                    alert("请输入惩罚金额");
                                    return false;
                                }
                                
                                // alert(66);
                                $.ajax({
                                    type:"get",
                                    url:"/doaddfakuan",
                                    data:{
                                        bcid:bcid,
                                        cid:cid,
                                        st:st,
                                        fj:fj,
                                        rk:rk
                                    },
                                    success:function(msg){
                                        if(msg == 1){
                                            alert("添加成功");
                                            $('input[name="shuadan_time"]').val(" ");
                                            $('input[name="money"]').val(" ");
                                            $('input[name="remark"]').val(" ");
                                        }else {
                                            
                                            alert('添加失败');
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


