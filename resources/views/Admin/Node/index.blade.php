@extends("Admin.AdminPublic.adminpublic")
@section("admin")
<div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     <h2>节点信息</h2>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>节点ID</th>
                                    <th>节点名</th>
                                    <th>控制器</th>
                                    <th>方法</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
								    @foreach($data as $row)
                                    <tr> 
                                        <td>{{$row->id}}</td> 
                                        <td>{{$row->name}}</td> 
                                        <td>{{$row->mname}}</td> 
                                        <td>{{$row->aname}}</td>
                                        @if($row->status==1)
                                        <td>开启</td> 
                                        @elseif($row->status==2)
                                        <td>关闭</td> 
                                        @endif 
                                        <td>
                                           
                                           <form action="/node/{{$row->id}}" method="post" class="btn">
                                                {{method_field("DELETE")}} {{csrf_field()}}
                                                <button class="btn btn-success del" name="{{$row->id}}">删除</button>
                                           </form> 
                                            <a href="/node/{{$row->id}}/edit" class="btn btn-info">修改</a>
                                        </td>
                                   </tr>
                                   @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!!$data->appends($request)->render()!!}
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
</div>
                <!-- /. ROW  -->
@endsection
@section('title','节点表')