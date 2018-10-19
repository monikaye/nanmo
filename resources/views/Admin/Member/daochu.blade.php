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
                        <form action="/daochu" method="post" enctype="multipart/form-data">
                        <div class="col-lg-6">
                            <label>淘气的值</label>
                            <label>
                                <input type="search" class="form-control input-sm date" placeholder='大于' value="" name='bigt'>
                            </label>
                            <label>
                                <input type="search" class="form-control input-sm date" placeholder='小于' value="" name='smallt'>
                            </label>
                            <label>
                                <select class="form-control input-sm" name="phoneid">
                                    <option value="">所在手机编号</option>
                                    @foreach($phone as $va)
                                    <option value="{{$va->id}}">{{$va->phonenum}}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label>备注名</label>
                            <label>
                                <input type="search" class="form-control input-sm date" value="" name='username'>
                            </label>
                            <br>
                            <label>佣金金额</label>
                            <label>
                                <input type="search" class="form-control input-sm date" placeholder='大于' value="" name='bigy'>
                            </label>
                            <label>
                                <input type="search" class="form-control input-sm date" placeholder='小于' value="" name='smally'>
                            </label>
                            <label>
                                <select class="form-control" name="ifyuan">
                                        <option value="">是否偏远地区</option>
                                        <option value="1">是</option>
                                        <option value="2">不是</option>
                                        <option value="3">未知</option>
                                </select>
                            </label>
                            <label>旺旺号</label>
                            <label>
                                <input type="search" class="form-control input-sm date" value="" name='wwname'>
                            </label>
                            
                            <br>
                            <label>绩效金额</label>
                            <label>
                                <input type="search" class="form-control input-sm date" placeholder='大于' value="" name='bigj'>
                            </label>
                            <label>
                                <input type="search" class="form-control input-sm date" placeholder='小于' value="" name='smallj'>
                            </label>
                            <label>
                                <select class="form-control input-sm" name="fphone">
                                    <option value="">付款手机编号</option>
                                    @foreach($phone as $vc)
                                    <option value="{{$vc->id}}">{{$vc->phonenum}}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label>订单号</label>
                            <label>
                                <input type="search" class="form-control input-sm date" value="" name='orders'>
                            </label>
                            <br>
                            <label>付款金额</label>
                            <label>
                                <input type="search" class="form-control input-sm date" placeholder='大于' value="" name='bigf'>
                            </label>
                            <label>
                                <input type="search" class="form-control input-sm date" placeholder='小于' value="" name='smallf'>
                            </label>
                            <label>
                                <select class="form-control" name="ifsuper">
                                        <option value="">是否超级会员</option>
                                        <option value="1">是</option>
                                        <option value="2">不是</option>
                                        <option value="3">未知</option>
                                </select>
                            </label>
                            <label>礼物&nbsp;&nbsp;&nbsp;</label>
                            <label>
                                <input type="search" class="form-control input-sm date" value="" name='gift'>
                            </label>
                            <br>
                            <label>额外付款</label>
                            <label>
                                <input type="search" class="form-control input-sm date" placeholder='大于' value="" name='bige'>
                            </label>
                            <label>
                                <input type="search" class="form-control input-sm date" placeholder='小于' value="" name='smalle'>
                            </label>
                            <label>
                                <select class="form-control input-sm" name="fuserid">
                                    <option value="">请选择放单人</option>
                                    @foreach($fuser as $value)
                                    <option value="{{$value->fid}}">{{$value->fname}}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label>备注&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <label>
                                <input type="search" class="form-control input-sm date" value="" name='remark'>
                            </label>
                            <br>
                            <label>放单日期</label>
                            <label>
                                <input type="search" class="form-control input-sm date" placeholder='开始:20180911' value="" name='start'>
                            </label>
                            <label>
                                <input type="search" class="form-control input-sm date" placeholder='结束:20180911' value="" name='stop'>
                            </label>
                            <label>
                                <select class="form-control input-sm" name="sex">
                                    <option value="">性别</option>
                                    <option value="1">男</option>
                                    <option value="2">女</option>
                                    <option value="3">未知</option>
                                </select>
                            </label>
                            <label>
                                <select class="form-control input-sm" name="huohao">
                                    <option value="">货号</option>
                                    @foreach($huohao as $val)
                                    <option value="{{$val->id}}">{{$val->huohao}}</option>
                                    @endforeach
                                </select>
                            </label>
                            <br>
                            <label>
                                <select class="form-control input-sm" name="shopid[]" multiple="multiple"  style="height:300px;">
                                    <option value="" >请选择店铺</option>
                                    @foreach($shop as $values)
                                        <option value="{{$values->id}}">{{$values->shopname}}</option>
                                    @endforeach
                                </select>
                            </label>
                             
                        </div>
                        <div class="col-lg-6">
                            <label>选择要导出的字段</label><br>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='1' value="username">微信备注名
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='2' value="phoneid">所在手机编号
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='3' value="orders">订单号
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='4' value="tqnum">淘气值
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='5' value="wwname">旺旺号
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='6' value="shopid">店铺名
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='7' value="sex">性别
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='8' value="ifyuan">偏远地区
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='9' value="fmoney">付款金额
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='10' value="ifsuper">超级会员
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='11' value="ymoney">佣金
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='12' value="fuserid">放单人
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='13' value="jixiao">绩效
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='14' value="huohao">货号
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='15' value="remark">备注
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='16' value="fphone">付款手机
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='17' value="extra">额外付款金额
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='18' value="shuadan_time">试用日期
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name='19' value="userid">录入人
                            </label>
			                <label class="checkbox-inline">
                                <input type="checkbox" name='20' value="gift">礼品
                            </label>
                            <label class="checkbox-inline" style="display:none;">
                                <input type="checkbox" name='21' value="zmoney">操作费
                            </label>
			                <br><br>
                            <label class="checkbox-inline">
                                <a class="btn liyao" >财务对账表</a><a class="btn shangjia">商家反馈表</a><a class="btn quanxuan">全选</a><a class="btn buxuan">不选</a>
                            </label>
                            <br><br><br><br>

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
