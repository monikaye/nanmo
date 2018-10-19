
@extends("Admin.AdminPublic.adminpublic")
@section("admin")
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
                            <form role="form"  action="/saledadd" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>微信备注</label>
                                    <input class="form-control" type="text" name="wxname"/>
                                </div>
                                <div class="form-group">
                                    <label>发生日期</label>
                                    <input class="form-control" type="number" name="hap_time"/>
                                </div>
                                <div class="form-group">
                                    <label>放单人</label>
                                    <select class="form-control" name="fuserid">
                                        <option value="">请选择</option>
                                        @foreach($fuser as $f)
                                        <option value="{{$f->id}}">{{$f->username}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>所在手机编号</label>
                                    <select class="form-control" name="phoneid">
                                        <option value="">请选择</option>
                                        @foreach($phone as $values)
                                        <option value="{{$values->id}}">{{$values->phonenum}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>原因</label>
                                    <input class="form-control" type="text" name="why"/>
                                </div>
                                <div class="form-group">
                                    <label>赔偿手机</label>
                                    <select class="form-control" name="fphone">
                                        <option value="">请选择</option>
                                        @foreach($phone as $values)
                                        <option value="{{$values->id}}">{{$values->phonenum}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>赔偿金额</label>
                                    <input class="form-control" type="text" name="smoney"/>
                                </div>
                                <div class="form-group">
                                    <label>完结日期</label>
                                    <input class="form-control" type="number" name="over_time"/>
                                </div>
                                <div class="form-group">
                                    <label>旺旺号</label>
                                    <input class="form-control" type="text" name="wwname"/>
                                </div>
                                <div class="form-group">
                                    <label>店铺名</label>
                                    <select class="form-control" name="shopid">
                                        <option value="">请选择</option>
                                        @foreach($shop as $val)
                                        <option value="{{$val->id}}">{{$val->shopname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label>货号</label>
                                    <select class="form-control" name="huohaoid">
                                        <option value="">请选择</option>
                                        @foreach($huohao as $val)
                                        <option value="{{$val->id}}">{{$val->huohao}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>本金</label>
                                    <input class="form-control" type="text" name="fmoney"/>
                                </div>
                                <div class="form-group">
                                    <label>订单号</label>
                                    <input class="form-control" type="text" name="orders"/>
                                </div>
                                
                                <div class="form-group">
                                    <label>处理结果</label>
                                    <select class="form-control" name="result">
                                        <option value="1">处理成功</option>
                                        <option value="2">处理中</option>
                                        <option value="3">处理失败</option>
                                    </select>
                                </div>
                                
                                <!-- 
                                <div class="form-group">
                                    <label>File input</label>
                                    <input type="file">
                                </div>
                                 -->
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

@endsection
@section('title','售后表添加')