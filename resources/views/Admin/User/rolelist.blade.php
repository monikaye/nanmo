
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
                            <form role="form"  action="/saverole" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label>角色信息</label>
                                    @foreach($role as $row)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="rids[]" value="{{$row->id}}" @if(in_array($row->id,$rids))checked @endif> {{$row->name}}
                                        </label>
                                    </div>
                                    @endforeach 
                                    
                                </div>
                                <!-- 
                                <div class="form-group">
                                    <label>File input</label>
                                    <input type="file">
                                </div>
                                 -->
                                {{csrf_field()}}
                                <input type="hidden" name="uid" value="{{$info->id}}">
                                <button type="submit" class="btn ">分配角色</button>
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
@section('title','角色信息')