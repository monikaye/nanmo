
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
                                    <label>值班小组长</label>
                                    <select class="form-control fuserid" name="fuserid">
                                        @foreach($fuser as $v)
                                        <option value="{{$v->id}}" @if($v->id==$info->fuserid) selected @endif>{{$v->username}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" value='{{$info->id}}' class='di'>
                                <div class="form-group">
                                    <label>值班日期</label>
                                    <input class="form-control" type="text" name="shuadan_time" value='{{$info->shuadan_time}}' placeholder='格式为:20181011'/>
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
                                var id  = $('.di').val();
                                //获取要放单人id
                                var fid = $(".fuserid").val();
                                //获得值班日期
                                var st  = $('input[name="shuadan_time"]').val();
                                //判断
                                if(fid == "") {
                                    alert("请选择值班小组长");
                                    return false;
                                }
                                if(st == "" ){
                                    alert("请输入正确的值班日期");
                                    return false;
                                }
                                $.ajax({
                                    type:"get",
                                    url:"/doeditzhiban",
                                    data:{
                                        id:id,
                                        fid:fid,
                                        st:st
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


