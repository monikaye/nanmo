
@extends("Admin.AdminPublic.adminpublic")
@section("admin")
<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form"  action="/node" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label>节点名</label>
                                    <input class="form-control" type="text" name="name"/>
                                </div>
                                <div class="form-group">
                                    <label>控制器</label>
                                    <input class="form-control" type="text" name="mname"/>
                                </div>
                                <div class="form-group">
                                    <label>方法</label>
                                    <input class="form-control" type="text" name="aname"/>
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
@section('title','节点添加')