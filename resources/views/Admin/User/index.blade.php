@extends("Admin.AdminPublic.adminpublic")
@section("admin")
<div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     <h2>会员列表</h2>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>账号</th>
                                    
                                    
                                    <th>状态</th>
                                    <th>添加时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
								@foreach($info as $value)
                                <tr class="odd gradeX">
									
                                    <td>{{$value->username}}</td>
                                    
                                    
                                    @if($value->status==1)
                                    <td>开启</td>
                                    @elseif($value->status==2)
                                    <td>关闭</td>
                                    @endif
                                    <td><?php echo date('Y-m-d',$value->create_time) ?></td>
                                    <td>
                                        <a href="/rolelist/{{$value->id}}" class="btn btn-danger">分配角色</a>
                                    	<form action="/user/{{$value->id}}" method="post" class='btn'>
							                <button class="btn btn-danger">删除</button>{{csrf_field()}}{{method_field("DELETE")}}
							            </form>
                                        <a href="/user/{{$value->id}}/edit" class="btn btn-info">修改</a>
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!!$info->appends($request)->render()!!}
                    
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
</div>
                <!-- /. ROW  -->
@endsection
@section('title','会员列表')