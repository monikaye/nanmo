
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
                            <form role="form"  action="/phones" method="post" enctype="multipart/form-data">

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
                                    <label>商家</label>
                                    <input class="form-control" type="text" name="shopmark"/>
                                </div>    
                                
                                <div class="form-group">
                                    <label>日发单量</label>
                                    <input class="form-control" type="number" name="countday"/>
                                </div>
                                <div class="form-group">
                                    <label>已发卡片数量</label>
                                    <input class="form-control" type="number" name="fcard"/>
                                </div>
                                <div class="form-group">
                                    <label>绑定卡号</label>
                                    <select class="form-control" name="cardid">
                                        <option value="">请选择</option>
                                        @foreach($cards as $v)
                                        <option value="{{$v->id}}">{{$v->cardnumber}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>银行卡余额</label>
                                    <input class="form-control" type="text" name="cmoney"/>
                                </div>
                                <div class="form-group">
                                    <label>微信余额</label>
                                    <input class="form-control" type="text" name="wxmoney"/>
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
@section('title','手机信息添加')