
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             智度汇总表
                        </div>
                        <div id="dataTables-example_filter" class="dataTables_filter" >
                            <form style="padding:15px;" role="form" action='/zhiridaochuview' method='get'>
                                <div class="form-group">
                                    <label>放单日期
                                        <select class="form-control input-sm" name="shuadan_time">
                                            <option value="">选择日期</option>
                                            @foreach($shuadan_time as $va)
                                            <option value="{{$va->shuadan_time}}">{{$va->shuadan_time}}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <button type="submit" class="btn">导出</button>
                                </div>
                                
                            </form>
                        </div>
                        <div class="panel-body">
                            
                            
                        </div>
                    </div>
                <!-- /. ROW  -->
                <script src="/Admin/assets/js/jquery-1.8.3.min.js"></script>
                <script>
                    $(".input-sm").bind("change",function(){
                        var time    = $(this);
                        var timeval = $(this).val();
                        // alert(time);
                        if(timeval != ''){
                            $.ajax({
                                type:"get",
                                url:"/zhidus",
                                data:{
                                timeval:timeval,
                            },
                            success:function(msg){
                                    if(msg){
                                        $(".panel-body").html(msg)
                                        // alert(66);
                                    }else {
                                        
                                        alert('无输出');
                                    }
                                }
                            });
                        }
                    });
                    $('.btn').click(function(){
                        if ($('.input-sm').val() == '') {
                            alert('请先选择要导出的日期');
                        } else {
                            var timeval = $(".input-sm").val();
                            $.ajax({
                                type:"get",
                                url:"/zhiridaochu",
                                data:{
                                timeval:timeval,
                            },
                            success:function(msg){
                                    if(msg){
                                        // $(".panel-body").html(msg)
                                        alert(msg);
                                    }else {
                                        
                                        alert('无输出');
                                    }
                                }
                            });
                        }
                    });
                </script> 
               

@section('title','智度表')