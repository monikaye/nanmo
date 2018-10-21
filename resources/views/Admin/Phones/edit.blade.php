
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
                            <form role="form"  action="/phones" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label>手机编号</label>
                                    <select class="form-control" name="phoneid">
                                        @foreach($phone as $value)
                                        <option value="{{$value->id}}" @if($value->id==$info->phoneid) selected @endif>{{$value->phonenum}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                    
                                <div class="form-group">
                                    <label>商家</label>
                                    <input class="form-control" type="text" name="shopmark" value="{{$info->shopmark}}"/>
                                </div>  
                                <div class="form-group">
                                    <label>日发单量</label>
                                    <input class="form-control" type="number" name="countday" value="{{$info->countday}}"/>
                                </div>
                                <div class="form-group">
                                    <label>已发卡片数量</label>
                                    <input class="form-control" type="number" name="fcard" value="{{$info->fcard}}"/>
                                </div>
                                <div class="form-group">
                                    <label>绑定卡号</label>
                                    <select class="form-control" name="cardid">
                                        @foreach($cards as $v)
                                        <option value="{{$v->id}}" @if($v->id==$info->cardid) selected @endif>{{$v->cardnumber}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>银行卡余额</label>
                                    <input class="form-control" type="text" name="cmoney"  value="{{$info->cmoney}}"/>
                                </div>
                                <div class="form-group">
                                    <label>微信余额</label>
                                    <input class="form-control" type="text" name="wxmoney" value="{{$info->wxmoney}}"/>
                                </div>
                                <!-- 
                                <div class="form-group">
                                    <label>File input</label>
                                    <input type="file">
                                </div>
                                 -->
                                 {{csrf_field()}}
                                <button type="submit" class="btn ">修改</button>
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
@section('title','手机信息修改')