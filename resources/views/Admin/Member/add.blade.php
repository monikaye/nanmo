


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
                            <form role="form"  action="/member" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>微信备注名</label>
                                    <input class="form-control" type="text" name="username"/>
                                </div>
                                <div class="form-group">
                                    <label>手机编号</label>
                                    <select class="form-control" name="phoneid">
                                        <option value="">请选择</option>
                                        @foreach($phone as $value)
                                        <option value="{{$value->id}}">{{$value->phonenum}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>试用人旺旺号</label>
                                    <input class="form-control" type="text" name="wwname"/>
                                </div>
                                <div class="form-group">
                                    <label>订单号</label>
                                    <input class="form-control" type="number" name="orders"/>
                                </div>
                                <div class="form-group">
                                    <label>淘气值</label>
                                    <input class="form-control" type="number" name="tqnum"/>
                                </div>
                                <div class="form-group">
                                    <label>货号</label>
                                    <select class="form-control" name="huohao">
                                        <option value="">请选择</option>
                                        @foreach($huohao as $va)
                                        <option value="{{$va->id}}">{{$va->huohao}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>性别</label>
                                    <select class="form-control" name="sex">
                                        <option value="1">男</option>
                                        <option value="2">女</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>是否偏远地区</label>
                                    <select class="form-control" name="ifyuan">
                                        <option value="1">是</option>
                                        <option value="2">不是</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>付款金额</label>
                                    <input class="form-control" type="text" name="fmoney"/>
                                </div>
                                <div class="form-group">
                                    <label>佣金</label>
                                    <input class="form-control" type="text" name="ymoney"/>
                                </div>
                                <div class="form-group">
                                    <label>是否超级会员</label>
                                    <select class="form-control" name="ifsuper">
                                        <option value="1">是</option>
                                        <option value="2">不是</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>礼物</label>
                                    <input class="form-control" type="text" name="gift"/>
                                </div>
                                <div class="form-group">
                                    <label>放单人</label>
                                    <select class="form-control" name="fuserid">
                                        <option value="">请选择</option>
                                        @foreach($fuser as $val)
                                        <option value="{{$val->id}}">{{$val->username}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>绩效</label>
                                    <input class="form-control" type="text" name="jixiao"/>
                                </div>
                                <div class="form-group">
                                    <label>试用时间格式:20180917</label>
                                    <input class="form-control" type="number" name="shuadan_time"/>
                                </div>
                                
                                <div class="form-group">
                                    <label>备注</label>
                                    <textarea class="form-control" rows="3" name="remark"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>付款手机</label>
                                    <select class="form-control" name="fphone">
                                        <option value="0">请选择</option>
                                        @foreach($phone as $value)
                                        <option value="{{$value->id}}">{{$value->phonenum}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>额外付款金额</label>
                                    <input class="form-control" type="text" name="extra"/>
                                </div>

                                <!-- 
                                <div class="form-group">
                                    <label>File input</label>
                                    <input type="file">
                                </div>
                                 -->
                                 {{csrf_field()}}
                                <button type="submit" class="btn btn-default">添加</button>
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
@section('title','日常试用任务添加')