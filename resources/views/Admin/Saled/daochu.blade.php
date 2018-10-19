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
                        <form action="/dosaled_daochu" method="post" enctype="multipart/form-data">
                        <div class="col-lg-6">
                            <label>微信名</label>
                        <label>
                            <input type="search" class="form-control input-sm date" value="{{$map[1][2] or ''}}" name='wxname'>
                        </label>
                       <label>本金金额</label>
                        <label>
                            <input type="search" class="form-control input-sm date" value="{{$map[2][2] or ''}}" placeholder='大于'  name='fbig'>
                        </label>
                        <label>
                            <input type="search" class="form-control input-sm date" value="{{$map[3][2] or ''}}" placeholder='小于'  name='fsmall'>
                        </label>
                        <label>
                            <select class="form-control input-sm" name="phoneid">
                                <option value="">所在手机编号</option>
                                @foreach($phone as $va)
                                <option value="{{$va->id}}" @if($va->id==session('pid')) selected @endif >{{$va->phonenum}}</option>
                                @endforeach
                            </select>
                        </label>
                        <label>
                            <select class="form-control input-sm" name="fphone">
                                <option value="">赔偿手机编号</option>
                                @foreach($phone as $vc)
                                <option value="{{$vc->id}}"  @if($vc->id==session('fpid')) selected @endif>{{$vc->phonenum}}</option>
                                @endforeach
                            </select>
                        </label>
                        <br>
                        <label>旺旺号</label>
                        <label>
                            <input type="search" class="form-control input-sm date" value="{{$map[6][2] or ''}}"  name='wname'>
                        </label>
                        <label>赔偿金额</label>
                        <label>
                            <input type="search" class="form-control input-sm date" value="{{$map[7][2] or ''}}"  placeholder='大于'  name='sbig'>
                        </label>
                        <label>
                            <input type="search" class="form-control input-sm date" value="{{$map[8][2] or ''}}"  placeholder='小于'  name='ssmall'>
                        </label>
                        <label>
                            <select class="form-control input-sm" name="fuserid">
                                <option value="">请选择放单人</option>
                                @foreach($fuser as $value)
                                <option value="{{$value->fid}}" @if($value->fid==session('fud')) selected @endif>{{$value->fname}}</option>
                                @endforeach
                            </select>
                        </label>
                        <label>
                            <select class="form-control input-sm" name="result">
                                <option value="">处理结果</option>
                                <option value="1" @if(session('result')==1) selected @endif>处理成功</option>
                                <option value="2" @if(session('result')==2) selected @endif>处理中</option>
                                <option value="3" @if(session('result')==3) selected @endif>处理失败</option>
                            </select>
                        </label>
                        <br>
                        <label>订单号</label>
                        <label>
                            <input type="search" class="form-control input-sm date" value="{{$map[11][2] or ''}}"  name='orders'>
                        </label>
                        <label>发生日期</label>
                        <label>
                            <input type="search" class="form-control input-sm date" value="{{$map[12][2] or ''}}"  placeholder='开始:20180911' name='hbig'>
                        </label>
                        <label>
                            <input type="search" class="form-control input-sm date" value="{{$map[13][2] or ''}}"  placeholder='结束:20180911' name='hsmall'>
                        </label>
                        <label>
                            <select class="form-control input-sm" name="huohao">
                                <option value="">货号</option>
                                @foreach($huohao as $val)
                                <option value="{{$val->id}}" @if($val->id==session('hh')) selected @endif>{{$val->huohao}}</option>
                                @endforeach
                            </select>
                        </label>
                        <label>
                            <select class="form-control input-sm sh" name="shopid">
                                <option value="">店铺</option>
                                @foreach($shop as $ve)
                                <option value="{{$ve->id}}" @if($val->id==session('shp')) selected @endif>{{$ve->shopname}}</option>
                                @endforeach
                            </select>
                        </label>

                            {{csrf_field()}}
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
                        //财务对账
                        // alert($);
                        $('.liyao').click(function(){
                            // $('input[type="checkbox"]').attr('checked',false);
                            $('input[name="6"]').prop('checked',true);
                            $('input[name="9"]').prop('checked',true);
                            $('input[name="11"]').prop('checked',true);
                            $('input[name="1"]').prop('checked',false);
                            $('input[name="2"]').prop('checked',false);
                            $('input[name="3"]').prop('checked',false);
                            $('input[name="4"]').prop('checked',false);
                            $('input[name="5"]').prop('checked',false);
                            $('input[name="7"]').prop('checked',false);
                            $('input[name="8"]').prop('checked',false);
                            $('input[name="10"]').prop('checked',false);
                            $('input[name="12"]').prop('checked',true);
                            $('input[name="13"]').prop('checked',true);
                            $('input[name="14"]').prop('checked',true);
                            $('input[name="15"]').prop('checked',false);
                            $('input[name="16"]').prop('checked',false);
                            $('input[name="17"]').prop('checked',false);
                            $('input[name="18"]').prop('checked',true);
                            $('input[name="19"]').prop('checked',false);
                            $('input[name="21"]').prop('checked',true);
                            // alert(66);

                        });
                        $('.shangjia').click(function(){
                            // $('input[type="checkbox"]').attr('checked',false);
                            $('input[name="3"]').prop('checked',true);
                            $('input[name="5"]').prop('checked',true);
                            $('input[name="9"]').prop('checked',true);
                            $('input[name="11"]').prop('checked',true);
                            $('input[name="1"]').prop('checked',false);
                            $('input[name="2"]').prop('checked',true);
                            $('input[name="4"]').prop('checked',false);
                            $('input[name="6"]').prop('checked',true);
                            $('input[name="7"]').prop('checked',false);
                            $('input[name="8"]').prop('checked',false);
                            $('input[name="10"]').prop('checked',false);
                            $('input[name="12"]').prop('checked',true);
                            $('input[name="13"]').prop('checked',false);
                            $('input[name="14"]').prop('checked',true);
                            $('input[name="15"]').prop('checked',true);
                            $('input[name="16"]').prop('checked',false);
                            $('input[name="17"]').prop('checked',false);
                            $('input[name="18"]').prop('checked',true);
                            $('input[name="19"]').prop('checked',false);
                            $('input[name="21"]').prop('checked',false);
                            // alert(66);

                        });
                        $('.buxuan').click(function(){
                            $('input[type="checkbox"]').prop('checked',false);
                        });
                        $('.quanxuan').click(function(){
                            $('input[type="checkbox"]').prop('checked',true);
                        });
                        

</script>
@endsection
@section('title','日常试用任务导出')
