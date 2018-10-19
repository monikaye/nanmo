
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
                            <form role="form"  action="/phone" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label>手机编号</label>
                                    <input class="form-control" type="number" name="phonenum"/>
                                </div>
                                <div class="form-group">
                                    <label>手机号码</label>
                                    <input class="form-control" type="number" name="number"/>
                                </div>
                                
                                <div class="form-group">
                                    <label>微信号</label>
                                    <input class="form-control" type="text" name="wxnumber"/>
                                </div>
                                
                                <div class="form-group">
                                    <label>微信余额</label>
                                    <input class="form-control" type="text" name="money" value="0.00"/>
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
@section('title','手机添加')