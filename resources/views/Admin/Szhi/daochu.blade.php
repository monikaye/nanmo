@extends("Admin.AdminPublic.adminpublic")
@section("admin")
<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    导出
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
                        <form action="/doshopdaochu" method="post" enctype="multipart/form-data">
                        <div class="col-lg-12">
                            <label>放单日期</label>
                            <label>
                                <input type="search" class="form-control input-sm date" placeholder='开始:20180911' value="" name='start'>
                            </label>
                            <label>
                                <input type="search" class="form-control input-sm date" placeholder='结束:20180911' value="" name='stop'>
                            </label>
                            <label>
                                <select class="form-control input-sm" name="shopid">
                                    <option value="">请选择店铺</option>
                                    @foreach($shop as $values)
                                    <option value="{{$values->id}}">{{$values->shopname}}</option>
                                    @endforeach
                                </select>
                            
                            </label>
                            
                            <br>
                            <label>选择要导出的字段</label><br>
                            
                            <label class="checkbox-inline">
                                <input type="checkbox" name='1' value="shopid">店铺名
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='2' value="f">本金
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='3' value="y">礼品红包
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='4' value="huohao">操作费
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='5' value="num">单数
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='6' value="cou">应收款
                            </label>
                            
                            <label class="checkbox-inline">
                                <input type="checkbox" name='7' value="shuadan_time">刷单日期
                            </label><br><br><br><br><br><br>
                            {{csrf_field()}}
                            <a class="btn btn-info quanxuan">全选</a>
                            <button type="submit" class="btn btn-info">导出</button>
                        </div>
                        </form>
                        
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
    
            $('.quanxuan').click(function(){
                            $('input[type="checkbox"]').prop('checked',true);
            });


</script>

@endsection
@section('title','店铺汇总导出')