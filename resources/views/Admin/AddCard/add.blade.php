
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
                                    <label>卡号</label>
                                    <select class="form-control cardid" name="cardid">
                                        <option value="">请选择</option>
                                        @foreach($card as $v)
                                        <option value="{{$v->id}}">{{$v->namenumber}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>充值金额</label>
                                    <input class="form-control" type="text" name="addmoney"/>
                                </div>
                                <div class="form-group">
                                    <label>充值时间</label>
                                    <input class="form-control" type="text" name="addtime"/>
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
                                 {{csrf_field()}}
                                <a  class="btn " >添加</a>
                                <!-- <button type="reset" class="btn btn-default">Reset Button</button> -->
                            </form>
                        </div>
                        <script src="/Admin/assets/js/jquery-1.8.3.min.js"></script>
                        <script>
                        // alert($);
                            $('.btn').click(function(){
                                //获取要充值的银行卡id
                                var id = $(".cardid").val();
                                //获得要充值的金额
                                var my = $('input[name="addmoney"]').val();
                                //获得要充值的时间
                                var at = $('input[name="addtime"]').val();
                                //获取备注
                                var bz = $('input[name="remark"]').val();
                                //判断
                                if(id == "") {
                                    alert("请选择要充值的银行卡");
                                    return false;
                                }
                                if(my == "" || my <= 0){
                                    alert("请输入正确的金额");
                                    return false;
                                }

                                $.ajax({
                                    type:"get",
                                    url:"/addd",
                                    data:{
                                    id:id,
                                    my:my,
                                    bz:bz,
                                    at:at
                                },
                                success:function(msg){
                                        if(msg == 1){
                                            alert("添加成功");
                                            $('input[name="addmoney"]').val(" ");                                            
                                        }else {
                                            
                                            alert('请选择要删除的对象');
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


@section('title','银行卡充值')