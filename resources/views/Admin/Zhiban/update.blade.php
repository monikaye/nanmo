    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    修改值班员
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


                                <div class="form-group">
                                    <label>修改值班员</label>
                                    <select class="form-control fuserid" name="fuserid">
                                        <option value="">请选择</option>

                                        @foreach($info   as $values)

                                            <option value="{{$values->id}}" @if($values->id == $data->fuserid) selected @endif>{{$values->username}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>时间</label>
                                    <input class="form-control utime" type="text" name="time" value="{{$data->shuadan_time}}"/>
                                </div>
                                {{csrf_field()}}
                            <input type="hidden" class="idd" value="{{ $data->id }}"/>
                                <button type="submit" class="btn btneditok" >修改</button>
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
        $(".btneditok").click(function(){
//            alert(121);
            // alert($(this).attr("ddd"));
            var name = $(".uname").val();
            var time = $(".utime").val();
            var id = $(".idd").val();
            var fuseridd = $(".fuserid").val();

            $.ajax({
                type:"get",
                url:"/zhibanupdateok",
                data:{
                    name:name,
                    time:time,
                    fuseridd:fuseridd,
                    id:id,

                },
                success:function(msg){
                    if(msg==1){
                        alert('修改成功');
                    }else {
                        alert("修改失败");
                    }
                }
            });
        });


    </script>