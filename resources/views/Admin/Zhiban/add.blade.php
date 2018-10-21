
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
                                    <label>值班小组长</label>
                                    <select class="form-control fuserid" name="fuserid">
                                        <option value="">请选择</option>
                                        @foreach($fuser as $v)
                                        <option value="{{$v->id}}">{{$v->username}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>值班日期</label>
                                    <input class="form-control" type="text" name="shuadan_time" placeholder='格式为:20181011'/>
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
                                //获取要放单人id
                                var id = $(".fuserid").val();
                                //获得值班时间
                                var st = $('input[name="shuadan_time"]').val();
                                //判断
                                if(id == "") {
                                    alert("请选择值班小组长");
                                    return false;
                                }
                                if(st == ""){
                                    alert("请输入值班时间");
                                    return false;
                                }
                                
                                // alert(66);
                                $.ajax({
                                    type:"get",
                                    url:"/doaddzhiban",
                                    data:{
                                        id:id,
                                        st:st
                                    },
                                    success:function(msg){
                                        if(msg == 1){
                                            alert("添加成功");
                                            $('input[name="shuadan_time"]').val(" ");
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


