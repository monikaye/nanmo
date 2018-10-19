


@extends("Admin.AdminPublic.adminpublic")
@section("admin")
<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit
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
                            <form role="form"  action="/member/{{$info->id}}" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>微信备注名</label>
                                    <input class="form-control" type="text" name="username" value="{{$info->username}}"/>
                                </div>
                                <div class="form-group">
                                    <label>手机编号</label>
                                    <select class="form-control" name="phoneid">
                                        @foreach($phone as $value)
                                        <option value="{{$value->id}}" @if($info->phoneid==$value->id) selected @endif>{{$value->phonenum}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>刷单人旺旺号</label>
                                    <input class="form-control" type="text" name="wwname"  value="{{$info->wwname}}"/>
                                </div>
                                <div class="form-group">
                                    <label>订单号</label>
                                    <input class="form-control" type="number" name="orders"  value="{{$info->orders}}"/>
                                </div>
                                <div class="form-group">
                                    <label>淘气值</label>
                                    <input class="form-control" type="number" name="tqnum"  value="{{$info->tqnum}}"/>
                                </div>
                                <div class="form-group">
                                    <label>货号</label>
                                    <select class="form-control" name="huohao">
                                        @foreach($huohao as $val)
                                        <option value="{{$val->id}}" @if($info->huohao==$val->id) selected @endif>{{$val->huohao}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>性别</label>
                                    <select class="form-control" name="sex">
                                        <option value="1" @if($info -> sex == 1 ) selected @endif>男</option>
                                        <option value="2" @if($info -> sex == 2 ) selected @endif>女</option>
				       <option value="3" @if($info -> sex == 3 ) selected @endif>未知</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>是否偏远地区</label>
                                    <select class="form-control" name="ifyuan">
                                        <option value="1" @if($info -> ifyuan == 1 ) selected @endif>是</option>
                                        <option value="2" @if($info -> ifyuan == 2 ) selected @endif>不是</option>
				       <option value="3" @if($info -> ifyuan == 3 ) selected @endif>未知</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>付款金额</label>
                                    <input class="form-control" type="text" name="fmoney" value="{{$info->fmoney}}"/>
                                </div>
                                <div class="form-group">
                                    <label>佣金</label>
                                    <input class="form-control" type="text" name="ymoney" value="{{$info->ymoney}}"/>
                                </div>
                                <div class="form-group">
                                    <label>是否超级会员</label>
                                    <select class="form-control" name="ifsuper">
                                        <option value="1" @if($info -> ifsuper == 1 ) selected @endif>是</option>
                                        <option value="2" @if($info -> ifsuper == 2 ) selected @endif>不是</option>
				       <option value="3" @if($info -> ifsuper == 3 ) selected @endif>未知</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>礼物</label>
                                    <input class="form-control" type="text" name="gift" value="{{$info->gift}}"/>
                                </div>
                                <div class="form-group">
                                    <label>放单人</label>
                                    <input class="form-control" type="text" name="fuserid" value="{{$info->fuserid}}"/>
                                </div>
                                <div class="form-group">
                                    <label>绩效</label>
                                    <input class="form-control" type="text" name="jixiao" value="{{$info->jixiao}}"/>
                                </div>
                                <div class="form-group">
                                    <label>试用时间</label>
                                    <input class="form-control" type="number" name="shuadan_time" value="{{$info->shuadan_time}}"/>
                                </div>
                                <div class="form-group">
                                    <label>备注</label>
                                    <textarea class="form-control" rows="3" name="remark" >{{$info->remark}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>付款手机</label>
                                    <select class="form-control" name="fphone">
                                        @foreach($phone as $value)
                                        <option value="{{$value->id}}" @if($info->fphone==$value->id) selected @endif>{{$value->phonenum}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>额外付款金额</label>
                                    <input class="form-control" type="text" name="extra" value="{{$info->extra}}"/>
                                </div>
                                <!-- 
                                <div class="form-group">
                                    <label>File input</label>
                                    <input type="file">
                                </div>
                                 -->
                                 {{method_field("PUT")}}
                                 {{csrf_field()}}
                                <button type="submit" class="btn btn-default">修改</button>
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
@section('title','日常试用任务修改')