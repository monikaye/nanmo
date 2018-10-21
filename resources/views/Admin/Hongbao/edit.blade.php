
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
                                    <label>发红包手机</label>
                                    <select class="form-control phoneid" name="phoneid">
                                        <option value="">请选择</option>
                                        @foreach($phone as $v)
                                        <option value="{{$v->id}}" @if($v->id == $info->phoneid) selected @endif>{{$v->phonenum}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" value='{{$info->id}}' class='di'>
                                <div class="form-group">
                                    <label>红包单个金额</label>
                                    <input class="form-control" type="text" name="hmoney" value='{{$info->hmoney}}' />
                                </div>
                                <div class="form-group">
                                    <label>红包个数</label>
                                    <input class="form-control" type="number" name="number" value='{{$info->number}}'/>
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
                                //获取要手机id
                                var pid = $(".phoneid").val();
                                //获得红包单个金额
                                var hm  = $('input[name="hmoney"]').val();
                                //红包个数
                                var nu  = $('input[name="number"]').val();
                                //判断
                                if(id == "") {
                                    alert("请选择手机号");
                                    return false;
                                }
                                if(hm == "" || hm <= 0){
                                    alert("请输入正确的金额");
                                    return false;
                                }
                                if(nu <= 0){
                                    alert("请输入正确的红包个数");
                                    return false;
                                }
                                // alert(66);
                                $.ajax({
                                    type:"get",
                                    url:"/doedithongbao",
                                    data:{
                                        id:id,
                                        pid:pid,
                                        hm:hm,
                                        nu:nu
                                    },
                                    success:function(msg){
                                        if(msg == 1){
                                            alert("修改成功");
                                            $('input[name="hmoney"]').val(" ");
                                            $('input[name="number"]').val(" ");
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


