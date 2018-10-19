

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
                            <form role="form" onsubmit="return false" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label>底薪</label>
                                    <input class="form-control" type="text" name="dixin"/>
                                </div>
                                 {{csrf_field()}}
                                <button type="submit" class="btn ">添加</button>
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
    $('.btn').click(function(){
        var dixin = $('input[name="dixin"]').val();
        if(dixin == ""){
            alert('底薪不能为空');
            return false;
        }
        $.ajax({
            type:"get",
            url:'/doadddixin',
            data:{
            dixin:dixin,
        },
        success:function(msg){
                if(msg == 1){
                    alert('添加成功');
                }else {
                    
                    alert('底薪已存在');
                }
            }
        });

    });

</script>

