
<div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     <h2>{{$name or ""}}</h2>
                </div>
                <div class="panel-body">
                    <div class="col-lg-6">
                        <form role="form" onsubmit="return false"  enctype="multipart/form-data">
                            <label>拼接计算工资字段</label><br>
                            <label>
                                <select class="form-control input-sm" name="jx">
                                    <option value="">无绩效</option>
                                    <option value="1">组员绩效</option>
                                    <option value="2">小组长绩效</option>
                                    <option value="3">大组长绩效</option>
                                </select>
                            </label> +
                            <label>
                                <select class="form-control input-sm" name="dx">
                                    <option value="">无底薪</option>
                                    @foreach($dixin as $va)
                                    <option value="{{$va->id}}">{{$va->dixin}}</option>
                                    @endforeach
                                </select>
                            </label> +
                            <label class="checkbox-inline">
                                <input type="checkbox" name='a_vement' value="a_vement">成就奖金
                            </label> +
                            <label class="checkbox-inline">
                                <input type="checkbox" name='chengfa' value="chengfa">惩罚奖励
                            </label> +
                            <label class="checkbox-inline">
                                评测金
                            </label>
                            <label class="checkbox-inline">
                                <input type="text" class="form-control input-sm" name='test'>
                            </label>
                            <br><br><br><br>
                            <button class="btn btn-info" value="{{$id}}">结算</button>
                        </form>
                    </div>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
</div>
<script src="/Admin/assets/js/jquery-1.8.3.min.js"></script>
<script>
    $('.btn').click(function(){
        var btn  = $(this);
        //获取fuserid
        var fid  = btn.attr('value');
        //获取绩效方法
        var jx   = $('select[name="jx"]').val();
        //获取底薪
        var dx   = $('select[name="dx"]').val();
        //获取成就
        var cj   = $('input[name="a_vement"]').attr('checked');
        if(cj == undefined){
            cj = "";
        }
        //获取惩罚奖励
        var fj   = $('input[name="chengfa"]').attr('checked');
        if(fj == undefined){
            fj = "";
        }
        //获取评测金
        var pc   = $('input[name="test"]').val();
        // alert(pc)
        $.ajax({
            type:"get",
            url:"/dojiesuan",
            data:{
                fid:fid,
                jx:jx,
                dx:dx,
                cj:cj,
                fj:fj,
                pc:pc
            },
            success:function(msg){
                if(msg == 1){
                    alert('结算成功');
                }else if(msg == 2){
                    
                    alert('结算失败');
                }else if(msg == 3){
                    alert('本月工资已结算');
                }
            }
        });
    });


</script>
                <!-- /. ROW  -->

