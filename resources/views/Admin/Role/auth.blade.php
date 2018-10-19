
@extends("Admin.AdminPublic.adminpublic")
@section("admin")
<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    当前角色:{{$role->name}}的权限信息
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form"  action="/saveauth" method="post" enctype="multipart/form-data">
                                
                                <div class="form-group">
                                @foreach($node as $row)
                                    <label>{{$row->name}}</label>
                                    <input type="checkbox" name="nids[]" value="{{$row->id}}" @if(in_array($row->id,$nids)) checked @endif/>
                                @endforeach
                                </div>
                                <!-- 
                                <div class="form-group">
                                    <label>File input</label>
                                    <input type="file">
                                </div>
                                 -->
                                 {{csrf_field()}}
                                 <input type="hidden" name="rid" value="{{$role->id}}">
                                <button type="submit" class="btn ">分配权限</button>
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
@section('title','权限信息')