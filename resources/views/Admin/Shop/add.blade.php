
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
                            <form role="form"  action="/shop" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label>店铺名称</label>
                                    <input class="form-control" type="text" name="shopname"/>
                                </div>
                                <div class="form-group">
                                    <label>店铺编码</label>
                                    <input class="form-control" type="text" name="bianma"/>
                                </div>
                                <div class="form-group">
                                    <label>店铺礼品</label>
                                    <input class="form-control" type="text" name="gift"/>
                                </div>
                                <div class="form-group">
                                    <label>特殊备注</label>
                                    <input class="form-control" type="text" name="remark"/>
                                </div>
                                <div class="form-group">
                                    <label>店铺地址</label>
                                    <input class="form-control" type="text" name="address"/>
                                </div>
                                <div class="form-group">
                                    <label>后台账号备注</label>
                                    <input class="form-control" type="text" name="htzh"/>
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
@section('title','商铺添加')