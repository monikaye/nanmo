


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
                            <form role="form"  action="/shop/{{$info->id}}" method="post" enctype="multipart/form-data">
                                
                                <div class="form-group">
                                    <label>店铺名称</label>
                                    <input class="form-control" type="text" name="shopname" value='{{$info->shopname}}'/>
                                </div>
                                <div class="form-group">
                                    <label>店铺编码</label>
                                    <input class="form-control" type="text" name="bianma" value='{{$info->bianma}}'/>
                                </div>
                                <div class="form-group">
                                    <label>商铺地址</label>
                                    <input class="form-control" type="text" name="address" value='{{$info->address}}'/>
                                </div>
                                <div class="form-group">
                                    <label>店铺礼品</label>
                                    <input class="form-control" type="text" name="gift" value='{{$info->gift}}'/>
                                </div>
                                <div class="form-group">
                                    <label>特殊备注</label>
                                    <input class="form-control" type="text" name="remark" value='{{$info->remark}}'/>
                                </div>
                                <div class="form-group">
                                    <label>后台账号备注</label>
                                    <input class="form-control" type="text" name="htzh" value='{{$info->htzh}}'/>
                                </div>
                                <div class="form-group">
                                    <label>状态</label>
                                    <select class="form-control" name="status">
                                        <option value="1" @if($info -> status == 1 ) selected @endif>启用</option>
                                        <option value="2" @if($info -> status == 2 ) selected @endif>禁用</option>
                                    </select>
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
@section('title','修改银行卡信息')