


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
                            <form role="form"  action="/card/{{$info->id}}" method="post" enctype="multipart/form-data">
                                
                                <div class="form-group">
                                    <label>银行卡号</label>
                                    <input class="form-control" type="number" name="number" value="{{$info->number}}"/>
                                </div>
                                <div class="form-group">
                                    <label>银行卡卡主</label>
                                    <input class="form-control" type="text" name="cardname" value="{{$info->cardname}}"/>
                                </div>
                                <div class="form-group">
                                    <label>卡内金额</label>
                                    <input class="form-control" type="text" name="money" value="{{$info->money}}"/>
                                </div>
                                @foreach($pho as $v)
                                <div class="form-group">
                                    <label>手机编号及余额:{{$v->phonenum}}</label>
                                    <input class="form-control" type="text" name="{{$v->id}}" value="{{$v->money}}"/>
                                </div>
                                @endforeach
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
@section('title','修改银行卡信息')