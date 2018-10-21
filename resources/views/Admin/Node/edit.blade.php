


@extends("Admin.AdminPublic.adminpublic")
@section("admin")
<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form"  action="/node/{{$node->id}}" method="post" enctype="multipart/form-data">
                                
                                <div class="form-group">
                                    <label>节点名</label>
                                    <input class="form-control" type="text" name="shopname" value='{{$node->name}}'/>
                                </div>
                                <div class="form-group">
                                    <label>控制器</label>
                                    <input class="form-control" type="text" name="mname" value='{{$node->mname}}'/>
                                </div>
                                <div class="form-group">
                                    <label>方法</label>
                                    <input class="form-control" type="text" name="aname" value='{{$node->aname}}'/>
                                </div>
                                <div class="form-group">
                                    <label>状态</label>
                                    <select class="form-control" name="status">
                                        <option value="0" @if($node->status == 0) selected @endif>开启</option>
                                        <option value="1" @if($node->status == 1) selected @endif>关闭</option>
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
@section('title','节点修改')