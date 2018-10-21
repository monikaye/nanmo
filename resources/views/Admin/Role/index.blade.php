@extends("Admin.AdminPublic.adminpublic")
@section("admin")
<div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     <h2>角色列表</h2>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>角色名</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
							@foreach($datal as $row)
                            <tr> 
                                <td>{{$row->id}}</td> 
                                <td>{{$row->name}}</td> 
                                <td>
                                  <a href="/auth/{{$row->id}}" class="btn btn-danger">分配权限</a>
                                  <form action="/role/{{$row->id}}" method="post" class="btn">
                                        {{method_field("DELETE")}} {{csrf_field()}}
                                        <button class="btn btn-success del" name="{{$row->id}}">删除</button>
                                  </form> 
                                        <a href="/role/{{$row->id}}/edit" class="btn btn-info">修改</a>
                                </td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
</div>
                <!-- /. ROW  -->
@endsection
@section('title','角色列表')