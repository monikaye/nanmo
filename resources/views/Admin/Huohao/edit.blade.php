


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
                            <form role="form"  action="/huohao/{{$info->id}}" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>对应店铺</label>
                                    <select class="form-control" name="shopid">
                                        @foreach($shop as $values)
                                        <option value="{{$values->id}}" @if($info->shopid==$values->id) selected  @endif >{{$values->shopname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>货号</label>
                                    <input class="form-control" type="text" name="huohao" value='{{$info->huohao}}'/>
                                </div>
                                <div class="form-group">
                                    <label>操作费</label>
                                    <input class="form-control" type="text" name="zmoney" value='{{$info->zmoney}}'/>
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
@section('title','手机卡修改')